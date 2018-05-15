![alt text](https://github.com/iamsayan/wp-last-modified-info/raw/master/banner.png "Plugin Banner")

# WP Last Modified Info #

Display last modified date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 4.4 and beyond.

## Description ##

### WP Last Modified Info: the Ultimate WordPress Last Modified plugin ###

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don’t show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

### What does this plugin do? ###

Using this plugin, display last modified info of your wordpress posts and pages. Use shortcode `[lmt-post-modified-info]` for posts and `[lmt-page-modified-info]` for pages. This plugin also adds 'dateModified' schema markup on WordPress posts automatically.

* Allows you to display Last modified information in your posts and pages individually.
* Provides you with options to display the last modified/last updated date above or below your posts and pages. You can also set date/time formats and the position of the timestamp in WordPress Posts and Pages which can be either before content or after the content.
* Allows you to customize the text which is to be displayed alongside the last modified date (default: Last updated on).
* Inserts 'dateModified' schema markup to your WordPress posts automatically.
* Allows you to display last modified info on all post types column and publish meta box in the dashboard.
* Allows you to sort posts/pages of last updated/modified info.
* Allows you to display last modified info on your post as human readable format i.e. Days/weeks/months/years ago.
* Allows you to display last modified info of all posts in the WordPress admin bar.
* You can also add template tags to your theme files. Go to the FAQ section for more information.
* And you can customize all and everything.

### Compatibility ###

This plugin is fully compatible with WordPress Version 4.4 and beyond and also compatible with any wordpress theme.

### Support ###
* Community support via the [support forums on wordpress.org](https://wordpress.org/support/plugin/wp-last-modified-info)
* We don’t handle support via e-mail, Twitter, GitHub issues etc.

### Contribute ###
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Pull requests for documented bugs are highly appreciated.
* If you think you’ve found a bug (e.g. you’re experiencing unexpected behavior), please post at the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) first.

## Installation ##

### From within WordPress ###
1. Visit 'Plugins > Add New'.
1. Search for 'WP Last Modified Info'.
1. Activate WP Last Modified Info from your Plugins page.
1. Go to "after activation" below.

### Manually ###
1. Upload the `wp-last-modified-info` folder to the `/wp-content/plugins/` directory.
1. Activate WP Last Modified Info plugin through the 'Plugins' menu in WordPress.
1. Go to "after activation" below.

### After activation ###
1. After activation go to 'Settings > Last Modified Info'.
1. Enable/disable options and save changes.

### Frequently Asked Questions ###

#### Is there any admin interface for this plugin? ####

Yes. You can access this from 'Settings > Last Modified Info'.

#### How to use this plugin? ####

Go to 'Settings > Last Modified Info', enable/disable options as per your need and save your changes.

#### How to check this plugin is working? ####

After enable options in 'Settings > Last Modified Info', open any page or post and you can see the change.

#### How this plugin works? ####

This plugin hooks into wordpress content area and displays last modified information on posts and pages.

#### Will it requires editing code to show Last Modified date? ####

Not at all. You can show the revised info by just installing this plugin. Use the Plugin Options to customize the date/time according to your need.

#### Is this plugin compatible with any themes? ####

Yes, this plugin is compatible with any theme.

#### Does this plugin support all custom post types? ####

Yes, this plugin supports all types of custom posts.

#### How to customize last modified text style? ####

Go to 'Settings > Last Modified Info > Custom CSS' and add your custom css.

##### CSS Classes: #####

`.post-last-modified`: use this class for posts.

`.post-last-modified-td`: use this class if you want to add style only to last modified date/time on posts.

`.page-last-modified`: use this class for pages.

`.page-last-modified-td`: use this class if you want to add style only to last modified date/time on pages.

#### Can I sort posts and pages by last modified info in dashboard? ####

Yes you can. You can sort posts and pages by ascending or desending order.

#### How this plugin helps to optimize SEO? ####

This plugin wraps modified info with ‘dateModified’ schema markup which is used to tell the last modified date & time of a webpage to various web crawlers (Google, Bing etc.)

#### The Date and Time inserted by this plugin is dependent on what? ####

The plugin make use of your WordPress Date, Time and Time zone (Dashboard > Settings > General) in wordpress dashboaard.

#### Is this plugin compatible with multisite? ####

Yes, it is fully compatible with multisite.

#### Can I change 'Last Updated on' text? ####

Yes, you can. Just set your custom text in settings and save your changes.

#### Can I use this as template tag? ####

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

## Changelog ##
[View Changelog](CHANGELOG.md)
