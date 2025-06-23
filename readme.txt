=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5
Stable tag: 1.1.3
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor pages for your OTRWesterns.com podcast. It dynamically lists episodes featuring each contributor, grouped by show and year, styled for easy navigation and quick access to downloads.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode:  
   `[otr_contributor name="William_Conrad"]`
3. Use multiple aliases:  
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Automatically groups episodes by Show (via root category)
- Ignores categories with "Season" in the name
- Groups further by Year (parsed from title in MM-DD-YY format)
- Displays PowerPress download links for each episode
- Includes release date in table alongside episode titles
- Clean table layout with Elementor-style download icons
- Includes a "Download All Episodes" button using custom handler
- Download and release date columns aligned to right edge
- Alphabetically ordered shows and years
- Nested year tab buttons per show to reduce scrolling
- Adds visible show headers with thin horizontal separators
- External JavaScript and CSS for better performance and maintenance
- Optimized duplicate checks and memory usage in episode listing

== Changelog ==
==1.1.3==
* Aded open titles in new windows when clicked

= 1.1.1.2 =
* Updated CSS to match Elementor-style layout from related plugin
* Aligned Download and Release Date columns to the far right
* Added text alignment and spacing rules for consistent layout

= 1.1.1.1 =
* Added visual horizontal divider and header styling per show
* Fixed year-tab JavaScript bug in multi-show layout

= 1.1.1 =
* Added release date column to episode table
* Finalized styling and layout structure for responsiveness
