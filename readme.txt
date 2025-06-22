=== OTR Contributor Directory ===
Contributors: eagle4life69  
Tags: actors, old time radio, podcast, shortcode, directory  
Requires at least: 5.0  
Tested up to: 6.5  
Stable tag: 1.0.4  
Requires PHP: 7.2  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A dynamic plugin that displays grouped episode listings by show and year for actors (or other contributors) featured in Old Time Radio episodes.

== Description ==

OTR Contributor Directory helps you highlight actors, writers, producers, and others from your podcast episodes. Using post tags, it dynamically pulls all related content and displays it grouped by Show and Year — with PowerPress download links, clean table formatting, and one-click download options.

Perfect for fans tracking favorite stars or historians following contributor involvement.

== How to Use ==

1. Create a WordPress Page or Post for a contributor.
2. Add the shortcode:
   `[otr_contributor name="William_Conrad"]`
3. To include multiple aliases:
   `[otr_contributor name="William_Conrad,Bill_Conrad"]`

== Features ==

- Automatically groups episodes by Show (root category)
- Further breaks down by Year (from post title in MM-DD-YY format)
- Displays PowerPress download links
- Clean, responsive table layout with columns
- Includes “Download All Episodes” button per year
- Tabs allow easy navigation across shows
- Dynamically updates as new episodes are published

== Frequently Asked Questions ==

= Can I list multiple tag names for one contributor? =  
Yes, just use a comma-separated list in the `name` attribute.

= Do I have to manually create pages? =  
Yes, for now you'll manually create a WordPress Page and add the shortcode.

= Can I display writers or producers? =  
Absolutely — just tag posts with their names and use the shortcode accordingly.

== Changelog ==

= 1.0.4 =
* Added table-based layout for episodes
* Added Download All Episodes button per year group

= 1.0.3 =
* Added support for multiple tag names (aliases)
* Skipped duplicate episode posts

= 1.0.2 =
* Prevented duplicate episodes in grouped listings

= 1.0.1 =
* Initial release with grouping by show and year using PowerPress download links

== Upgrade Notice ==

= 1.0.4 =
Major UI improvements: table view and Download All button
