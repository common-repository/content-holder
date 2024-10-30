=== Content Holder ===
Contributors: kingdomcreation
Tags: custom post type, content, plugin, widget, shortcode
Requires at least: 3.0.1
Tested up to: 5.2.0
Stable tag: 1.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Separate your content into reusable parts to use anywhere in your site through a function, shortcode or widget

== Description ==

Separate pieces of content into fragments that you can reuse anywhere on your website. 
Group several content holder into a single one to reuse your content more easily. 

== Installation ==

1. Upload `content-holder` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create content holders from the admin page and use them in your theme through the content_holder shortcode or widget. 
1. When creating or editing a page, post or any custom type your can choose the content holder you want to add and insert it directly in the editor.

== Frequently Asked Questions ==

= How do I display a content holder =

First create a content holder and add your content inside. Now go in a post or a page and select the content holder from the dropdown. 

= Can you add content holder inside content holder =

Yes. It's possible to make content holder act as a group and render multiple content holder

= Is there a shortcode available for developers? =

Yes. The content_holder shortcode supports a slug and id attribute. Simply provide the post_name as the slug or the ID to the shortcode.

`[content_holder id=2|slug=“post_name”]`


== Screenshots ==

1. You can add the content holder widget to any sidebar
2. Modify content holder intuitively and seamlessly like any other content
3. Easily add content holder to other parts of the site with a button 
4. Choose the content holder from a list to insert the shortcode

== Changelog ==

= 1.0 =
* Initial release

== 1.0.1 ==
* Fix WP_Widget deprecated notice
* Broaden query to all post types
* Remove `wpautop` by default

== 1.1.0 ==
* Add content holder block support
