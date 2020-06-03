=== Divi - Filterable Blog Module ===
Author: Bruno Bouyajdad
Contributors: indikatordesign
Tags: divi, divi builder, divi page builder, divi theme, extra theme, elegant themes, extra blog module
Requires PHP: 5.6
Requires at least: 4.0
Tested up to: 4.9.8
Stable tag: 1.0.10
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Use Filterable Blogs as Module on your Divi Websites..

== Description ==
A Filterable Blog Module for the Divi Builder, based on ajax techniques.

This plugin is created independently and is not supported by Elegant Themes.

== Installation ==
In order to install the plugin, you can easily upload it as a Zip-Archive in the WordPress Admin area, or simply upload the unpacked folder directory to your plugin folder via FTP.

Then you can activate it in the plugin directory.

== Changelog ==

= Principle update notes =

> If you have problems after an update, please always try to delete the localStorage first. This ensures that all Page Builder templates are up-to-date after an update. Open the developer tools of your browser, go to "Console" and type in the following command:

    localStorage.clear();

> The answer is "undefined". Then delete your browser cache and try again, maybe in a window in incognito mode.

> More infos in the [FAQ](https://support.indikator-design.com/faq-divi-filterable-blog-module/).

= 1.0.10 =

* Changed updater to the EMP EDD updater class
* Fixed an issue with the separator for the comments
* Fixed an issue if dropshadow is set
* Fixed an margin-issue on search results
* Removed textdecoration uppercase from the header

*Changed Files:*

* all files

= 1.0.9 =

* For the display "no more posts for this category" a layout can now be embedded from the Divi Library. Read more about this in the section "Can I customize the message "no more posts for this category"?" in the FAQ: https://support.indikator-design.com/faq-divi-filterable-blog-module/
* Fixed typo "Filerable posts" in blog module

*Changed Files:*

* /divi-filterable-blog-module/assets/lang/divi-filterable-blog-module.pot
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.min.css
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.8 =

* URLs are now pulled out of the content again

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.7 =

* Added the ability to add category and tag slugs that do not contain "cat" or "tag". Read more about this in the FAQ under "Can I use it with my own registered custom post types?". Here is the link to the FAQ: https://support.indikator-design.com/faq-divi-filterable-blog-module/
* If images are present in the content / excerpt, they are now automatically detected and filtered out to avoid display problems
* Fixes an error when using the offset with a PHP version prior to 7.0

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.6 =

* Fixes an issue with the latest Divi version. An attempt was made to add an empty object to the Masonry layout.

*Changed Files:*

* /divi-filterable-blog-module/assets/js/dfbm-blogthread.js
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.min.js
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.5 =

* Adaptation to the new video overlays
* The Plugin Update Checker Library has been updated to version 4.4
* Removes the error that "Disable Translations" was no longer visible under the "Divi Theme Options"

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.js
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.min.js
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.min.css
* /divi-filterable-blog-module/includes/controller/settings.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.4 =

* You can now overwrite the text "Read More" for the buttons and the lightbox directly in the module settings
* You can now overwrite the text "Add More Posts" for the "add-more" button directly in the module settings
* Improved description for using the different font sets in the normal module ( not in the light module )
* The ".pot"-file has been updated

*Changed Files:*

* /divi-filterable-blog-module/assets/lang/divi-filterable-blog-module.pot
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/includes/controller/admin.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.3 =

* If featured posts are set, but no navigation, a margin-bottom with the value of article distance is now automatically set
* Images are now always stretched to 100% in fullwidth mode
* Fixes an issue when using tags

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/includes/controller/ajax.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.min.css
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.2 =

* It is now fully compatible with the backend preview mode
* Fixed an issue with pixelated images in the featured posts section
* Some minor bug fixes

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/includes/controller/enqueue.php
* /divi-filterable-blog-module/assets/css/dfbm-admin.css
* /divi-filterable-blog-module/assets/css/dfbm-admin.min.css
* /divi-filterable-blog-module/assets/js/dfbm-lightbox.js
* /divi-filterable-blog-module/assets/js/dfbm-lightbox.min.js
* /divi-filterable-blog-module/includes/controller/admin.php
* /divi-filterable-blog-module/includes/trait/constants.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8.1 =

* Fixed a bug that caused a fatal error in some development environments by a wrong class call

*Changed Files:*

* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.8 =

* Fixed a bug that caused a fatal error in some development environments by a wrong class call

*Changed Files:*

* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.7 =

* Added the new filter methods to images etc.

*Changed Files:*

* /divi-filterable-blog-module/includes/trait/constants.php
* /divi-filterable-blog-module/includes/controller/modules.php
* /divi-filterable-blog-module/includes/controller/autoloader.php
* /divi-filterable-blog-module/includes/controller/initialize.php
* /divi-filterable-blog-module/includes/controller/instance.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/modules/lightblog.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.6 =

> IMPORTANT NOTE: Please read before updating!

> Occasionally there were display problems with the settings in the Pagebuilder. This seems to be due to a performance problem. Divi offers with the latest updates a lot of possibilities to customize fonts and buttons. That's great, but it leads to extremely large Page Builder templates when many fonts are used. "Divi - Filterable Blog Module" offers a lot of settings and this should stay that way. However, it is important that everyone can use these great features. That's why this update introduced a second module: "Divi - Filterable Blog Module Light".

> It offers exactly the same possibilities, but the fonts and buttons can only be adjusted with CSS rules in the CSS boxes under the tab "Advanced", or in an external stylesheet. This made it possible to significantly reduce the size of the resulting template and to use it in development environments with lower performance also.

> It is always advisable to try the normal module first. If there are no display problems, it is not necessary to use the "light module".

> Please note that these performance problems only occurred in the backend, where all modules are bound to the templates to configure them in the Page Builder.

* Introduction of the module "Divi - Filterable Blog Module Light", specially designed for development environments with lower performance
* Added 4 new standard layouts: "DFBM-Author-Light", "DFBM-Search-Light", "DFBM-Archive-Light", "DFBM-Shop-Light"
* Added the filter hooks "dfbm_post_meta_before", "dfbm_post_title_before", "dfbm_posts_content_before", "dfbm_posts_content_after", "dfbm_posts_bottom_after". All of them are assigned with the current $post ($post-object) as first parameter, and $featured (bool true/false) as second parameter
* Added a new fade-in animation for the blog post items. It's available in the module settings in the "Layout"-section from the "Content"-tab
* Add the detection of a config file in the child theme used under the path: "/child-theme/includes/dfbm-config.php". An example file is located in the folder "/helper/" and can be easily moved  and adjusted. But you need to change the suffix to ".php". Please follow the instructions on top.
* Added all archive layouts in JSON format to the folder "/helper/layouts/" to have the default settings easily available
* Change from "dfbmTraitGlobals" to "dfbmTraitConstants". This is also only integrated once. As a replacement, the Singleton Pattern function DFBM() is accessed to get constant values
* The updaterscript has been updated
* Fixed a margin-bottom CSS bug for featured posts that was caused by CSS rule changes in the last Divi update
* Fixed a problem where the page variable was calculated wrong when the offset was enabled with the "add more" option
* Fixed a problem where a redirection to the product has occurred in the shop index although the lightbox was switched on

*Changed Files:*

* All files

= 1.0.5 =
* Added compression for newly created templates.
* Added the filter hook "dfbm_query_args_output" to the query args output.
* Added the ability to close navigation elements on mobile devices when clicking on a category entry.
* Fixed a problem with a function call that could lead to errors when there were videos in the feed.
* Fixed an issue with the CSS output for positioning images.
* Fixed an issue with the CSS output of the add to cart button by using the content as overlay.
* Fixed an issue with translation for the "Read more" link in Lightbox.

*Changed Files:*

* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/js/dfbm-lightbox.js
* /divi-filterable-blog-module/assets/js/dfbm-lightbox.min.js
* /divi-filterable-blog-module/assets/js/dfbm-admin.js
* /divi-filterable-blog-module/assets/js/dfbm-admin.min.js
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.js
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.min.js
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/trait/global.php
* /divi-filterable-blog-module/includes/controller/ajax.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.4 =
* Improvements for category and tag checkboxes in the backend, since a large number of categories and tags caused loading errors.
* Fix in the updater to comply with the following specification: Force evaluation order for PHP 7 conpat
* A CSS error for the fullwidth layout with the content below has been fixed.
* Removed deprecated __autoload from the autoloader class.
* An error in the calculation of the offset was fixed.

*Changed Files:*

* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.min.css
* /divi-filterable-blog-module/includes/controller/autoloader.php
* /divi-filterable-blog-module/includes/controller/ajax.php
* /divi-filterable-blog-module/includes/controller/walker.php
* /divi-filterable-blog-module/includes/controller/modules/blog.php
* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.3 =
* Implementation of the extraction of plain URLs from the content. This can be prevented by setting the hook 'dfbm_strip_out_plain_url' to false.

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.2 =
* Fixed a bug that caused an error when no video is inserted in a video post
* Added the filter hook 'dfbm_hide_scrollbar' to prevent the scroll bar from being removed

*Changed Files:*

* /divi-filterable-blog-module/assets/css/dfbm-blogthread.css
* /divi-filterable-blog-module/assets/css/dfbm-blogthread.min.css
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.js
* /divi-filterable-blog-module/assets/js/dfbm-blogthread.min.js
* /divi-filterable-blog-module/includes/controller/enqueue.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.1 =
* Fixed a bug where links were truncated by enabled Wordcount limiter
* Added the filter hook 'dfbm_column_collapse_max_width' to control the column breakpoint, if et-content-width is set to a high value

*Changed Files:*

* /divi-filterable-blog-module/includes/controller/blogposts.php
* /divi-filterable-blog-module/divi-filterable-blog-module.php
* /divi-filterable-blog-module/readme.txt

= 1.0.0 =
* Initial release