<?php
/*
Plugin Name: OTR Contributor Directory
Description: Displays contributor (actor, writer, etc.) pages with grouped episode listings by show and year.
Version: 1.0.3
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
- Further breaks down by Year (parsed from title in MM-DD-YY format)
- Displays PowerPress download links for each episode
- Tabs allow for clean navigation of show/year structure
- Dynamically updates as new episodes are added
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

        $title = get_the_title();
        preg_match('/\((\d{2})-(\d{2})-(\d{2})\)/', $title, $matches);
        $year = $matches ? ('19' . $matches[3]) : 'Unknown';

        $categories = get_the_category();
        $root_cat = $categories ? $categories[0]->name : 'Unknown';

        if (!isset($episodes_by_show[$root_cat])) $episodes_by_show[$root_cat] = [];
        if (!isset($episodes_by_show[$root_cat][$year])) $episodes_by_show[$root_cat][$year] = [];

        $download_url = get_post_meta($post_id, 'enclosure', true);

        $episodes_by_show[$root_cat][$year][] = [
            'title' => $title,
            'permalink' => get_permalink(),
            'download' => $download_url,
        ];
    }
    wp_reset_postdata();

    ob_start();
    echo '<div class="otr-contributor-directory">';
    echo '<h2>' . esc_html(str_replace('_', ' ', $tags[0])) . '</h2>';

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
                echo '<li><a href="' . esc_url($ep['permalink']) . '">' . esc_html($ep['title']) . '</a>';
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

