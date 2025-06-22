=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.6  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor profiles for your OTRWesterns.com podcast. It dynamically displays grouped episode listings by show and year with sortable tables and download buttons. Fully integrates with PowerPress and your custom bulk-download endpoint.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode:  
   `[otr_contributor name="William_Conrad"]`
3. Use multiple aliases:  
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Group episodes by root Show category (ignores subcategories with “Season”)
- Further grouped by Year from post title `(MM-DD-YY)`
- PowerPress enclosure used for MP3 download links
- Episode tables styled for readability
- Individual downloads styled with Elementor-style icons
- “Download All Episodes” button points to your custom PHP handler
- Alphabetical ordering of show tabs
- Episodes sorted chronologically within each year
- Shortcode-driven, supports aliases
- External JS file (no inline scripts)

== Changelog ==

= 1.0.6 =
* Ignored categories with the word “Season”
* Alphabetical sorting of show tabs
* Integrated Elementor-style icons for downloads
* Linked “Download All” to custom PHP handler

= 1.0.5 =
* Externalized JavaScript
* Improved download logic with Spreaker ID validation

= 1.0.4 =
* Episode listings use table layout with download buttons
* Added bulk download option

= 1.0.3 =
* Multi-tag support in shortcode (alias handling)
* Deduplication of episode listings

= 1.0.2 =
* Fixed duplicate episodes when multiple tags matched

= 1.0.1 =
* Initial release: grouping by show/year, PowerPress integration

== Upgrade Notice ==

= 1.0.6 =
Improved episode grouping, download logic, and visual enhancements
