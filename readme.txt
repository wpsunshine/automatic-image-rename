=== Automatic image Rename ===
Contributors: wpsunshine
Tags: image, images, SEO, rename, optimization
Requires at least: 5.0
Tested up to: 6.2.2
Stable tag: 1.0.1
Requires PHP: 7.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Renames image filenames to be more SEO friendly, based on the post's data and image metadata.

== Description ==

SEO Friendly Image Rename is a WordPress plugin that helps improve your website's SEO by renaming image filenames based on the post's data and image metadata. The plugin uses the parent post's title, the image's EXIF metadata, and optionally, the prefix set by the user in the plugin settings.

The plugin offers settings to choose the post types to apply renaming to and set a prefix for filenames.

== Installation ==

1. Upload the 'automatic-image-rename' directory to the '/wp-content/plugins/' directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Settings -> Media to configure the plugin

== Frequently Asked Questions ==

= Does this plugin rename images that are already uploaded?

No, the plugin only renames images during the upload process to the selected post types.

= What happens if there's no post title or image metadata?

The plugin will use the original filename.

= Can I choose the post types to apply the renaming to?

Yes, you can choose the post types in the plugin settings.

== Screenshots ==

1. Example of Automatic Image Rename settings

== Changelog ==

= 1.0.1 =
* Add option for max number of words for new filename

= 1.0.0 =
* Initial release.
