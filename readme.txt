=== WP Last Modified Info ===
Contributors: infosatech
Tags: last modified, timestamp, modified time, post modified, sort by modified
Requires at least: 4.7
Tested up to: 6.6
Stable tag: 1.9.1
Requires PHP: 7.0
Donate link: https://www.paypal.me/iamsayan/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Ultimate Last Modified Plugin for WordPress with Gutenberg Block Integration. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.7 and beyond.

== Description ==

### WP Last Modified Info: the Ultimate Last Modified plugin

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don't show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

So now it is possible to add last modified/updated info on your WordPress posts and pages. Just install and activate this and configuration is very easy.

Like WP Last Modified Info plugin? Consider leaving a [5-star review](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post).

#### What does this plugin do?

This plugin automatically inserts last modified or updated info on your WordPress posts (including custom post types) and pages. It is possible to use shortcode `[lmt-post-modified-info]` for a manual insert. This plugin also adds 'dateModified' schema markup in WordPress posts automatically and it is used to tell the last modified date & time of a post or a page to various search engines like Google, Bing etc.

* Allows you to display **Last modified** information in your **posts and pages individually**.
* Provides you with options to display the **last modified/last updated date above or below your posts and pages**.
* You can also set date/time formats and the position of the timestamp in WordPress Posts and Pages which can be either before content or after the content.
* Allows you to **customize the text which is to be displayed alongside the last modified date** (default: Last updated on).
* **Inserts ‘dateModified’ schema markup to your WordPress posts automatically**.
* **Displays last modified info on all post types column and publish meta box in the dashboard with the author name.**
* Allows you to **sort posts/pages in last updated/modified date-time order**.
* Allows you to **replace post published date with post modified info**.
* Allows you to **display last modified info** on your post as **human-readable format**, i.e. Days/weeks/months/years ago.
* Allows you to display last modified info of all posts in the WordPress admin bar.
* Allows you to **display last modified author info in posts, pages**.
* Allows you to **add last modified timestamp in post/page's custom field**.
* **Allows you to edit last modified date and time from the post edit screen and quick edit screen as well**.
* You can also add **template tags** to your theme files. Go to the FAQ section for more information.
* **Elementor Dynamic Tags** support with **'dateModified' schema markup**.
* Send **Email Notification when anyone makes changes to any post** of your website.
* **Tested with Yoast SEO, Rank Math, All in One SEO Pack, SEOPress, Schema** and many other plugins.
* And you can customize all and everything.

#### Compatibility

* This plugin is fully compatible with WordPress Version 4.7 and beyond and also compatible with any WordPress theme.
* Fully compatible with Yoast SEO, Rank Math, All in One SEO Pack, SEOPress, Schema and other many plugins.

#### Support
* Community support via the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) at WordPress.org.

#### Contribute
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Feel free to [fork the project on GitHub](https://github.com/iamsayan/wp-last-modified-info) and submit your contributions via pull request.

== Installation ==

1. Visit 'Plugins > Add New'.
1. Search for 'WP Last Modified Info' and install it.
1. Or you can upload the `wp-last-modified-info` folder to the `/wp-content/plugins/` directory manually.
1. Activate WP Last Modified Info from your Plugins page.
1. After activation go to 'Settings > WP Last Modified Info'.
1. Enable options and save changes.

== Frequently Asked Questions ==

= Is there any admin interface for this plugin? =

Yes. You can access this from 'Settings > WP Last Modified Info'.

= How to use this plugin? =

Go to 'Settings > WP Last Modified Info', enable/disable options as per your need and save your changes.

= How to check this plugin is working? =

After enabling options in 'Settings > WP Last Modified Info', open any page or post and you can see the change.

= How this plugin works? =

This plugin hooks into the WordPress content area and displays the last modified information on posts and pages.

= Will it requires editing code to show Last Modified date? =

Not at all. You can show the revised info by just installing this plugin. Use the Plugin Settings to customize the date/time format according to your need.

= Is this plugin compatible with any themes? =

Yes, this plugin is compatible with any theme. Also, compatible with Genesis, Divi themes.

= Does this plugin support all custom post types? =

Yes, this plugin supports all types of custom posts.

= How to customize last modified text style? =

Go to 'Settings > WP Last Modified Info > Misc. Options > Custom CSS' and add your custom CSS.

= Can I sort posts and pages by last modified info in the dashboard? =

Yes, you can. You can sort posts and pages by ascending or descending order.

= How this plugin helps to optimize SEO? =

This plugin wraps modified info with 'dateModified' schema markup which is used to tell the last modified date & time of a web page to various web crawlers (Google, Bing etc.). [Test your website with structured data tool](https://search.google.com/structured-data/testing-tool).

= The Date and Time inserted by this plugin is dependent on what? =

The plugin makes use of your WordPress Date, Time and Timezone (Dashboard > Settings > General) in the WordPress dashboard. It is also customizable via plugin settings.

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

= Published date is equal to the modified date. What is the solution? =

Sometimes you may want to show last modified date only. For that reason, post published date and modified date would be the same and the last modified date will still appear on post/pages even if it’s the same as the published date. In that case, you can set a time difference(ex. 1 day i.e. 24 hours) between post published date and modified date via plugin settings gap option.

= The plugin isn't working or have a bug? =

Post detailed information about the issue in the [support forum](https://wordpress.org/support/plugin/wp-last-modified-info) and I will work to fix it.

== Screenshots ==

1. Show last modified info on the front end.
2. Google Structured data result.
3. Post / Page / Custom post types admin column: Last Modified column with author name.
4. Added last modified/updated info on post/page publish box and in post updated message.
5. Last modified posts widgets in the dashboard.
6. Post Options.
7. Template Tag Options.
8. Schema Options
9. Email Notification.
10. Miscellaneous Options.

== Changelog ==

If you like WP Last Modified Info, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!

= 1.9.1 =
Release Date: August 9, 2024

* Added changes according to WPCS.
* Tested with WordPress v6.6.

= 1.9.0 =
Release Date: March 17, 2024

* Optimize WP Options Auto Loading.
* Updated Composer Libraries.
* Tested with WordPress v6.5.

= 1.8.9 =
Release Date: February 9, 2024

* Added: Lock Modified Date Block Editor Support for Custom Post type which has `show_in_rest` set to `true`. This behavior can be changed by `wplmi/post_type_args` filter.
* Updated: @wordpress/scripts to the latest version.
* Updated: Background Process PHP Library.
* Tweak: Replaced deprecated `__experimentalGetSettings()` with `getSettings()`.
* Tweak: Use of `wp_kses_allowed_html` filter to allow custom HTML tag instead of using placeholders.
* Added support for PHP v8.3.
* Minimum required PHP Version is now 7.0.
* Tested with WordPress v6.4.

= 1.8.8 =
Release Date: June 26, 2023

* Added: Integration with AIOSEO Plugin last modified update checkbox.
* Updated: @wordpress/scripts to the latest version.
* Updated: Selectize JS Library.
* Updated: Background Process PHP Library.
* Tweak: Changed Toogle to Checkbox Control.
* Fixed: Deprecated Button Component parameter.
* Fixed: PHP Errors on Plugins page.
* Fixed: Properly support the id attribute in the shortcode. Props to @yoren.
* Tested with WordPress v6.2.

= 1.8.7 =
Release Date: January 25, 2023

* Fixed: Modified date is not showing on some cases.
* Fixed: Bulk Edit save delay.
* Fixed: Some Dashboard CSS.
* Added: Wiki Link to Dynamic Tags Section.

= 1.8.6 =
Release Date: January 24, 2023

* Fixed: Modified date is not showing if "Post Date Time Change or Removal" is set to "Convert to Modified Date" after last update.

= 1.8.5 =
Release Date: January 5, 2023

* Fixed: PHP Error if the the global post object is undefined.
* Fixed: WooCommerce product modified date updated even if the option is disabled.
* Fixed: Update Locked posts was showing all posts in post list page.
* Fixed: Lock the Modified Date option was not working properly.
* Fixed: Bulk Editing was not working.
* Tweak: Allow Toogle Disable Update Option for all post types and posts with future date.
* Imporved: Optimize codebase.
* Imporved: Dashboard styling.
* Tested with WordPress v6.1.

= 1.8.4 =
Release Date: July 29, 2022

* Added: User Column Sorting.
* Fixed: Quick Edit HTML issue.
* Fixed: Default Post Type ordering was not working.
* Fixed: JS issue if Syntax Highlighting is disabled from User Profile.
* Fixed: PHP Warning: Undefined property.

= 1.8.3 =
Release Date: May 30, 2022

* Fixed: Bulk Editing is not working.
* Fixed: Dashbaord Widget Posts List Order was wrong on some cases.

= 1.8.2 =
Release Date: May 24, 2022

* Fixed: Block Editor JS Errors on some cases.
* Fixed: Dashboard Widget showing wrong timestamp.
* Fixed: Widget Editor is not loading some cases if this plugin is active.
* Fixed: Block Rendering issue if custom colors are specified in theme.json.
* Added: Nonce checking on Dashbaord Widget.

= 1.8.1 =
Release Date: May 22, 2022

* Fixed: Notice can't be dismissed and causing a error.

= 1.8.0 =
Release Date: May 21, 2022

* NEW: New Plugin UI.
* NEW: Block Editor Controls.
* NEW: Added 3 New Blocks for WordPress 5.8 and beyond.
* Improvement: Enhanced Escaping.
* Improvement: Plugin Rating is now calcualted out of 5.
* Improvement: Use of Vanilla JS instead of jQuery to Replace Post Date.
* Improvement: Remove Plugin Update data on Deactivation.
* Improvement: Uses Post ID instead on WP Post Object to reduce memory usage.
* Fixed: Dashboard Widget Issue.
* Fixed: Elementor Deprecated issue.
* Fixed: The issue where plugin returns true even if there is no value in settings.
* Fixed: Rest API Output error if `get_userdata()` function returns false.
* Removed: Astra and GeneratePress Theme support.
* Removed: jQuery Cookie Library.
* Added filter `wplmi/plugin_links` for plugin links output.
* Tested with WPML.
* Development is now done in GitHub.
* Compatibility with WordPress v6.0 and PHP v8.0.

= Other Versions =

* View the <a href="https://plugins.svn.wordpress.org/wp-last-modified-info/trunk/changelog.txt" target="_blank">Changelog</a> file.
