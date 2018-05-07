=== WP Last Modified Info ===
Contributors: Infosatech
Tags: last modified info, shortcode, short by column, time, date 
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 1.1.6
Donate link: https://bit.ly/2I0Gj60
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Display last modified date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 4.4 and beyond.

== Description ==

### WP Last Modified Info: the Ultimate Last Modified plugin

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don’t show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

#### What does this plugin do?

Using this plugin, display last modified info on your WordPress posts and pages. Use shortcode `[lmt-post-modified-info]` for posts and `[lmt-page-modified-info]` for pages. You will also be able to add Revised Metadata to your posts and pages through this plugin, but that is completely optional.

* Allows you to display Last modified information in your posts and pages individually.
* Provides you with options to display the last modified/last updated date above or below your posts and pages. You can also set date/time formats and the position of the timestamp in WordPress Posts and Pages which can be either before content or after content.
* Allows you to customize the text which is to be displayed alongside the last modified date (default: Last updated on).
* Inserts 'dateModified' schama markup to your WordPress posts automatically.
* Allows you to display last modified info in all posts types column and publish meta box in the dashboard.
* Allows you to sort posts/pages by last updated/modified info.

#### Compatibility

This plugin is fully compatible with WordPress Version 4.4 and beyond and also compatible with any WordPress theme.

#### Support
* Community support via the [support forums on wordpress.org](https://wordpress.org/support/plugin/wp-last-modified-info)
* We don’t handle support via e-mail, Twitter, GitHub issues etc.

#### Contribute
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Pull requests for documented bugs are highly appreciated.
* If you think you’ve found a bug (e.g. you’re experiencing unexpected behaviour), please post at the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) first.

#### Bug reports

Bug reports for WP Last Modified Info are [welcomed on GitHub](https://github.com/iamsayan/wp-last-modified-info). Please note GitHub is not a support forum, and issues that arenâ€™t properly qualified as bugs will be closed.

== Installation ==

1. Visit 'Plugins > Add New'.
1. Search for 'WP Last Modified Info' and install it.
1. Or you can upload the `wp-last-modified-info` folder to the `/wp-content/plugins/` directory manually.
1. Activate WP Last Modified Info from your Plugins page.
1. After activation go to 'Settings > Last Modified Info'.
1. Enable options and save changes.

== Frequently Asked Questions ==

= Is there any admin interface for this plugin? =

Yes. You can access this from 'Settings > Last Modified Info'.

= How to use this plugin? =

Go to 'Settings > Last Modified Info', enable/disable options as per your need and save your changes.

= How to check this plugin is working? =

After enabling options in 'Settings > Last Modified Info', open any page or post and you can see the change.

= How this plugin works? =

This plugin hooks into WordPress content area and displays last modified information on posts and pages.

= Will it require editing code to show Last Modified date? =

Not at all. You can show the revised info by just installing this plugin. Use the Plugin Options to customize the date/time according to your need.

= Is this plugin compatible with any themes? =

Yes, this plugin is compatible with any theme.

= Does this plugin support all custom post types? =

Yes, this plugin supports all types of custom posts.

= How to customize last modified text style? =

Go to 'Settings > Last Modified Info > Custom CSS' and add your custom CSS.

CSS Classes:

`.post-last-modified`: use this class for posts.

`.post-last-modified-td`: use this class if you want to add style only to last modified date/time on posts.

`.page-last-modified`: use this class for pages.

`.page-last-modified-td`: use this class if you want to add style only to last modified date/time on pages.

= Can I sort posts and pages by last modified info in the dashboard? =

Yes, you can. You can sort posts and pages by ascending or descending order.

= How this plugin helps to optimize SEO? =

This plugin wraps modified info with 'dateModified' schema markup which is used to tell the last modified date & time of a webpage to various web crawlers (Google, Bing etc.). [Test your website with structured data tool](https://search.google.com/structured-data/testing-tool).

= The Date and Time inserted by this plugin is dependent on what? =

The plugin makes use of your WordPress Date, Time and Timezone (Dashboard > Settings > General) in WordPress dashboard.

= Is this plugin compatible with multisite? =

Yes, it is fully compatible with multisite.

= Can I change 'Last Updated on' text? =

Yes, you can. Just set your custom text in settings and save your changes.

Use the plugin to test it.

== Screenshots ==

1. Post Options
2. Page Options
3. Dashboard Options
4. Custom CSS

== Changelog ==

= 1.1.6 =
Release Date: March 7, 2018

* Improved: Custom Post Type Support.
* Bug Fixed.

= 1.1.5 =
Release Date: March 5, 2018

* Improved: Schama markup.
* Removed 'revised' meta tag output as it is no longer required.
* UI Improvements.
* Code Cleanup.

= 1.1.4 =
Release Date: March 4, 2018

* Added: last modified schama markup for posts.
* Bug Fixed.

= 1.1.3 =
Release Date: March 4, 2018

* Added: Now you can create the exception for both posts and pages.
* Bug Fixed.
* Cover photo update. Thanks to @svayam.

= 1.1.2 =
Release Date: March 3, 2018

* Added: Now you can customize date/time format.
* Bug Fixed.

= 1.1.0 =
Release Date: March 3, 2018

* Added: All Custom Post support including WooCommerece.
* Now every last modified time in dashboard shows according to WordPress date/time format.
* Now shortcode will work only when shortcode option is enabled.
* Tweak: Custom CSS Box returns empty style tag if there is no value.
* Bug Fixed.

= 1.0.9 =
Release Date: April 29, 2018

* Added: Last updated info now shows on publishing meta box.
* Remove some unwanted conditions.
* Fix WooCommerce admin notice.
* Bug fixed.

= 1.0.8 =
Release Date: April 28, 2018

* Add WooCommerce Support.
* Multisite compatibility.
* Last login info added.
* Remove 304 response header as it is enabled by default by many cache plugins.
* Bug fixed.

= 1.0.6 =
Release Date: April 27, 2018

* Bug Fix: Undefined Variable notice shows when debug mode is enabled.
* Bug Fix: Weekday is not showing with revision meta tag output.

= 1.0.5 =
Release Date: April 27, 2018

* Added: 'post-last-modified-td' and 'page-last-modified-td' classes.
* Bug fixed.

= 1.0.4 =
Release Date: April 27, 2018

* If else condition change.
* Last modified headers hook change.
* Bug fixed.

= 1.0.3 =
Release Date: April 26, 2018

* Added last modified header output.
* Added user profile last modified info.
* Bug fixed.

= 1.0.2 =
Release Date: April 26, 2018

* Added revision meta output.
* Bug fixed.

= 1.0.0 =
Release Date: April 25, 2018

* Initial release