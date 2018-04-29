=== WP Last Modified Info ===
Contributors: Infosatech
Tags: last modified info, shortcode, short by column, time, date 
Requires at least: 4.4
Tested up to: 4.9
Stable tag: 1.0.9
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl.html

Show last update date and time on pages and posts very easily. You can use shortcode also to display last modified info anywhere on a WordPress site running 4.4 and beyond.

== Description ==

### WP Last Modified Info: the Ultimate Last Modified plugin

Most WordPress themes usually show the date when a post was last published. This is fine for most blogs and static websites. However, WordPress is also used by websites where old articles are regularly updated. This last updated date and time is important information for those publications. The most common example is news websites. They often update old stories to show new developments, add corrections, or media files. If they only added the published date, then their users would miss those updates.

Many popular blogs and websites don’t show any date on their articles. This is a bad practice and you should never remove dates from your blog posts.

#### What does this plugin do?

Using this plugin, you can show last modified info on your wordpress posts and pages. Add short code [lmt-post-modified-info] for posts and [lmt-page-modified-info] for pages. You can also enable revision meta tag for your pages and posts. With this plugin, you can also set custom styles.

#### Support
* Community support via the [support forums on wordpress.org](https://wordpress.org/support/plugin/wp-last-modified-info)
* We don’t handle support via e-mail, Twitter, GitHub issues etc.

#### Contribute
* Active development of this plugin is handled [on GitHub](https://github.com/iamsayan/wp-last-modified-info).
* Pull requests for documented bugs are highly appreciated.
* If you think you’ve found a bug (e.g. you’re experiencing unexpected behavior), please post at the [support forums](https://wordpress.org/support/plugin/wp-last-modified-info) first.

#### Bug reports

Bug reports for WP Last Modified Info are [welcomed on GitHub](https://github.com/iamsayan/wp-last-modified-info). Please note GitHub is not a support forum, and issues that arenâ€™t properly qualified as bugs will be closed.

== Installation ==

=== From within WordPress ===
1. Visit 'Plugins > Add New'.
1. Search for 'WP Last Modified Info'.
1. Activate WP Last Modified Info from your Plugins page.
1. Go to "after activation" below.

=== Manually ===
1. Upload the `wp-last-modified-info` folder to the `/wp-content/plugins/` directory.
1. Activate WP Last Modified Info plugin through the 'Plugins' menu in WordPress.
1. Go to "after activation" below.

=== After activation ===
1. After activation go to 'Settings > Last Modified Info'.
1. Enable options and save changes.

== Frequently Asked Questions ==

= How to use this plugin? =

Go to 'Settings > Last Modified Info' and check the options and hit 'save changes'.

= Is there an admin interface for this plugin? =

Yes. You can access this from 'Settings > Last Modified Info'

= How to check this is working? =

Open any page or post and you can see the change.

= How this plugin works? =

This plugin hooks into wordpress content area and shows last modified information of posts and pages.

= Is this plugin copmpatible with any themes? =

Yes, this plugin is compatible with any theme.

= How to customize last modified text css? =

Go to Settings > Last Modified Info > Custom CSS and write your custom css.

= Can I sort posts and pages by last modified info? =

Yes you can. You can sort posts and pages by ascending or desending order.

= Is this plugin good for SEO? =

Yes, absolutely. This plugin returns last modified info on both post and pages and also enable 'revision' meta tag which is good for SEO.

= Is this plugin compatible with multisite?

Yes, it is fully compatible with multisite.

= Can I customize 'Last Updated' text? =

Yes, you can. Write custom text in plugins page and save changes.

Use the plugin to test it.

== Screenshots ==

1. Post Options
2. Page Options
3. Dashboard Options
4. Custom CSS

== Changelog ==

= 1.0.9 =
Release Date: April 29, 2018

* Added: Last updated info now shows on publish meta box.
* Remove some unwanted conditions.
* Fix woocommerce admin notice.
* Bug fixed.

= 1.0.8 =
Release Date: April 28, 2018

* Add WooCommerce Support.
* Multisite compatibility.
* Last login info added.
* Remove 304 response header as it is enable by default by many cache plugins.
* Bug fixed.

= 1.0.6 =
Release Date: April 27, 2018

Bug Fix: 
* Undefined Variable notice shows when debug mode is enabled.
* Weekday is not showing with revision meta tag output.

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