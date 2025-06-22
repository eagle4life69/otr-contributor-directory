<?php
/*
Plugin Name: OTR Contributor Directory
Description: Displays contributor (actor, writer, etc.) pages with grouped episode listings by show and year.
Version: 1.0.7
Author: Andrew Rhynes
Author URI: https://otrwesterns.com
GitHub Plugin URI: https://github.com/eagle4life69/otr-contributor-directory
GitHub Branch: main

== Description ==
OTR Contributor Directory helps you display episode appearances by actors, writers, and other contributors.

== How to Use ==
- Create a page for a contributor (e.g., William Conrad).
- Add the shortcode: [otr_contributor name="William_Conrad"]
- To include multiple aliases, use a comma-separated list: [otr_contributor name="William_Conrad,Bill_Conrad"]

== Features ==
- Automatically groups episodes by Show (via root category)
- Ignores categories with "Season" in the name
- Groups further by Year (parsed from title in MM-DD-YY format)
- Displays PowerPress download links for each episode
- Clean table layout with Elementor-style download icons
- Includes a "Download All Episodes" button using custom handler
- Alphabetically ordered shows and years
- Nested year tab buttons per show to reduce scrolling
- External JavaScript file for better performance and maintenance
*/

if (!defined('ABSPATH')) exit;

// Register Custom Post Type for Contributors
function ocd_register_contributor_cpt() {
    register_post_type('contributor', [
        'labels' => [
            'name' => 'Contributors',
            'singular_name' => 'Contributor',
        ],
        'public' => true,
        'has_archive' => false,
        'rewrite' => ['slug' => 'contributor'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);
}
add_action('init', 'ocd_register_contributor_cpt');

// Shortcode to render contributor profile and episodes
function ocd_render_contributor($atts) {
    $atts = shortcode_atts(['name' => ''], $atts);
    if (!$atts['name']) return '<p>No contributor specified.</p>';

    $tags = array_map('trim', explode(',', $atts['name']));

    $args = [
        'post_type' => 'post',
        'posts_per_page' => -1,
        'tag_slug__in' => $tags,
    ];
    $query = new WP_Query($args);

    $episodes_by_show = [];
    $seen_post_ids = [];

while ($query->have_posts()) {
    $query->the_post();
    $post_id = get_the_ID();

    // Skip duplicate posts
    if (in_array($post_id, $seen_post_ids)) continue;
    $seen_post_ids[] = $post_id;

    $full = get_the_title();

    // Parse MM-DD-YY from title
    preg_match('/\((\d{2})-(\d{2})-(\d{2})\)$/', $full, $m);
    $month = $m[1] ?? '';
    $day   = $m[2] ?? '';
    $year  = $m[3] ?? '';
    $date  = ($month && $day && $year) ? "$month-$day-19$year" : '';
    $sortable = ($year && $month && $day) ? intval("19$year$month$day") : 0;
    $year_full = ($year) ? "19$year" : 'Unknown';

    // Title parsing logic
    if (strpos($full, ' | ') !== false) {
        $parts = explode(' | ', $full);
    } else {
        $parts = explode(' – ', $full);
    }
    $title = $parts[0];

    // Get MP3 + Episode ID
    $meta = get_post_meta($post_id, 'enclosure', true);
    $mp3 = '';
    $eid = '';
    if ($meta) {
        $lines = explode("\n", $meta);
        foreach ($lines as $ln) {
            if (strpos($ln, 'download.mp3') !== false) {
                $mp3 = trim($ln);
                if (preg_match('/episodes\/(\d+)\/download\.mp3/', $mp3, $idm)) {
                    $eid = $idm[1];
                }
                break;
            }
        }
    }

    $categories = get_the_category();
    $root_cat = 'Unknown';
    if ($categories) {
        foreach ($categories as $cat) {
            if (stripos($cat->name, 'Season') === false) {
                $root_cat = $cat->name;
                break;
            }
        }
    }

    if (!isset($episodes_by_show[$root_cat])) $episodes_by_show[$root_cat] = [];
    if (!isset($episodes_by_show[$root_cat][$year_full])) $episodes_by_show[$root_cat][$year_full] = [];

    $episodes_by_show[$root_cat][$year_full][] = [
        'title' => $title,
        'date' => $date,
        'sortable' => $sortable,
        'mp3' => $mp3,
        'eid' => $eid,
        'permalink' => get_permalink(),
        'download' => $mp3,
    ];
}
wp_reset_postdata();


    ob_start();
    echo '<div class="otr-contributor-directory">';
    echo '<h2>' . esc_html(str_replace('_', ' ', $tags[0])) . '</h2>';

    echo '<div class="tabs">';
    $tab_index = 0;
    ksort($episodes_by_show);
    foreach (array_keys($episodes_by_show) as $show_name) {
    $years = $episodes_by_show[$show_name];
        echo '<button class="tab-button" onclick="showTab(' . $tab_index . ')">' . esc_html($show_name) . '</button>';
        $tab_index++;
    }
    echo '</div>';

    $tab_index = 0;
    ksort($episodes_by_show);
    foreach (array_keys($episodes_by_show) as $show_name) {
    $years = $episodes_by_show[$show_name];

        echo '<div class="tab-content" id="tab-' . $tab_index . '" style="display: ' . ($tab_index === 0 ? 'block' : 'none') . '">';
        ksort($years);
        ksort($years);
        echo '<div class="year-tabs">';
        foreach (array_keys($years) as $i => $year) {
            echo '<button class="tab-button year-tab" onclick="showYearTab(' . $tab_index . ', ' . $i . ')">' . esc_html($year) . '</button>';
        }
        echo '</div>';

        $year_index = 0;
        foreach ($years as $year => $episodes) {
            usort($episodes, function ($a, $b) {
                return $a['sortable'] <=> $b['sortable'];
            });
            echo '<div class="year-content tab-' . $tab_index . '-year-' . $year_index . '" style="display:' . ($year_index === 0 ? 'block' : 'none') . '">';
            echo '<h3>' . esc_html($year) . '</h3>';
            echo '<table class="otr-table"><thead><tr><th>Episode Title</th><th>Download</th></tr></thead><tbody>';
            foreach ($episodes as $ep) {
                echo '<tr>';
                echo '<td><a href="' . esc_url($ep['permalink']) . '">' . esc_html($ep['title']) . '</a></td>';
                echo '<td>';
                if ($ep['eid'] && $ep['download']) {
                    echo '<a class="otr-download-button" href="' . esc_url($ep['download']) . '" target="_blank" rel="noopener noreferrer" title="Download">';
                    echo '<span class="elementor-icon-list-icon"><i class="fas fa-cloud-download-alt"></i></span> Download</a>';
                }
                echo '</td>';
                echo '</tr>';
            }
            echo '</tbody></table>';
            $eids = array_filter(array_column($episodes, 'eid'));
            $eid_list = implode(',', $eids);
            echo '<div class="otr-download-all">';
            if ($eid_list) {
                echo '<a class="otr-download-button" target="_blank" href="https://www.otrwesterns.com/mp3/download.php?ep=' . esc_attr($eid_list) . '">Download All Episodes</a>';
            }
            echo '</div>';
            echo '</div>';
            $year_index++;
        }
    $eids = array_filter(array_column($episodes, 'eid'));
$eid_list = implode(',', $eids);
echo '<div class="otr-download-all">';
if ($eid_list) {
    echo '<a class="otr-download-button" target="_blank" href="https://www.otrwesterns.com/mp3/download.php?ep=' . esc_attr($eid_list) . '">Download All Episodes</a>';
}
echo '</div>';

}
        echo '</div>';
        $tab_index++;
    }

    echo '</div>';
    wp_enqueue_script('otr-contributor-js', plugins_url('otr-contributor.js', __FILE__), [], null, true);

    return ob_get_clean();
}
add_shortcode('otr_contributor', 'ocd_render_contributor');

// Basic styles
function ocd_enqueue_styles() {
    echo '<style>
        .tab-button { margin: 0 5px; padding: 6px 12px; cursor: pointer; }
        .tab-content { margin-top: 10px; }
        .otr-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .otr-table th, .otr-table td { padding: 8px 10px; border: 1px solid #ccc; text-align: left; }
        .otr-table th { background-color: #f4f4f4; }
        .otr-download-all { margin: 10px 0; text-align: right; }
        .otr-download-button {
            display: inline-block;
            padding: 6px 12px;
            background-color: #0073aa;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .otr-download-button:hover {
            background-color: #005177;
        }
    </style>';
}
add_action('wp_head', 'ocd_enqueue_styles');
