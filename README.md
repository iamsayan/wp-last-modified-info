![WP Last Modified Info](.github/banner.png "Plugin Banner")

# WP Last Modified Info #

🔥 Display last modified date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 4.7 and beyond.

[![WP compatibility](https://plugintests.com/plugins/wp-last-modified-info/wp-badge.svg)](https://plugintests.com/plugins/wp-last-modified-info/latest) 
[![PHP compatibility](https://plugintests.com/plugins/wp-last-modified-info/php-badge.svg)](https://plugintests.com/plugins/wp-last-modified-info/latest)
![GitHub release (latest by date)](https://img.shields.io/github/v/release/iamsayan/wp-last-modified-info)
![PHP](https://img.shields.io/badge/php-v5.6%2B-blue)
![GitHub Release Date](https://img.shields.io/github/release-date/iamsayan/wp-last-modified-info?logo=github)
![GitHub last commit](https://img.shields.io/github/last-commit/iamsayan/wp-last-modified-info?logo=github)
![GitHub Repo stars](https://img.shields.io/github/stars/iamsayan/wp-last-modified-info?style=social)
![GitHub forks](https://img.shields.io/github/forks/iamsayan/wp-last-modified-info?style=social)

## Description ##

### WP Last Modified Info: the Ultimate Last Modified plugin for WordPress ###

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don't show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

So now it is possible to add last modified / updated info on your wordpress posts and pages. Just install and activate this and configuaration is very easy.

Like WP Last Modified Info plugin? Consider leaving a [5 star review](https://wordpress.org/support/plugin/wp-last-modified-info/reviews/?rate=5#new-post).

#### What does this plugin do?

This plugin automatically inserts last modified or updated info on your WordPress posts (including custom post types) and pages. It is possible to use shortcode `[lmt-post-modified-info]` for posts and `[lmt-page-modified-info]` for pages for manual insert. This plugin also adds 'dateModified' schema markup in WordPress posts automatically and it is used to tell the last modified date & time of a post or a page to various search engines like Google, Bing etc.

* Allows you to display Last modified information in your posts and pages individually.
* Provides you with options to display the last modified/last updated date above or below your posts and pages.
* You can also set date/time formats and the position of the timestamp in WordPress Posts and Pages which can be either before content or after the content.
* Allows you to customize the text which is to be displayed alongside the last modified date (default: Last updated on).
* Inserts ‘dateModified’ schema markup to your WordPress posts automatically.
* Allows you to display last modified info on all post types column and publish meta box in the dashboard with the author name.
* Allows you to sort posts/pages in last updated/modified date time order.
* Allows you to replace post published date with post modified info.
* Allows you to display last modified info on your post as human readable format, i.e. Days/weeks/months/years ago.
* Allows you to display last modified info of all posts in the WordPress admin bar.
* Allows you to display last modified author info in posts, pages.
* Allows you to add last modified timestamp in post/page's custom field.
* Allows you to edit last modified date and time from the post edit screen and quick edit screen also.
* You can also add template tags to your theme files. Go to the FAQ section for more information.
* Elementor Dynamic Tags support with 'dateModified' schema markup.
* Send Email Notification when anyone makes changes to any post of your website.
* And you can customize all and everything.

### Compatibility ###

* This plugin is fully compatible with WordPress Version 4.7 and beyond and also compatible with any WordPress theme.

### Support ###
* Community support via the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) at wordpress.org.

### Contribute ###
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Feel free to [fork the project on GitHub](https://github.com/iamsayan/wp-last-modified-info) and submit your contributions via pull request.

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
1. After activation go to 'Settings > WP Last Modified Info'.
1. Enable/disable options and save changes.

### Frequently Asked Questions ###

#### Is there any admin interface for this plugin? ####

Yes. You can access this from 'Settings > WP Last Modified Info'.

#### How to use this plugin? ####

Go to 'Settings > WP Last Modified Info', enable/disable options as per your need and save your changes.

#### How to check this plugin is working? ####

After enable options in 'Settings > WP Last Modified Info', open any page or post and you can see the change.

#### How this plugin works? ####

This plugin hooks into wordpress content area and displays last modified information on posts and pages.

#### Will it requires editing code to show Last Modified date? ####

Not at all. You can show the revised info by just installing this plugin. Use the Plugin Options to customize the date/time according to your need.

#### Is this plugin compatible with any themes? ####

Yes, this plugin is compatible with any theme.

#### Does this plugin support all custom post types? ####

Yes, this plugin supports all types of custom posts.

#### How to customize last modified text style? ####

Go to 'Settings > WP Last Modified Info > Misc. Options > Custom CSS' and add your custom css.

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

#### Published date is equal to modified date. What is the solution? ####

Sometimes you may want to show last modified date only. For that reason, post published date and modified date would be the same and the last modified date will still appear on post/pages even if it’s the same as the published date. In that case, you can set a time difference(ex. 1 day i.e. 24 hours) between post published date and modified date via plugin settings gap option.

#### The plugin isn't working or have a bug? ####

Post detailed information about the issue in the [support forum](https://wordpress.org/support/plugin/wp-last-modified-info) and I will work to fix it.

## Changelog ##
[View Changelog](CHANGELOG.md)
