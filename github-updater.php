<?php
/**
 * Native GitHub updater for OTR Contributor Directory.
 *
 * Checks the public main branch for a newer plugin version and lets
 * WordPress install it through the normal Plugins update interface.
 */

if (!defined('ABSPATH')) exit;

function ocd_github_get_remote_version() {
    $cache_key = 'ocd_github_remote_version';
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $url = 'https://raw.githubusercontent.com/eagle4life69/otr-contributor-directory/main/otr-contributor-directory.php';
    $response = wp_remote_get($url, [
        'timeout' => 10,
        'headers' => [
            'User-Agent' => 'OTR-Contributor-Directory/' . OCD_VERSION,
        ],
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return false;
    }

    $body = wp_remote_retrieve_body($response);
    if (!preg_match('/^\s*Version:\s*(.+)$/mi', $body, $matches)) {
        return false;
    }

    $version = trim($matches[1]);
    set_transient($cache_key, $version, 6 * HOUR_IN_SECONDS);
    return $version;
}

function ocd_github_check_for_update($transient) {
    if (empty($transient->checked)) {
        return $transient;
    }

    $plugin_file = plugin_basename(OCD_PLUGIN_FILE);
    $remote_version = ocd_github_get_remote_version();

    if ($remote_version && version_compare(OCD_VERSION, $remote_version, '<')) {
        $update = new stdClass();
        $update->id = 'github.com/eagle4life69/otr-contributor-directory';
        $update->slug = 'otr-contributor-directory';
        $update->plugin = $plugin_file;
        $update->new_version = $remote_version;
        $update->url = 'https://github.com/eagle4life69/otr-contributor-directory';
        $update->package = 'https://github.com/eagle4life69/otr-contributor-directory/archive/refs/heads/main.zip';
        $update->tested = '';
        $update->requires_php = '7.2';
        $transient->response[$plugin_file] = $update;
    }

    return $transient;
}
add_filter('site_transient_update_plugins', 'ocd_github_check_for_update');

function ocd_github_plugin_information($result, $action, $args) {
    if ($action !== 'plugin_information' || empty($args->slug) || $args->slug !== 'otr-contributor-directory') {
        return $result;
    }

    $remote_version = ocd_github_get_remote_version();

    $info = new stdClass();
    $info->name = 'OTR Contributor Directory';
    $info->slug = 'otr-contributor-directory';
    $info->version = $remote_version ?: OCD_VERSION;
    $info->author = '<a href="https://otrwesterns.com">Andrew Rhynes</a>';
    $info->homepage = 'https://github.com/eagle4life69/otr-contributor-directory';
    $info->requires = '5.0';
    $info->requires_php = '7.2';
    $info->download_link = 'https://github.com/eagle4life69/otr-contributor-directory/archive/refs/heads/main.zip';
    $info->sections = [
        'description' => 'Displays contributor pages with episode listings grouped by show and year.',
        'changelog' => 'See the GitHub repository readme for the current changelog.',
    ];

    return $info;
}
add_filter('plugins_api', 'ocd_github_plugin_information', 20, 3);

/**
 * GitHub branch ZIPs extract as otr-contributor-directory-main.
 * Rename the extracted folder so WordPress keeps the existing plugin path.
 */
function ocd_github_fix_source_folder($source, $remote_source, $upgrader, $hook_extra) {
    if (empty($hook_extra['plugin']) || $hook_extra['plugin'] !== plugin_basename(OCD_PLUGIN_FILE)) {
        return $source;
    }

    $desired_source = trailingslashit($remote_source) . 'otr-contributor-directory/';
    if (untrailingslashit($source) === untrailingslashit($desired_source)) {
        return $source;
    }

    if (file_exists($desired_source)) {
        return $source;
    }

    if (@rename(untrailingslashit($source), untrailingslashit($desired_source))) {
        return $desired_source;
    }

    return new WP_Error('ocd_github_rename_failed', 'Unable to prepare the GitHub update package.');
}
add_filter('upgrader_source_selection', 'ocd_github_fix_source_folder', 10, 4);

function ocd_github_clear_update_cache($upgrader, $options) {
    if (!empty($options['action']) && $options['action'] === 'update' && !empty($options['type']) && $options['type'] === 'plugin') {
        delete_transient('ocd_github_remote_version');
    }
}
add_action('upgrader_process_complete', 'ocd_github_clear_update_cache', 10, 2);
