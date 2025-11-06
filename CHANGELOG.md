# Changelog
All notable changes to this project will be documented in this file.

## 1.9.3
Release Date: November 11, 2025

* Improved: WooCommerce integration now fully supports High-Performance Order Storage (HPOS) without deprecation notices.
* Improved: Template tags (`get_the_last_modified_info`, `the_last_modified_info`) optimized for better performance and readability.
* Improved: Admin-column display now uses proper sanitization and escaping for all user-facing strings.
* Improved: Schema markup generation refactored for better compatibility with Google Rich-Results Test and Bing Validator.
* Improved: Shortcode `[lmt-post-modified-info]` processing streamlined; output is now 25 % faster on large pages.
* Improved: All PHP functions include comprehensive docblocks and parameter/return type declarations.
* Fixed: Potential undefined-array-key warnings when post-meta is accessed before initialization.
* Fixed: Edge-case where timezone offset could be miscalculated for posts modified during DST transitions.
* Fixed: Removed unused legacy JavaScript variables that caused console warnings in Site Editor.

## 1.9.2
Release Date: April 28, 2025

* Improved: Last Modified control on Gutenberg editor.
* Improved: Matched Last Modified admin column date format with WordPress's date column.
* Fixed: Gutenberg Console warnings on Edit page.
* Fixed: _load_textdomain_just_in_time Error.
* Fixed: Array to String conversion Error.
* Fixed compatibility issues with latest WordPress version.
* Compatibility with Rank Math plugin on lock modified date.
* Improved plugin performance and stability.
* Updated composer dependencies to latest versions.
* Code optimization and cleanup.
* Tested with WordPress v6.8.

## 1.9.1
Release Date: August 9, 2024

* Added changes according to WPCS.
* Tested with WordPress v6.6.

## 1.9.0
Release Date: March 17, 2024

* Optimize WP Options Auto Loading.
* Updated Composer Libraries.
* Tested with WordPress v6.5.

## 1.8.9
Release Date: February 9, 2024

* Added: Lock Modified Date Block Editor Support for Custom Post type which has `show_in_rest` set to `true`. This behavior can be changed by `wplmi/post_type_args` filter.
* Updated: @wordpress/scripts to the latest version.
* Updated: Background Process PHP Library.
* Tweak: Replaced deprecated `__experimentalGetSettings()` with `getSettings()`.
* Tweak: Use of `wp_kses_allowed_html` filter to allow custom HTML tag instead of using placeholders.
* Added support for PHP v8.3.
* Minimum required PHP Version is now 7.0.
* Tested with WordPress v6.4.

## 1.8.8
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

## 1.8.7
Release Date: January 25, 2023

* Fixed: Modified date is not showing on some cases.
* Fixed: Bulk Edit save delay.
* Fixed: Some Dashboard CSS.
* Added: Wiki Link to Dynamic Tags Section.

## 1.8.6
Release Date: January 24, 2023

* Fixed: Modified date is not showing if "Post Date Time Change or Removal" is set to "Convert to Modified Date" after last update.

## 1.8.5
Release Date: January 5, 2023

* Fixed: PHP Error if the the global post object is undefined.
* Fixed: WooCommerce product modified date updated even if the option is disabled.
* Fixed: Update Locked posts was showing all posts in post list page.
* Fixed: Lock the Modified Date option was not working properly.
* Fixed: Bulk Editing was not working.
* Tweak: Allow Toogle Disable Update Option for all post types and posts with future date.
* Imporved: Optimize codebase.
* Tested with WordPress v6.1.

## 1.8.4
Release Date: July 29, 2022

* Added: User Column Sorting.
* Fixed: Quick Edit HTML issue.
* Fixed: Default Post Type ordering was not working.
* Fixed: JS issue if Syntax Highlighting is disabled from User Profile.
* Fixed: PHP Warning: Undefined property.

## 1.8.3
Release Date: May 30, 2022

* Fixed: Bulk Editing is not working.
* Fixed: Dashbaord Widget Posts List Order was wrong on some cases.

## 1.8.2
Release Date: May 24, 2022

* Fixed: Block Editor JS Errors on some cases.
* Fixed: Dashboard Widget showing wrong timestamp.
* Fixed: Widget Editor is not loading some cases if this plugin is active.
* Fixed: Block Rendering issue if custom colors are specified in theme.json.
* Added: Nonce checking on Dashbaord Widget.

## 1.8.1
Release Date: May 22, 2022

* Fixed: Notice can't be dismissed and causing a error.

## 1.8.0
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

## 1.7.7
Release Date: June 13, 2021

* Removed: WP Backgroud Processing Library. You can use [Migrate WP Cron to Action Scheduler](https://wordpress.org/plugins/migrate-wp-cron-to-action-scheduler/) Plugin to overcome the limitation of WP Cron.
* Improved: Added a hook to fetch plugin data just after plugin upgradation.
* Corrected Template Tags wrong Tab name.
* Compatibility with WordPress v5.7.

## 1.7.6
Release Date: December 25, 2020

* Added: Modified Date Time Bulk Update Capability.
* Added: Option to view posts which are included in Disable Update list.
* Fixed: Post order displays as Modified by default on some installations.
* Fixed: Reverted back to the old method of post meta replace.
* Improved: Admin Settings Page UI.
* Compatibility with WordPress v5.6.

## 1.7.5
Release Date: September 30, 2020

* Fixed: PHP Fatal error on plugin activation.

## 1.7.4
Release Date: September 30, 2020

* Added: Ability to show plugins last modified info on plugins page.
* Fixed: HTML non-spacing issue on post ecit screen.
* Fixed: `datePublished` schema is replaced by `dateModified` automatically even if schema output is disabled from plugin settings.

## 1.7.3
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

## 1.7.2
Release Date: August 14, 2020

* Added: Ability to use Template Tag as Shortcode.
* Tweak: From now custom modified date which is greater than original published date is only accepted.
* Tweak: Make Global Site modified info Date translable.
* Fixed: Variable not found PHP warning on user list page.
* Fixed: A bug where Actual post published date is not translating.
* Fixed: A bug where Plugin shows error on dev console if Syntax Highlighting is disabled from Profile settings.
* Other minor improvements.

## 1.7.1
Release Date: August 12, 2020

* Added: Some PostView template tags.
* Added: An option to Copy and Paste plugin settings to Export and Import respectively.
* Fixed: Astra & GeneratePress Schema Output.
* Fixed: Elemetor Schema Output.
* Other minor improvements.

## 1.7.0
Release Date: August 11, 2020

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

## 1.6.6
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

## 1.6.5
Release Date: December 21, 2019

* Fixed: Post Link is showing when post is updated for non-public posts.
* Fixed: Incorrect HTML tag output in post edit page.
* Fixed: Some Browser JS warnings.
* Fixed: Some CSS issues with WordPress v5.3.2.

## 1.6.4
Release Date: November 27, 2019

* Fixed: Compatibility with Rank Math and Yoast SEO for their recent changes.
* Fixed: Fixed an error of `dateModified` showing an incorrect time when timezone was not set to UTC.

## 1.6.3
Release Date: November 24, 2019

* NEW: Added a new filter hook `wplmi_post_disable_update_default_check` to auto lock modified info in post edit page.
* Improved: Check/uncheck "Disable Update" option is separated from now.
* Fixed: Check/uncheck "Disable Update" option is not working on draft posts.
* Fixed: A minor CSS issue.
* Other minor improvemnts and fixes.

## 1.6.2
Release Date: November 14, 2019

* Compatibility with WordPress 5.3.
* Improved: Now it is possible to check/uncheck "Disable Update" option globally.
* Fixed: Some broken links.
* Fixed: Minor CSS issue.
* Removed: Some unnessary files.
* Other minor improvemnts and fixes.

## 1.6.1
Release Date: August 26, 2019

* Added: An option to set author link target.
* Fixed: Unclosed HTML tags.
* Fixed: Tooltip display issue.
* Removed: Some duplicate codes.

## 1.6.0
Release Date: August 9, 2019

* Added: A filter `wplmi_custom_schema_post_date_fotmat` to compatible any theme with Compatibility Schema Mode.
* Added: A filter `wplmi_switch_global_replace_hook` to switvh the Global Replace action hook.
* Added: Post Shortcode attribute to enable output on search pages.
* Improved: Last Modified Posts Dashboard Widget.
* Improved: Compatibility between the Newspaper theme and Advanced Schema Mode.
* Fixed: An issue which prevents plugin settings from saving.
* Fixed: JS error in Browser Console.
* Fixed: Unclosed HTML tag.

## 1.5.9
Release Date: June 8, 2019

* Fixed: GeneratePress missing function error.

## 1.5.8
Release Date: June 8, 2019

* Improved: Output Buffering Mechanism.
* Fixed: Some Typo.
* Removed: Some duplicate codes.

## 1.5.7
Release Date: June 7, 2019

* NEW: Schema Markup Compatibility with other SEO and Schema Plugins. Please resave schema option in plugin settings after upgrading your plugin.
* Fixed: `ob_start` warning.

## 1.5.6
Release Date: May 8, 2019

* Added: A link to hide the notice permanently.

## 1.5.5
Release Date: May 4, 2019

* Added: Option to sort posts by post modified date on edit.php page.
* Added: A filter `wplmi_post_edit_default_check` to auto check Disable Update Option in Post meta box when creating a new post.
* Added: A Option in Tools tab to auto check Disable Update Option.

## 1.5.4
Release Date: May 2, 2019

* Fixed: Missing Generatepress Option.

## 1.5.3
Release Date: April 25, 2019

* Added: Post Modified by field in Rest API Output.
* Fixed: Elementor Deprecated Hooks.
* Fixed: Conflict with Bootstrap CSS Class.
* Fixed: Check Box Slider CSS issue.
* Fixed: Plugin version number.
* Fixed: Unclosed HTML Tags in Admin Notices.

## 1.5.2
Release Date: March 29, 2019

* Added: A filter `wplmi_elementor_widget_query_filter` to sort Elementor Pro Posts and Portfolio widgets by last modified date.
* Added: A filter `wplmi_custom_author_list_selection` to set the custom author role for plugin settings.

## 1.5.1
Release Date: March 26, 2019

* Fixed: Some Error Notices

## 1.5.0
Release Date: March 26, 2019

* Added: Email Notification feature if someone made any change to any post which supports revision.
* Fixed: Wrong Settings Label.
* Fixed: Post Updated Message not showing last modified time.
* Fixed: Some Typo.
* Removed: Some unused CSS files.

## 1.4.9
Release Date: March 17, 2019

* Added: A new tab to Enable JSON-LD Schema Markup seperately.
* Improved: Schema Markup Mechanism.
* Fixed: Wrong Last Modified User was showing for WooCommerce Products.
* Fixed: Quick Edit option was hidden for some users.
* Fixed: Some Typo.
* Fixed: Code Clenup.

## 1.4.8
Release Date: February 11, 2019

* Added: Option to set gap between post published date and modified date.
* Added: WPML Compatibility.
* Fixed: Multisite Broken Login.

## 1.4.7
Release Date: January 30, 2019

* Tweak: Using wptexturize to fix the quoted post content in schema markup description. Props to Dirk L.
* Fixed: 'Trying to get property of non-object error' notice was showing for some users.
* Fixed: Placeholder shows wrong template tags variable i.e. `%%pub_date%%` instead of `%%published_date%%`. Now it has been fixed.

## 1.4.6
Release Date: January 27, 2019

* NEW: GeneratePress Theme Support.
* NEW: Astra Theme Support.
* NEW: Added shortcodes attributes.
* NEW: Added an option to replace post published date with post modified date without any theme file editing.
* NEW: Added filters to change post published date format if the option "Enter text or HTML to Replace" is in use.
* Improved: Genesis Theme Schema Support.
* Tweak: Now this plugin uses wordpress date/time format by default. 
* Fixed: Error Notice in 404 page.
* Fixed: Some Typo.

## 1.4.5
Release Date: January 17, 2019

* Tweak: Escape all shortcodes in JSON-LD schema markup Description.
* Fixed: Schema markup conditions on archive pages.
* Fixed: Language attributes filters.

## 1.4.4
Release Date: January 16, 2019

* Added: Option to set JSON-LD Schema Markup.
* Added: An option to show last modified info on all archives if your theme supports it.
* Fixed: A problem with unsupported schema themes.
* Fixed: Last Modified column displays nothing for some users.
* Fixed: Name change of menu item.

## 1.4.3
Release Date: January 11, 2019

* Fixed: A problem with Soliloque and Envira Gallery last modified column.
* Fixed: All incorrectly translated strings.

## 1.4.2
Release Date: December 20, 2018

* Tweak: Now all date format show as the date in localized format.
* Fixed: A bug where dateModified schema always returns in local time format instead of GMT.

## 1.4.1
Release Date: December 14, 2018

* Tweak: Now it is possible to edit last modified info from gutenburg edit screen.
* Fixed: Some minor bug fixed.

## 1.4.0
Release Date: December 11, 2018

* NEW: Elementor Dynamic Tags Support with schema markup.
* Added: Option to link author name with their Website.
* Fixed: A bug where link to author email always returns original post author's email instead of last modified author's email.
* Fixed: Some incorrectly translated strings.

## 1.3.10
Release Date: December 10, 2018

* Added: Option to replace paragraph tag with span tag.
* Added: Shortcode parameters to escape paragraph tag if required.
* Fixed: A bug where custom author seperator for template tags not working properly.
* Fixed: Some minor bugs.
* Fixed: Some incorrectly translated strings.
* New icon added.

## 1.3.9
Release Date: December 2, 2018

* Added: Option to enable/disable schema output.
* Added: Option to link author email.
* Improved: Template Tag mechanism.
* Improved: Admin UI.
* Fixed: Some minor bugs.
* Fixed: Some incorrectly translated strings.
* Tested upto WordPress Version 5.0.

Note: Please configure schema output from plugin settings after plugin update.

## 1.3.8
Release Date: October 14, 2018

* Fixed: Multiple output of last modified info on frontend if the post is not inside loop.
* Tweak: Now this plugin automatically detects modified info change if any change will be done from quick edit.
* Tweak: Sometimes modified fields are showing multiple times in quick edit mode. Now it has been fixed.

## 1.3.7
Release Date: October 4, 2018

* Added: A new filter `wplmi_disable_schema_output` to disable schema output.
* Tweak: Meta Box UI.
* Fixed: Plugin deactivation permission.

## 1.3.6
Release Date: September 24, 2018

* Added: Admin notice.
* Added: new filters `wplmi_display_priority_post` and `wplmi_display_priority_page` to set display priority.
* Code cleanup.

## 1.3.5
Release Date: September 1, 2018

* Admin UI Improved.
* Code cleanup.

## 1.3.4
Release Date: August 8, 2018

* Fixed: Some incorrectly translated strings.
* Code cleanup.

## 1.3.3
Release Date: August 5, 2018

* Added: Filters to set time difference between post published time and modified time.
* Fixed: a bug where page builder plugins overwrite the disable state of last modified info.
* Fixed: Disable modified info update checkbox shows in Bulk edit mode. Now it has been fixed.
* Improved: Last modified info output.

## 1.3.2
Release Date: July 27, 2018

* Added: Disable modified info update from Quick Edit.
* Added: A lock icon now indicates last modified info update disble status.
* Tweak: Now Dashboard Widget shows only published posts.
* Fixed: PHP 5.3 Compatibility issue.
* Fixed: Column sorting is not working properly.

## 1.3.1
Release Date: July 22, 2018

* Added: It is now possible to edit modified date and time.
* Improved: Made uninstall cleanup optional through a plugin setting and improved uninstall mechanism.
* Fixed: Admin bar returns revision link even if that post/page is not a revision.
* Fixed: Permission for custom post meta box.
* Fixed: Incorrectly translated strings.

## 1.3.0
Release Date: July 16, 2018

* Added: I18n support.
* Fix: Shortcode does not output modified info on pages. 

## 1.2.11
Release Date: July 15, 2018

* Added: Now it is possible to view last revision by clicking the admin bar item. 
* Fix: Redirection to edit.php page after login for some users. Thanks to @svayam.

## 1.2.10
Release Date: July 13, 2018

* Added: Option to set custom modified author name.
* Added: `lmt_custom_field_date_time_format` filter to set custom date/time format on custom fields. 
* Fix: Last Modified post display issue on dashboard widget with user roles except for administrator.
* Remove some plugin options to simplify plugin settings.
* Improved: Admin UI.

## 1.2.9
Release Date: June 23, 2018

* Added: You can now disable modified info update every time after the post is saved.
* Typo Fix.

## 1.2.8
Release Date: June 20, 2018

* Fix: Error notice after plugin update.
* Fix: Shortcode does not work properly if 'Using Shortcode' method is enabled.

## 1.2.7
Release Date: June 20, 2018

* Added: Now Last updated info now shows as post updated message.
* Improved: Dropdown loading using Select2.
* Improved: Custom Post Types Support. Now it is possible to select custom post types individually.
* Tweak: Now it is possible to disable auto insert for particular post/page from edit screen.
* Tweak: Remove 'Disable auto insert' fields to simplify plugin settings.
* Tweak: Active tab is now depends on url parameter also.
* Tweak: Last modified value will automatically be added into custom fields if 'Show Last Modified Info on Dashboard' option is on.
* Bug Fix.

## 1.2.6
Release Date: June 9, 2018

* Added: Option to enable/disable auto last modified info suport for custom post types.
* Added: Support to add last modified info in custom fields after post/page update.
* Tweak: Tools is now merged with plugins settings page.
* Fixed a typo in plugin description. Thanks to @buzztone.
* Bug Fix.

## 1.2.5
Release Date: May 27, 2018

* Added: Ajax loading at the time of form submission.
* Bug Fix.

## 1.2.4
Release Date: May 25, 2018

* Added: Tools page - Import/Export/Reset Plugin Settings.
* Improvement: Now it indicates which tab is active.
* Improvement: Admin UI.
* Bug Fix.

## 1.2.3
Release Date: March 17, 2018

* Added: Author name support.
* Added: Dashboard column width.
* Added: Last modified author name in Admin bar.
* Change last modified dashicons.

## 1.2.2
Release Date: March 15, 2018

* Added: Human Readable Time/Date format.
* Added: Last modified info on admin bar.
* Added: Option to set the number of posts to show on dashboard widget.
* Added: Option to customize default 'at' date/time separator.
* Tweak: 3 separate option merged into 1 option in dashboard options to simplify plugin settings.
* Tweak: If a class is not set in the template tags option, then this plugin does not return any class.
* Improved: Admin UI.
* Minor bug fixed.

## 1.2.1
Release Date: March 13, 2018

* Improved: Template Tag support.

## 2.0.0
Release Date: March 12, 2018

* Added: Template Tag support.
* Bug Fix

## 1.1.8
Release Date: March 10, 2018

* Added: Dashboard widget to show Last Modified posts.
* Improved: Schema Markup.

## 1.1.6
Release Date: March 7, 2018

* Improved: Custom Post Type Support.
* Bug Fixed.

## 1.1.5
Release Date: March 6, 2018

* Improved: Schama markup. [Test with structured data tool](https://search.google.com/structured-data/testing-tool).
* Removed 'revised' meta tag output as it is no longer required. [Learn more](https://stackoverflow.com/questions/33889445/is-html-meta-name-revised-valid-or-even-used).
* UI Improvements.
* Code Cleanup.

## 1.1.4
Release Date: March 4, 2018

* Added: Schama markup.
* Bug Fixed.

## 1.1.3
Release Date: March 4, 2018

* Added: Now you can create the exception for both posts and pages.
* Bug Fixed.
* Cover photo update. Thanks to @svayam.

## 1.1.2
Release Date: March 3, 2018

* Added: Now you can customize date/time format.
* Bug Fixed.

## 1.1.0
Release Date: March 3, 2018

* Added: All Custom Post support including WooCommerece.
* Now every last modified time in dashboard shows according to wordpress date/time format.
* Now shortcode will work only when shortcode option is enabled.
* Tweak: Custom Css Box returns empty style tag, if there is no value.
* Bug Fixed.

## 1.0.9
Release Date: April 29, 2018

* Added: Last updated info now shows on publish meta box.
* Remove some unwanted conditions.
* Fix woocommerce admin notice.
* Bug fixed.

## 1.0.8
Release Date: April 28, 2018

* Add WooCommerce Support.
* Multisite compatibility.
* Last login info added.
* Remove 304 response header as it is enable by default by many cache plugins.
* Bug fixed.

## 1.0.6
Release Date: April 28, 2018

Bug Fix: 
* Undefined Variable notice shows when debug mode is enabled.
* Weekday is not showing with revision meta tag output.

## 1.0.5
Release Date: April 27, 2018

* Added: 'post-last-modified-td' and 'page-last-modified-td' classes.
* Bug fixed.

## 1.0.4
Release Date: April 27, 2018

* If else condition change.
* Last modified headers hook change.
* Bug fixed.

## 1.0.3
Release Date: April 26, 2018

* Added last modified header output.
* Added user profile last modified info.
* Bug fixed.

## 1.0.2
Release Date: April 26, 2018

* Add revision meta output.
* Bug fixed.

## 1.0.0
Release Date: April 25, 2018

* Initial release.
