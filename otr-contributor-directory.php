<?php
/*
Plugin Name: OTR Contributor Directory
Description: Displays contributor (actor, writer, etc.) pages with grouped episode listings by show and year.
Version: 1.1.6
Author: Andrew Rhynes
Author URI: https://otrwesterns.com
GitHub Plugin URI: https://github.com/eagle4life69/otr-contributor-directory

== Changelog ==
= 1.1.6 =
* Switch native updater to the latest published GitHub Release
* Reduce GitHub release metadata cache to 15 minutes

= 1.1.5 =
* Add WordPress auto-update toggle support for the custom GitHub updater

= 1.1.4 =
* Include scheduled (future) episodes in contributor listings
* Add native GitHub update support
*/

if (!defined('ABSPATH')) exit;

define('OCD_VERSION', '1.1.6');
define('OCD_PLUGIN_FILE', __FILE__);
require_once __DIR__ . '/github-updater.php';

function ocd_register_contributor_cpt() {
    register_post_type('contributor', [
        'labels' => ['name' => 'Contributors', 'singular_name' => 'Contributor'],
        'public' => true, 'has_archive' => false,
        'rewrite' => ['slug' => 'contributor'],
        'supports' => ['title', 'editor', 'thumbnail'], 'show_in_rest' => true,
    ]);
}
add_action('init', 'ocd_register_contributor_cpt');

function ocd_render_contributor($atts) {
    $atts = shortcode_atts(['name' => ''], $atts);
    if (!$atts['name']) return '<p>No contributor specified.</p>';
    $tags = array_map('trim', explode(',', $atts['name']));
    $query = new WP_Query(['post_type'=>'post','posts_per_page'=>-1,'post_status'=>['publish','future'],'tag_slug__in'=>$tags]);
    $episodes_by_show=[]; $seen_post_ids=[];
    while ($query->have_posts()) {
        $query->the_post(); $post_id=get_the_ID();
        if(isset($seen_post_ids[$post_id])) continue; $seen_post_ids[$post_id]=true;
        $full=get_the_title(); preg_match('/\((\d{2})-(\d{2})-(\d{2})\)$/',$full,$m);
        $month=$m[1]??''; $day=$m[2]??''; $year=$m[3]??'';
        $date=($month&&$day&&$year)?"$month-$day-19$year":''; $sortable=($year&&$month&&$day)?intval("19$year$month$day"):0; $year_full=$year?"19$year":'Unknown';
        $parts=strpos($full,' | ')!==false?explode(' | ',$full):explode(' – ',$full); $title=$parts[0];
        $meta=get_post_meta($post_id,'enclosure',true); $mp3=''; $eid='';
        if($meta){foreach(explode("\n",$meta) as $ln){if(strpos($ln,'download.mp3')!==false){$mp3=trim($ln);if(preg_match('/episodes\/(\d+)\/download\.mp3/',$mp3,$idm))$eid=$idm[1];break;}}}
        $categories=get_the_category(); $root_cat='Unknown';
        if($categories){foreach($categories as $cat){if(stripos($cat->name,'Season')===false){$root_cat=$cat->name;break;}}}
        if(!isset($episodes_by_show[$root_cat]))$episodes_by_show[$root_cat]=[]; if(!isset($episodes_by_show[$root_cat][$year_full]))$episodes_by_show[$root_cat][$year_full]=[];
        $episodes_by_show[$root_cat][$year_full][]=['title'=>$title,'date'=>$date,'sortable'=>$sortable,'mp3'=>$mp3,'eid'=>$eid,'permalink'=>get_permalink(),'download'=>$mp3];
    }
    wp_reset_postdata(); ob_start(); echo '<div class="otr-contributor-directory"><h2>'.esc_html(str_replace('_',' ',$tags[0])).'</h2><div class="tabs">';
    $tab_index=0; ksort($episodes_by_show); foreach(array_keys($episodes_by_show) as $show_name){echo '<button class="tab-button" onclick="showTab('.$tab_index.')">'.esc_html($show_name).'</button>'; $tab_index++;} echo '</div>';
    $tab_index=0; foreach($episodes_by_show as $show_name=>$years){echo '<div class="tab-content" id="tab-'.$tab_index.'" style="display:'.($tab_index===0?'block':'none').'">'; echo '<hr class="otr-divider" style="margin: 8px 0; border-top: 1px solid #ccc;"><h2 class="otr-show-header">'.esc_html($show_name).'</h2>'; ksort($years); echo '<div class="year-tabs">'; foreach(array_keys($years) as $i=>$yr)echo '<button class="tab-button year-tab" onclick="showYearTab('.$tab_index.', '.$i.')">'.esc_html($yr).'</button>'; echo '</div>';
        $year_index=0; foreach($years as $yr=>$episodes){usort($episodes,fn($a,$b)=>$a['sortable']<=>$b['sortable']); echo '<div class="year-content tab-'.$tab_index.'-year-'.$year_index.'" style="display:'.($year_index===0?'block':'none').'"><h3>'.esc_html($yr).'</h3><table class="otr-table"><thead><tr><th>Episode Title</th><th>Release Date</th><th>Download</th></tr></thead><tbody>'; foreach($episodes as $ep){echo '<tr><td><a href="'.esc_url($ep['permalink']).'" target="_blank">'.esc_html($ep['title']).'</a></td><td>'.esc_html($ep['date']).'</td><td>'; if($ep['eid']&&$ep['download'])echo '<a class="otr-download-button" href="'.esc_url($ep['download']).'" target="_blank" rel="noopener noreferrer" title="Download"><i class="fas fa-cloud-download-alt"></i></a>'; echo '</td></tr>';} echo '</tbody></table>'; $eid_list=implode(',',array_filter(array_column($episodes,'eid'))); echo '<div class="otr-download-all">'; if($eid_list)echo '<a class="otr-download-button" target="_blank" href="https://www.otrwesterns.com/mp3/download.php?ep='.esc_attr($eid_list).'"><i class="fas fa-cloud-download-alt"></i> Download All Episodes</a>'; echo '</div></div>'; $year_index++;} echo '</div>'; $tab_index++;}
    echo '</div>'; wp_enqueue_script('otr-contributor-js',plugins_url('otr-contributor.js',__FILE__),[],null,true); return ob_get_clean();
}
add_shortcode('otr_contributor','ocd_render_contributor');
function ocd_enqueue_styles(){wp_enqueue_style('otr-contributor-style',plugins_url('otr-contributor.css',__FILE__));}
add_action('wp_enqueue_scripts','ocd_enqueue_styles');
