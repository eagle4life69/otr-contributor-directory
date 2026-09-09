=== OTR Contributor Directory ===
Contributors: eagle4life69
Tags: actors, old time radio, podcast, shortcode, directory
Requires at least: 5.0
Tested up to: 6.5
Stable tag: 1.1.6
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor pages for your OTRWesterns.com podcast. It dynamically lists episodes featuring each contributor, grouped by show and year, styled for easy navigation and quick access to downloads.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode: `[otr_contributor name="William_Conrad"]`
3. Use multiple aliases: `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Automatically groups episodes by Show (via root category)
- Ignores categories with "Season" in the name
- Groups further by Year (parsed from title in MM-DD-YY format)
- Displays PowerPress download links for each episode
- Includes release date in table alongside episode titles
- Includes published and scheduled episodes so rescheduled feed items remain listed
- Includes a "Download All Episodes" button
- Alphabetically ordered shows and years
- Native GitHub update support through published GitHub Releases
- Supports the WordPress Enable/Disable auto-updates control

== Changelog ==

= 1.1.6 =
* Switched native updater from the main branch to the latest published GitHub Release.
* Reduced GitHub release metadata cache to 15 minutes.

= 1.1.5 =
* Added support for WordPress's Enable/Disable auto-updates control for the native GitHub updater.

= 1.1.4 =
* Added scheduled (future) posts to contributor episode listings so episodes remain visible when their WordPress publish date is rescheduled.
* Added native GitHub update support through the normal WordPress Plugins update system.

= 1.1.3 =
* Added opening episode titles in a new window when clicked.

= 1.1.1.2 =
* Updated CSS to match Elementor-style layout from related plugin.
* Aligned Download and Release Date columns to the far right.

= 1.1.1.1 =
* Added visual horizontal divider and header styling per show.
* Fixed year-tab JavaScript bug in multi-show layout.

= 1.1.1 =
* Added release date column to episode table.
* Finalized styling and layout structure for responsiveness.
