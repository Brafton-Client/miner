# Plugins for Site Builds
Brafton Builds require the following 5 plugins to optimize our Site builds.  If you require any plugins beyond this you should look into coding the functionality yourself and including in the theme.  It may be quicker and just as effecient in some cases to use another plugin.  Use whatever works however scrutinize and evaluate your choices carefully before deciding on a plugin as a solution to your problem. 

- Brafton Wordpress Plugin 
    - Used to import Brafton Content
    - Should be Activate and configured on the Development, Staging, and Production enviorments
- WP Fastest Cache
    - Used to optimize the website performance
    - Do not configure or activate on development site. 
    - Activate and configure on the staging (soft launch) and production enviorments
- Wordfence 
    - Used to optimize the security of the website
    - Do not configure or activate on development site. 
    - Activate and configure on the staging (soft launch) and production enviorments
- (YOAST) Wordpress SEO
    - Used to optimize the SEO of the website
    - Should be Activate and configured on the Development, Staging, and Production enviorments
- WP Smushit
    - Used to optimize the website images in the media library
    - Should be Activate and configured on the Development, Staging, and Production enviorments

## ACF Content Analysis for Yoast Seo
This plugin is required when using Advanced Custom fields so that YOAST can evaluate the custom fields you have added to the site as part of the evaluation for each page.

## Advanced Custom Fields pro
This plugin provides the ability to easily create any of the custom fields for post types and/or taxonomies.  Whats more is it has the ability to export those newly created fields as code to allow better synchronicity accross multiple enviorments.

Your local setup may require you to copy this plugin into the plugins folder that exists in the actual wordpress installation. If you find yoru admin area not working properly, remove the symlink for your plugins folder and copy all the plugins from this repo into the plugins folder of the wordpress installation your using for development.

If you are creating custom fields to use this plugin for Brafton Site Builds follow the below steps.  

- Create your custom fields via the Wordpress dashboard.  
    - You can add more at any time durimg the development process.  
- Go to: Dashboard -> Custom Fields -> Export  
- Select all the fields you need to export  
    - You can export individual fields at a time, however I recommend creating a single export for everything  
- Select "Export to PHP"  
- Copy the php code into a phpfile called customfields.php  
- Add the following to your functions.php file  

```php
include_once plugins_url().'advanced-custom-fields/acf.php'; //Path to advanced custom field plugin
include_once 'customfields.php'; //path to the customfields file
```

## Any Mobile Theme Switcher
This plugin provides an easy way to develop a mobile specific theme used for table and mobile devices.
Usage:

- Go to Dashboard -> Settings -> Any Mobile Theme
- Select he theme you want to use for the device types listed.
    - You can select device specific themes (pretty cool!!!)

When building your mobile theme it is recommended you make it a child theme that way you can inherit from the parent and avoid creating any unnessisary duplication of code between the two.
As a perfect example see Tickets Broadway where this was applied (See John Parks or Deryk King)

## Brafton Wordpress Plugin [ Content Importer ] (Required)
Install and activate on ALL enviorments to ensure sync of content.
If you have not already initialize your submodules run `git submodule update --init --recursive` to initialize your plugins.
See Documentation included with plugin

- This plugin folder is a ["submodule"](https://github.com/blog/2104-working-with-submodules) which you can treat like a self contained git repo.  This has been added as a submodule so that if you need or want to make modifucations to the plugin you can use this inner repo to be able to add/commit/push changes to the [BraftonWordpressPlugin repository on git](https://github.com/BraftonSupport/BraftonWordpressPlugin)

## Gravity Forms
This plugin is used to add form fills to a clients site with integrations with multiple other platforms including payment platforms and automatic marketing platforms.

- API Key: e54770e72695ddffd80a92a2bcda291c

## Redirection 
This plugin handles the redirects that have been provided to you by the consultant. You can add redirects by uploading a csv file and catch any further 404 errors.

## Wordfence (Required)
Used to add a security layer to the site builds.  If this plugin wont activate properly try adding the following to the httpd.conf file in apache
```
<IfModule mpm_winnt_module>
ThreadStackSize 8388608
</IfModule>
```
Use the following settings code to import a predefined set of options designed to optmize this plugin. You will need to go to Dashboard -> Wordfence -> Options and scroll all the way down to the bottom and paste this string into "Import Wordfence settings from another site using a token"
```
4525ab481ed86948b302548b3688e0c522f70b133703252adbc629c9c21aecec4193809e630cee6826bc14ff46fb5ab9577778e122450b6ec4c023c76360ef36
```

- Be sure to enter the clients admin email address into the "where to email alerts" field at the top of the options page.
- Ensure you click the "Dismiss" button on the alert in the backend about configurign the plugin.

## Wordpress Importer
Use this to help import content from the clients existing site if applicable into the development enviorment.

## Wordpress SEO [ YOAST SEO ] (Required)

Access the menu for YOAST through Dashboard -> SEO -> Features  

-   Something 
- Enable Advanced Settings Pages
- Dashboard -> SEO -> Tools -> Import and Export
- Upload the "yoast-seo-settings-export.zip" file to load predefined settings.
- You will need to ensure under Dashboard -> SWO -> XML Sitemaps -> Post Types that all applicable post types are appearing in the sitemap.
    
## Wp Smushit (Required)
This plugin compresses images to save on diskspace and loading time.  
You can access the menu from Dashboard -> Media -> WP Smush  

- This should be enabled before you upload any images however if you already have some images uploaded click "Bulk Smush Now"
- Under "directory" ensure that any images you add to the theme folder is smushed
    - Click "Choose Directory" and navigate to the development theme
    - Click "Smush" to compress the image in the theme.
- Before "Soft Launch" ensure that all images (media and theme and pluguins ) has been run through the WP Smush plugin
    - Under "directory" ensure that any images you add to the theme/plugins folder is smushed
    - Click "Choose Directory" and navigate to the development theme and plugins folder
    - Click "Smush" to compress the image in the theme.

## Wp Pusher (Required only on Live Client site during 30 day support)
This plugin handles deployment of code across all enviorments (Development: on design.brafton.com, Staging: usually dev.clienturl.com, and Live: clienturl.com ). Ensuring that all code is the same and automating and easing the modifcation process from soft launch through the 30 day support window.

Once you have "Soft Launched" the site activate WP Pusher
Navigate to Dashboard -> WP Pusher  

- Insert the License Key and activate site License.  If you are unable to, than there are too many site using the key.  Log into the wp pusher dashboard and remove a site that no longer needs the key. Only sites on rolling maintance and sites in 30 day support should have active keys. Disable any old istes.
    - License Key: 0ea176d5-ae7d-474b-9bbb-d879608c05de 
- Click the Bitbucket Tab
- Click "Obtain a Bitbucket token" to show a popup with a bitbucket token
- Copy and paste the token into the Bitbucket Token field and click "Save Bitbucket token" 
    - Do not click "copy to clipboard" it does not seem to work.
- click Dashboard -> WP Pusher -> Install Theme and yuse the following settings
    - Repository Host: Bitbucket
    - Theme repository: braftonclientsites/{repoName}
    - Repository branch: 
        - For Staging: should be [ Dev or Develop or Staging ]
        - For Live: should be [ master or production or live ]
    - Repository subdirectory: themes/{themeName}
        - Just add the active theme as the parent theme doesn't require updating
    - Check off all 2 options
        - Repository is private
        - Push to deploy
        - Link installed theme
- After the 30 day support period please remove both the staging and live sites form the wp pusher dashboard and deactivate the plugin and uninstall.

## Yet Another Related Posts Plugin [ YARPP ] 
This plugin is used to display related posts/pages based on certain criteria on posts.  The best settings are listed below  

- Check off "Show only posts from the past" and select 12 months  
- Match threshold: 1  
- Titles: if available should be considered  
- Bodies: if available should be considered  
- Categories: Consider with extra weight  
- Tags: Brafton doesn't really use tags so this option is likely no needed.  
- Display results from all post types: check this off if you want cross resources matching  
- Choose the display options that best suit the clients request  

## Br SiteUrl Switcher (Required only to move between Dev,Staging,Production enviorment)

This plugin is used to make the switch from the staging enviorment to the live enviorment.  

- Once everything has been migrated to the live site this is the first item you should visit to ensure all links and urls are referencing to correct domain
- Current/Old Site Url: Ensure this is the staging url used previously without the trailing slash (/)
- New site url: the clients main domain without the trailing slash (/)
- Check the appropriate options for the conversion
    - Options: generally applies only to site and home url (as you may have changed this manually during your migration to live you may leave this unchecked)
    - PostContent: Arguably the most important, be sure to check this option
    - PostPermalinks: although wordpress displays the permalinks building it with the "home Url" the GUID's in the database are still generally set as the original url when it was created.
    - PostMeta: the second most important options be sure to check this off
## WP Fastest Cache (Required)
This plugin will enable caching for pages and css/js assets as well as provide the ability to combine and minify these files to limit the number http requests and data transfer.  To manually clear the cache you can either click the "puma" picture in the top admin bar and click "Delete Cache" or "Delete Cache and Minified CSS/JS". You can also access this via Dashboard -> WP Fastest Cache -> 
Use the following settings as standard under Dashboard -> WP Fastest Cache
### Settings
- Cache System: Enable
- Logged-in Users: Enable
- New Post: Enable
- Update Post: Enable
- Minify HTML: Enable
- Minify CSS: Enable
- Combine CSS: Enable
- Combine JS: Enable
- Gzip: Enable
### Cache Timeout
- Add New Rule
    - If REQUEST_URI: all
    - Then: Twice daily
### Exclude
Minify and Combine on CSS files should never causes anything to break on a site. There are however times that combining JS files may cause things to break accross a site.  Should this occur you will need to add rules to exclude files or whole folders from the combine options by adding "Add New Rule" in the "Exclude JS".