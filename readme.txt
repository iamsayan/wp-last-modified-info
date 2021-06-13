=== WP Last Modified Info ===
Contributors: infosatech
Tags: last modified, timestamp, modified time, post modified, sort by modified, time, date 
Requires at least: 4.7
Tested up to: 5.8
Stable tag: 1.7.7
Requires PHP: 5.6
Donate link: https://www.paypal.me/iamsayan/
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

🔥 Ultimate Last Modified Solution for WordPress. Adds last modified date and time automatically on pages and posts very easily. It is possible to use shortcodes to display last modified info anywhere on a WordPress site running 4.7 and beyond.

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
7. Template Tags Options.
8. Email Notification.
9. Miscellaneous Options.

== Changelog ==

If you like WP Last Modified Info, please take a moment to [give a 5-star rating](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post). It helps to keep development and support going strong. Thank you!

= 1.7.7 =
Release Date: June 13, 2021

* Removed: WP Backgroud Processing Library. You can use [Migrate WP Cron to Action Scheduler](https://wordpress.org/plugins/migrate-wp-cron-to-action-scheduler/) Plugin to overcome the limitation of WP Cron.
* Improved: Added a hook to fetch plugin data just after plugin upgradation.
* Corrected Template Tags wrong Tab name.
* Compatibility with WordPress v5.7.

= 1.7.6 =
Release Date: December 25, 2020

* Added: Modified Date Time Bulk Update Capability.
* Added: Option to view posts which are included in Disable Update list.
* Fixed: Post order displays as Modified by default on some installations.
* Fixed: Reverted back to the old method of post meta replace.
* Improved: Admin Settings Page UI.
* Compatibility with WordPress v5.6.

= 1.7.5 =
Release Date: September 30, 2020

* Fixed: PHP Fatal error on plugin activation.

= 1.7.4 =
Release Date: September 30, 2020

* Added: Ability to show plugins last modified info on plugins page.
* Fixed: HTML non-spacing issue on post ecit screen.
* Fixed: `datePublished` schema is replaced by `dateModified` automatically even if schema output is disabled from plugin settings.

= 1.7.3 =
Release Date: September 27, 2020

* Added: Ability to remove/hide post dates from search engines completely.
* Fixed: PHP Fatal error in WordPress version less than v4.9.0.
* Fixed: A bug where last modified info was not showing using shortcode if "Change Original Time to Modified Time" option was enabled from Misc Options.
* Tweak: Added some CSS adjustments to make it more easy.
* Tweak: Properly set HTML element's CSS Class names.
* Twaek: The minimun required WordPress version is now v4.7.0.
* Tweak: Increased rating notice auto show time interval.
* Tweak: Cache will be automatically purged the modified date is changed.
* Tweak: Custom modified date which is greater than original published date is only accepted in Products also.
* Tweak: Correct modified date was not properly reflected for products if custom modified date is being set from quick edit.
* Tweak: Increased priority of `the_content` hook to `5`.
* Tweak: `<p></p>` tag will be removed automatically from shortcode.
* Tweak: Added improved replace date mechanism to make it work properly with any caching or minification plugin.
* Tweak: From now, `itemprop="datePublished"` schema will be replaced automatically with `itemprop="dateModified"`. It can be disabled by `wplmi/published_schema_replace` filter.
* Other minor improvements and fixes.

= 1.7.2 =
Release Date: August 14, 2020

* Added: Ability to use Template Tag as Shortcode.
* Tweak: From now custom modified date which is greater than original published date is only accepted.
* Tweak: Make Global Site modified info Date translable.
* Fixed: Variable not found PHP warning on user list page.
* Fixed: A bug where Actual post published date is not translating.
* Fixed: A bug where Plugin shows error on dev console if Syntax Highlighting is disabled from Profile settings.
* Other minor improvements.

= 1.7.1 =
Release Date: August 12, 2020

* Added: Some PostView template tags.
* Added: An option to Copy and Paste plugin settings to Export and Import respectively.
* Fixed: Astra & GeneratePress Schema Output.
* Fixed: Elemetor Schema Output.
* Other minor improvements.

= 1.7.0 =
Release Date: August 11, 2020

IMPORTANT: As various changes introduced in this plugin, please re-configure your plugin settings after update, otherwise, it may stop working.

* Improvement: Rewrite the plugin from scratch.
* Added: Templateting system to customize the output as you want.
* Added: A method to replace post published date with post modified date. It will only work on Single Post Page.
* Added: Some validations to check if the custom modified date is a valid past date.
* Added: An option to hide last modified info on various archives from plugin settings.
* Added: Dedicated CSS editor to enable syntax highlighting.
* Added: Option to show Last Modified Author Avatar using Elementor.
* Added: Lots of filters and hooks to make the plugin customizable.
* Tweak: Traditional Date Format and Time Format field is merged into one field.
* Tweak: Better theme (Astra & GeneratePress) compatibility.
* Tweak: Notification Email will only add an only valid email and this field is now not mandatory.
* Tweak: Modified Date Update is disabled for Scheduled and Draft Posts.
* Tweak: Modified info will be shown only if the Published date is not equal to the modified date.
* Tweak: CTRL+S will save the plugin settings automatically.
* Fixed: A bug where WooCommerce Product Modified Date is changed automatically even the Disabled option is checked.
* Fixed: Some CSS and JS issues.
* Various improvements introduced.
* Compatibility with WordPress v5.5.
* Plugin now strictly requires PHP v5.6 or higher.

= Other Versions =

* View the <a href="https://plugins.svn.wordpress.org/wp-last-modified-info/trunk/changelog.txt" target="_blank">Changelog</a> file.

== Upgrade Notice ==

= 1.7.0 =
In this release, we make this plugin compatible with WordPress 5.5. Please re-configure your plugin settings, otherwise it may stop working.