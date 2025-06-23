=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.8  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor pages for your OTRWesterns.com podcast. It dynamically lists episodes featuring each contributor, grouped by show and year, with clean, styled tables and download options. Built for fans of classic radio and structured to support PowerPress and Spreaker-based podcasts.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode:  
   `[otr_contributor name="William_Conrad"]`
3. Use multiple aliases:  
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Group episodes by root Show category (ignores subcategories with “Season”)
- Further group by Year from post title (MM-DD-YY)
- Display each year’s episodes in a clean table layout
- Individual download buttons for each episode (PowerPress MP3)
- “Download All Episodes” button powered by custom handler
- Shows sorted alphabetically
- Years sorted chronologically within each show
- Nested year tab buttons per show for easier navigation
- Visible show headers and horizontal lines for better UX
- Elementor-style download icons
- JavaScript and CSS enqueued externally

== Changelog ==

= 1.0.8 =
* Added visible headers for each show category
* Inserted horizontal lines between show and year groups
* Improved UI clarity with year tab buttons and grouped views

= 1.0.7 =
* Year tabs added to reduce scrolling
* Sorted shows and years alphabetically
* Finalized integration with Elementor icon styles

= 1.0.6 =
* Skips categories with “Season”
* Cleaned up structure and download logic

= 1.0.5 =
* Externalized JavaScript
* Improved individual and bulk download handling

= 1.0.4 =
* Introduced clean table layout and bulk download button

= 1.0.3 =
* Allowed multiple tag names (aliases) per shortcode

= 1.0.2 =
* Prevented duplicate episodes in grouped listings

= 1.0.1 =
* Initial release with grouping and PowerPress integration

== Upgrade Notice ==

= 1.0.8 =
UI update: headers and dividers for show groups, better layout and navigation
