=== WP Last Modified Info ===
Contributors: Infosatech
Tags: last modified info, shortcode, short by column, time, date 
Requires at least: 3.5
Tested up to: 4.9
Stable tag: 1.2.6
Donate link: https://www.paypal.me/iamsayan
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Display last modified date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 3.5 and beyond.

== Description ==

### WP Last Modified Info: the Ultimate Last Modified plugin

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don’t show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

#### What does this plugin do?

Using this plugin, display last modified info on your WordPress posts and pages. Use shortcode `[lmt-post-modified-info]` for posts and `[lmt-page-modified-info]` for pages. This plugin also adds 'dateModified' schema markup in WordPress posts automatically.

* Allows you to display Last modified information in your posts and pages individually.
* Provides you with options to display the last modified/last updated date above or below your posts and pages. You can also set date/time formats and the position of the timestamp in WordPress Posts and Pages which can be either before content or after the content.
* Allows you to customize the text which is to be displayed alongside the last modified date (default: Last updated on).
* Inserts 'dateModified' schema markup to your WordPress posts automatically.
* Allows you to display last modified info on all post types column and publish meta box in the dashboard with author name.
* Allows you to sort posts/pages of last updated/modified info.
* Allows you to display last modified info on your post as human readable format i.e. Days/weeks/months/years ago.
* Allows you to display last modified info of all posts in the WordPress admin bar.
* You can also add template tags to your theme files. Go to the FAQ section for more information.
* Allows you to display last modified author info in posts, pages.
* And you can customize all and everything.

#### Compatibility

This plugin is fully compatible with WordPress Version 3.5 and beyond and also compatible with any WordPress theme.

#### Support
* Community support via the [support forums at wordpress.org](https://wordpress.org/support/plugin/wp-last-modified-info)
* We don’t handle support via email, Twitter, GitHub issues etc.

#### Contribute
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Pull requests for documenting bugs are highly appreciated.
* If you think you’ve found a bug (e.g. You’re experiencing unexpected behavior), please post on the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) first.

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

This plugin hooks into the WordPress content area and displays last modified information on posts and pages.

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

`.post-modified-author`: use this class for post author.

`.page-last-modified`: use this class for pages.

`.page-last-modified-td`: use this class if you want to add style only to last modified date/time on the pages.

`.page-modified-author`: use this class for page author.

= Can I sort posts and pages by last modified info in the dashboard? =

Yes, you can. You can sort posts and pages by ascending or descending order.

= How this plugin helps to optimize SEO? =

This plugin wraps modified info with 'dateModified' schema markup which is used to tell the last modified date & time of a web page to various web crawlers (Google, Bing etc.). [Test your website with structured data tool](https://search.google.com/structured-data/testing-tool).

= The Date and Time inserted by this plugin is dependent on what? =

The plugin makes use of your WordPress Date, Time and Timezone (Dashboard > Settings > General) in the WordPress dashboard.

= Is this plugin compatible with multisite? =

Yes, it is fully compatible with multisite.

= Can I change 'Last Updated on' text? =

Yes, you can. Just set your custom text in settings and save your changes.

= Can I use this as template tag? =

Yes, you can. In this case, you have to edit your theme's template files i.e. single.php, page.php etc. And add/replace default published date function with this:

Returns the last modified info:

`<?php if ( function_exists( 'get_the_last_modified_info' ) ) {
		get_the_last_modified_info();
	}
?>`

Displays/echos the last modified info:

`<?php if ( function_exists( 'the_last_modified_info' ) ) {
		the_last_modified_info();
	}
?>`

Use the plugin to test it.

== Screenshots ==

1. Post Options
2. Page Options
3. Dashboard Options
4. Template Tag Options
5. Custom CSS

== Changelog ==

= 1.2.6 =
Release Date: June 9, 2018

* Added: Option to enable/disable auto last modified info suport for custom post types.
* Added: Support to add last modified info in custom fields after post/page update.
* Tweak: Tools is now merged with plugins settings page.
* Bug Fix.

IMPORTANT!

* Please delete all caches and press CTRL+F5 on website front-end/back-end after updating this plugin if there are some css problem.

= 1.2.5 =
Release Date: May 27, 2018

* Added: Ajax loading at the time of form submission.
* Bug Fix.

= 1.2.4 =
Release Date: May 25, 2018

* Added: Tools page - Import/Export/Reset Plugin Settings.
* Improvement: Now it indicates which tab is active.
* Improvement: Admin UI.
* Bug Fix.

= 1.2.3 =
Release Date: May 17, 2018

* Added: Author name support.
* Added: Dashboard column width.
* Added: Last modified author name in Admin bar.
* Change last modified dashicons.

= 1.2.2 =
Release Date: May 15, 2018

* Added: Human Readable Time/Date format.
* Added: Last modified info on admin bar.
* Added: Option to set the number of posts to show on dashboard widget.
* Added: Option to customize default 'at' date/time separator.
* Tweak: 3 separate option merged into 1 option in dashboard options to simplify plugin settings.
* Tweak: If a class is not set in the template tags option, then this plugin does not return any class.
* Improved: Admin UI.
* Minor bug fixed.

= 1.2.1 =
Release Date: May 13, 2018

* Improved: Template Tag support.

= 1.2.0 =
Release Date: May 12, 2018

* Added: Template Tag support.
* Minor Improvements.

= 1.1.9 =
Release Date: May 10, 2018

* UI Improvement.
* Bug Fix.

= 1.1.8 =
Release Date: May 10, 2018

* Added: Dashboard widget to show Last Modified posts.
* Improved: Schema Markup.

= 1.1.6 =
Release Date: May 7, 2018

* Improved: Custom Post Type Support.
* Bug Fixed.

= 1.1.5 =
Release Date: May 5, 2018

* Improved: Schama markup.
* Removed 'revised' meta tag output as it is no longer required.
* UI Improvements.
* Code Cleanup.

= 1.1.4 =
Release Date: May 4, 2018

* Added: last modified schema markup for posts.
* Bug Fixed.

= 1.1.3 =
Release Date: May 4, 2018

* Added: Now you can create the exception for both posts and pages.
* Bug Fixed.
* Cover photo update. Thanks to @svayam.

= 1.1.2 =
Release Date: May 3, 2018

* Added: Now you can customize date/time format.
* Bug Fixed.

= 1.1.0 =
Release Date: May 3, 2018

* Added: All Custom Post support, including WooCommerece.
* Now every last modified time in the dashboard shows, according to WordPress date/time format.
* Now shortcut will work only when the shortcut option is enabled.
* Tweak: Custom CSS Box returns empty style tag if there is no value.
* Bug Fixed.

= 1.0.9 =
Release Date: April 29, 2018

* Added: Last updated info now shows on the publishing meta box.
* Remove some unwanted conditions.
* Fix WooCommerce admin notice.
* Bug fixed.

= 1.0.8 =
Release Date: April 28, 2018

* Add WooCommerce Support.
* Multisite compatibility.
* Last login info added.
* Remove 304 response headers as it is enabled by default by many cache plugins.
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

* Initial release.