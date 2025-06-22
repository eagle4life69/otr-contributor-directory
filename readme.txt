=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.7  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor pages for your OTRWesterns.com podcast. It dynamically lists episodes featuring each contributor, grouped by show and year, and styled for easy navigation and quick access to downloads. Ideal for highlighting actors, writers, or other roles.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode:  
   `[otr_contributor name="William_Conrad"]`
3. Use multiple aliases:  
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Automatically groups episodes by Show (from root category)
- Ignores categories with "Season" in the name
- Further groups by Year from post title (MM-DD-YY)
- Clean, responsive table layout for each year's episodes
- Elementor-style download icons for individual MP3s
- “Download All Episodes” button (powered by custom PHP handler)
- Year tabs within each show to reduce scroll fatigue
- Alphabetical sorting for shows and years
- External JavaScript file for better performance

== Changelog ==

= 1.0.7 =
* Added year-level tab buttons within each show to reduce vertical scroll
* Shows and years now sorted alphabetically
* Updated styling and refined year/tab logic

= 1.0.6 =
* Ignored categories with the word “Season”
* Alphabetical sorting of show tabs
* Integrated Elementor-style icons for downloads
* Linked “Download All” to custom PHP handler

= 1.0.5 =
* Externalized JavaScript
* Improved download logic with Spreaker ID validation

= 1.0.4 =
* Table layout and styling for episode listings
* Added bulk download option

= 1.0.3 =
* Support for multiple tag aliases in shortcode
* Deduplicates episodes appearing under multiple tags

= 1.0.2 =
* Prevented duplicate episodes in grouped listings

= 1.0.1 =
* Initial release with grouping and PowerPress support

== Upgrade Notice ==

= 1.0.7 =
Added nested year tabs and sorted show/year lists for a cleaner, more organized interface.
