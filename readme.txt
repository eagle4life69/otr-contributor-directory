=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.1.0  
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

- Group episodes by root Show category (ignores "Season" categories)
- Further group by Year (parsed from post title)
- Elementor-style tables for each year's episodes
- Individual MP3 download buttons from PowerPress enclosures
- “Download All Episodes” button using a custom handler
- Shows sorted alphabetically
- Years sorted chronologically within each show
- Nested year tabs per show to reduce scrolling
- Show headers and subtle horizontal dividers for clarity
- External JavaScript and CSS files for better performance
- Optimized episode deduplication logic

== Changelog ==

= 1.1.0 =
* Externalized CSS for maintainability
* Optimized duplicate episode detection
* Improved visual layout and spacing
* JavaScript bug fix for year switching

= 1.0.9 =
* Added small horizontal line and visual header per show
* Scoped JavaScript fixes for year tab switching
* Cleaned layout margins and styles

= 1.0.8 =
* Added nested year tabs per show
* Sorted shows and years alphabetically
* Improved styling and structure

= 1.0.7 =
* Initial release of grouped episode layout
* Integrated Elementor-style download buttons
