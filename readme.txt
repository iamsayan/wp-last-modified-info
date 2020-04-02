=== WP Last Modified Info ===
Contributors: infosatech
Tags: last modified, timestamp, modified time, post modified, sort by modified, time, date 
Requires at least: 4.6
Tested up to: 5.4
Stable tag: 1.6.6
Requires PHP: 5.6
Donate link: https://www.paypal.me/iamsayan/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

🔥 Ultimate Last Modified Solution for WordPress. Adds last modified date and time automatically on pages and posts very easily. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.6 and beyond.

== Description ==

### WP Last Modified Info: the Ultimate Last Modified plugin

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don't show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

So now it is possible to add last modified / updated info on your WordPress posts and pages. Just install and activate this and configuration is very easy.

Like WP Last Modified Info plugin? Consider leaving a [5 star review](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post).

#### What does this plugin do?

This plugin automatically inserts last modified or updated info on your WordPress posts (including custom post types) and pages. It is possible to use shortcode `[lmt-post-modified-info]` for posts and `[lmt-page-modified-info]` for pages for manual insert. This plugin also adds 'dateModified' schema markup in WordPress posts automatically and it is used to tell the last modified date & time of a post or a page to various search engines like Google, Bing etc.

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

* This plugin is fully compatible with WordPress Version 4.6 and beyond and also compatible with any WordPress theme.
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

CSS Classes:

`.post-last-modified`: use this class for posts.

`.post-last-modified-text`: use this class for posts prefix.

`.post-last-modified-td`: use this class if you want to add style only to last modified date/time on posts.

`.post-modified-author`: use this class for post author.

`.page-last-modified`: use this class for pages.

`.page-last-modified-text`: use this class for pages prefix.

`.page-last-modified-td`: use this class if you want to add style only to last modified date/time on the pages.

`.page-modified-author`: use this class for page author.

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

1. Show last modified info on the front end
2. Google Structured data result
3. Post / Page / Custom post types admin column: Last Modified column with author name.
4. Added last modified/updated info on post/page publish box and in post updated message.
5. Last modified posts widgets in the dashboard.
6. Post Options
7. Page Options
8. Template Tag Options
9. Email Notification

== Changelog ==

If you like WP Last Modified Info, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!

= 1.6.6 =
Release Date: April 2, 2020

* NEW: Added Shortcode `[lmt-site-modified-info]` to display website modified time. It will trigger when a post is saved.
* NEW: Added a method to directly replace the post published date with post modified date. This feature may not work with some themes.
* Added: `%post_link%` variable to PHP Output Buffer replace process.
* Added: Ablity to sort posts on frontend by post modified date.
* Tweak: Removed the required from Noti Post Types fields as sometime it prevents plugin from save the data.
* Tweak: Form now "Text before Last Modified Info" fields do not support and HTML tags. You can use `post-last-modified-text` CSS class for posts, `page-last-modified-text` CSS class for pages and `tt-last-modified-text` CSS class for template tags to apply styles.
* Fixed: Properly sanitizes input and escapes the output to prevent a XSS vulnerability. Thanks to @Jeroen Mulder.
* Fixed: Some CSS and JS issues.
* Compatibilty with WordPress v5.4.

= 1.6.5 =
Release Date: December 21, 2019

* Fixed: Post Link is showing when post is updated for non-public posts.
* Fixed: Incorrect HTML tag output in post edit page.
* Fixed: Some Browser JS warnings.
* Fixed: Some CSS issues with WordPress v5.3.2.

= 1.6.4 =
Release Date: November 27, 2019

* Fixed: Compatibility with Rank Math and Yoast SEO for their recent changes.
* Fixed: Fixed an error of `dateModified` showing an incorrect time when timezone was not set to UTC.

= 1.6.3 =
Release Date: November 24, 2019

* NEW: Added a new filter hook `wplmi_post_disable_update_default_check` to auto lock modified info in post edit page.
* Improved: Check/uncheck "Disable Update" option is separated from now.
* Fixed: Check/uncheck "Disable Update" option is not working on draft posts.
* Fixed: A minor CSS issue.
* Other minor improvemnts and fixes.

= 1.6.2 =
Release Date: November 16, 2019

* Compatibility with WordPress 5.3.
* Improved: Now it is possible to check/uncheck "Disable Update" option globally.
* Fixed: Some broken links.
* Fixed: Minor CSS issue.
* Fixed: Column Header sorting is not working properly.
* Removed: Some unnessary files.
* Other minor improvemnts and fixes.

= 1.6.1 =
Release Date: August 26, 2019

* Added: An option to set authot link target.
* Fixed: Unclosed HTML tags.
* Removed: Some duplicate codes.

= 1.6.0 =
Release Date: August 9, 2019

* Added: A filter `wplmi_custom_schema_post_date_fotmat` to compatible any theme with Compatibility Schema Mode.
* Added: A filter `wplmi_switch_global_replace_hook` to switch the Global Replace action hook.
* Added: Post Shortcode attribute to enable output on search pages.
* Improved: Last Modified Posts Dashboard Widget.
* Improved: Compatibility between the Newspaper theme and Advanced Schema Mode.
* Fixed: An issue which prevents plugin settings from saving.
* Fixed: JS error in Browser Console.
* Fixed: Unclosed HTML tag.

= Other Versions =

* View the <a href="https://plugins.svn.wordpress.org/wp-last-modified-info/trunk/changelog.txt" target="_blank">Changelog</a> file.

== Upgrade Notice ==

= 1.6.6 =
In this release, we make this plugin compatible with WordPress 5.4.