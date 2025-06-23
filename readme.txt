=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.1.1  
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
- Includes episode title, release date, and download link in table
- Uses Elementor-style icons for individual downloads
- Includes “Download All Episodes” button with custom Spreaker handler
- Shows and years are sorted alphabetically and chronologically
- Year-level navigation tabs within each show section
- Responsive table layout with minimal scrolling
- Modular external CSS and JavaScript for performance
- Optimized episode deduplication logic

== Changelog ==

= 1.1.1 =
* Added release date column to episode table
* Fixed display and spacing issues with download icon
* Finalized styling for header divider

= 1.1.0 =
* Externalized CSS for maintainability
* Optimized duplicate episode detection
* Improved visual layout and spacing
* JavaScript bug fix for year switching

= 1.0.9 =
* Added small horizontal line and visual header per show
* Scoped JavaScript fixes for year tab switching
* Cleaned layout margins and styles
