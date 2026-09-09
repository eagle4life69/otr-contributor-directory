<?php
/**
 * Native GitHub updater for OTR Contributor Directory.
 *
 * Checks the latest published GitHub Release and lets WordPress install it
 * through the normal Plugins update interface.
 */

if (!defined('ABSPATH')) exit;

function ocd_github_get_latest_release() {
    $cache_key = 'ocd_github_latest_release';
    $cached = get_transient($cache_key);
    if ($cached !== false) {
        return $cached;
    }

    $url = 'https://api.github.com/repos/eagle4life69/otr-contributor-directory/releases/latest';
    $response = wp_remote_get($url, [
        'timeout' => 10,
        'headers' => [
            'Accept' => 'application/vnd.github+json',
            'User-Agent' => 'OTR-Contributor-Directory/' . OCD_VERSION,
        ],
    ]);

    if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
        return false;
    }

    $data = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($data['tag_name']) || empty($data['zipball_url'])) {
        return false;
    }

    $release = [
        'version' => ltrim(trim($data['tag_name']), 'vV'),
        'package' => esc_url_raw($data['zipball_url']),
        'url' => !empty($data['html_url']) ? esc_url_raw($data['html_url']) : 'https://github.com/eagle4life69/otr-contributor-directory/releases',
        'body' => !empty($data['body']) ? (string) $data['body'] : '',
    ];

    set_transient($cache_key, $release, 15 * MINUTE_IN_SECONDS);
    return $release;
}

function ocd_github_build_update_object($release, $plugin_file) {
    $update = new stdClass();
    $update->id = 'https://github.com/eagle4life69/otr-contributor-directory';
    $update->slug = 'otr-contributor-directory';
    $update->plugin = $plugin_file;
    $update->new_version = $release['version'];
    $update->url = $release['url'];
    $update->package = $release['package'];
    $update->tested = '';
    $update->requires_php = '7.2';
    return $update;
}

function ocd_github_check_for_update($transient) {
    if (!is_object($transient)) {
        $transient = new stdClass();
    }
    if (empty($transient->response) || !is_array($transient->response)) {
        $transient->response = [];
    }
    if (empty($transient->no_update) || !is_array($transient->no_update)) {
        $transient->no_update = [];
    }

    $plugin_file = plugin_basename(OCD_PLUGIN_FILE);
    $release = ocd_github_get_latest_release();

    if (!$release) {
        return $transient;
    }

    $update = ocd_github_build_update_object($release, $plugin_file);

    if (version_compare(OCD_VERSION, $release['version'], '<')) {
        $transient->response[$plugin_file] = $update;
        unset($transient->no_update[$plugin_file]);
    } else {
        $transient->no_update[$plugin_file] = $update;
        unset($transient->response[$plugin_file]);
    }

    return $transient;
}
add_filter('site_transient_update_plugins', 'ocd_github_check_for_update');

function ocd_github_plugin_information($result, $action, $args) {
    if ($action !== 'plugin_information' || empty($args->slug) || $args->slug !== 'otr-contributor-directory') {
        return $result;
    }

    $release = ocd_github_get_latest_release();

    $info = new stdClass();
    $info->name = 'OTR Contributor Directory';
    $info->slug = 'otr-contributor-directory';
    $info->version = $release ? $release['version'] : OCD_VERSION;
    $info->author = '<a href="https://otrwesterns.com">Andrew Rhynes</a>';
    $info->homepage = 'https://github.com/eagle4life69/otr-contributor-directory';
    $info->requires = '5.0';
    $info->requires_php = '7.2';
    $info->download_link = $release ? $release['package'] : '';
    $info->sections = [
        'description' => 'Displays contributor pages with episode listings grouped by show and year.',
        'changelog' => $release && !empty($release['body']) ? wpautop(esc_html($release['body'])) : 'See the GitHub release notes for the current changelog.',
    ];

    return $info;
}
add_filter('plugins_api', 'ocd_github_plugin_information', 20, 3);

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
        delete_transient('ocd_github_latest_release');
    }
}
add_action('upgrader_process_complete', 'ocd_github_clear_update_cache', 10, 2);
