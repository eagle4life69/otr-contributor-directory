=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.5  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory lets you build contributor profiles for your OTRWesterns.com podcast. Display a contributor’s full episode list—grouped by show and year—with clean tables and download options. Built to work with PowerPress metadata and Spreaker episode IDs.

== How to Use ==

1. Create a WordPress Page or Post for a contributor (e.g., William Conrad).
2. Add the shortcode:  
   `[otr_contributor name="William_Conrad"]`
3. To include multiple aliases:  
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Group episodes by Show (from root category)
- Further group by Year (parsed from title in MM-DD-YY format)
- Pulls MP3 link from PowerPress enclosure
- Spreaker episode ID used for batch download handling
- Clean table layout for episode listings
- "Download" button for each episode using PowerPress MP3 link
- "Download All Episodes" button per year using custom handler
- Shortcode supports aliasing via multiple tag names
- External JavaScript (no inline scripts)

== Changelog ==

= 1.0.5 =
* Moved inline JS to external file
* Download button uses PowerPress MP3 URL
* "Download All" button now uses custom download.php with episode IDs
* Uses Elementor-style icon for download button
* Skips download buttons if Spreaker ID is missing

= 1.0.4 =
* Table layout and styling for episode listings
* Added "Download All Episodes" button

= 1.0.3 =
* Support for multiple tag aliases in sho*
