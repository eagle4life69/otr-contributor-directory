=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.3  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory is a powerful plugin that allows you to highlight actors, writers, producers, and others from your podcast episodes. Using post tags, it dynamically pulls all related content and displays it grouped by Show and Year — with a built-in download link from PowerPress.

Perfect for fans who follow favorite stars or researchers tracking contributor involvement over time.

== How to Use ==

1. Create a new WordPress Page or Post for a contributor.
2. Add the shortcode:
   `[otr_contributor name="William_Conrad"]`
3. To support multiple aliases:
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

The plugin automatically:
- Groups by Show (based on the root category)
- Breaks episodes down by Year (parsed from the title format MM-DD-YY)
- Includes download links from PowerPress

== Features ==

- Easy-to-use shortcode
- Multiple tag support (for alias handling)
- Grouped tabs for Show and Year
- Pulls from PowerPress for download links
- Dynamically updates as new episodes are added

== Frequently Asked Questions ==

= Do I need to manually tag posts? =  
Yes, contributor names must be applied as tags (e.g., `William_Conrad`) for them to appear.

= Can I display writers and producers too? =  
Yes! Just create separate pages and pass their tag names into the shortcode.

= Can I use this with Elementor? =  
Yes, paste the shortcode into an Elementor shortcode widget or text block.

== Changelog ==

= 1.0.3 =
* Added full plugin description to header and support for multiple aliases via comma-separated tag list.
* Now skips duplicate episodes when multiple tags match the same post.

= 1.0.2 =
* Prevented duplicate episodes in grouped list.

= 1.0.1 =
* Initial release with grouping by show/year and download links via PowerPress.

== Upgrade Notice ==

= 1.0.3 =
Added alias support and improved shortcode behavior for multi-tag handling.

== Credits ==

Developed by Andrew Rhynes for OTRWesterns.com
