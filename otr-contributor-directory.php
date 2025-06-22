<?php
/*
Plugin Name: OTR Contributor Directory
Description: Displays contributor (actor, writer, etc.) pages with grouped episode listings by show and year.
Version: 1.0.0
Author: Andrew Rhynes
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

    $tag = $atts['name'];
    $args = [
        'post_type' => 'post',
        'posts_per_page' => -1,
        'tag' => $tag,
    ];
    $query = new WP_Query($args);

    $episodes_by_show = [];

    while ($query->have_posts()) {
        $query->the_post();
        $title = get_the_title();
        preg_match('/\\((\\d{2})-(\\d{2})-(\\d{2})\\)/', $title, $matches);
        $year = $matches ? ('19' . $matches[3]) : 'Unknown';

        $categories = get_the_category();
        $root_cat = $categories ? $categories[0]->name : 'Unknown';

        if (!isset($episodes_by_show[$root_cat])) $episodes_by_show[$root_cat] = [];
        if (!isset($episodes_by_show[$root_cat][$year])) $episodes_by_show[$root_cat][$year] = [];

        $download_url = get_post_meta(get_the_ID(), 'enclosure', true);

        $episodes_by_show[$root_cat][$year][] = [
            'title' => $title,
            'permalink' => get_permalink(),
            'download' => $download_url,
        ];
    }
    wp_reset_postdata();

    ob_start();
    echo '<div class="otr-contributor-directory">';
    echo '<h2>' . esc_html(str_replace('_', ' ', $tag)) . '</h2>';

    echo '<div class="tabs">';
    $tab_index = 0;
    foreach ($episodes_by_show as $show => $years) {
        echo '<button class="tab-button" onclick="showTab(' . $tab_index . ')">' . esc_html($show) . '</button>';
        $tab_index++;
    }
    echo '</div>';

    $tab_index = 0;
    foreach ($episodes_by_show as $show => $years) {
        echo '<div class="tab-content" id="tab-' . $tab_index . '" style="display: ' . ($tab_index === 0 ? 'block' : 'none') . '">';
        foreach ($years as $year => $episodes) {
            echo '<h3>' . esc_html($year) . '</h3><ul>';
            foreach ($episodes as $ep) {
                echo '<li><a href="' . esc_url($ep['permalink']) . '">' . esc_html($ep['title']) . '</a>";
                if ($ep['download']) echo ' - <a href="' . esc_url($ep['download']) . '">Download</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
        echo '</div>';
        $tab_index++;
    }

    echo '</div>';
    echo '<script>
        function showTab(index) {
            document.querySelectorAll(".tab-content").forEach((el, i) => {
                el.style.display = (i === index ? "block" : "none");
            });
        }
    </script>';

    return ob_get_clean();
}
add_shortcode('otr_contributor', 'ocd_render_contributor');

// Basic styles
function ocd_enqueue_styles() {
    echo '<style>
        .tab-button { margin: 0 5px; padding: 6px 12px; cursor: pointer; }
        .tab-content { margin-top: 10px; }
    </style>';
}
add_action('wp_head', 'ocd_enqueue_styles');
