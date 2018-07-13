=== WP Last Modified Info ===
Contributors: Infosatech
Tags: last modified info, shortcode, short by column, time, date 
Requires at least: 3.5
Tested up to: 4.9
Stable tag: 1.2.10
Donate link: http://bit.ly/2I0Gj60
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Display last modified date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 3.2 and beyond.

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
* Allows you to add last modified timestamp in post/page's custom field.
* And you can customize all and everything.

#### Compatibility

This plugin is fully compatible with WordPress Version 3.5 and beyond and also compatible with any WordPress theme.

#### Support
* Community support via the [support forums at wordpress.org](https://wordpress.org/support/plugin/wp-last-modified-info)
* We don’t handle support via email, Twitter, GitHub issues etc.

#### Contribute
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Pull requests for documenting bugs are highly appreciated.
* If you think you’ve found a bug (e.g. You’re experiencing unexpected behaviour), please post on the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) first.

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

This plugin hooks into the WordPress content area and displays the last modified information on posts and pages.

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

1. Show last modified info on the frontend
2. Google Structured data result
3. Post / Page / Custom post types admin column: Last Modified column with author name.
4. Added last modified/updated info on post/page publish box and in post updated message.
5. Auto-generate last modified info in custom fields after post/page save.
6. Last modified posts widgets in the dashboard.
7. Post Options
8. Page Options
9. Template Tag Options

== Changelog ==

= 1.2.10 =
Release Date: July 13, 2018

* Added: Option to set custom modified author name.
* Added: `lmt_custom_field_date_time_format` filter to set custom date/time format on custom fields. 
* Fix: Last Modified post display issue on dashboard widget with user roles except for administrator.
* Remove some plugin options to simplify plugin settings.
* Improved: Admin UI.

IMPORTANT!

* Please delete all caches and press CTRL+F5 on website front-end/back-end after updating this plugin if there is any CSS/js problem.

= 1.2.9 =
Release Date: June 23, 2018

* Added: You can now disable modified info update every time after the post is saved.
* Typo Fix.

= 1.2.8 =
Release Date: June 20, 2018

* Fix: Error notice after plugin update.
* Fix: Shortcode does not work properly if 'Using Shortcode' method is enabled.

= 1.2.7 =
Release Date: June 20, 2018

* Added: Now Last updated info now shows as post updated message.
* Improved: Dropdown loading using Select2.
* Improved: Custom Post Types Support. Now it is possible to select custom post types individually.
* Tweak: Now it is possible to disable auto insert for particular post/page from the edit screen.
* Tweak: Remove 'Disable auto insert' fields to simplify plugin settings.
* Tweak: Active tab now depends on URL parameter also.
* Tweak: Last modified value will automatically be added into custom fields if 'Show Last Modified Info on Dashboard' option is on.
* Bug Fix.

= 1.2.6 =
Release Date: June 9, 2018

* Added: Option to enable/disable auto last modified info support for custom post types.
* Added: Support to add last modified info in custom fields after post/page update.
* Tweak: Tools is now merged with plugins settings page.
* Fixed a typo in the plugin description. Thanks to @buzztone.
* Bug Fix.

= Other Versions =

* View the <a href="https://plugins.svn.wordpress.org/wp-last-modified-info/trunk/changelog.txt" target="_blank">Changelog</a> file.