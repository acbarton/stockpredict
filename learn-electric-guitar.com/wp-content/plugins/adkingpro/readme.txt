=== Ad King Pro ===
Contributors: ashdurham
Donate link: http://durham.net.au/donate/
Tags: advertising, ads, ad, adverts, advert, advertisements, advertisement, advertise, stats, stat, statistics, statistic, promotions, promotion, banners, banner, tracking, track, detailed, adkingpro, ad king pro, page, post, reporting, reports, report, csv, pdf, revenue, charge, money, theme, themes, flash, adsense, text, resize, rotate, slideshow, multiple
Requires at least: 3.0.1
Tested up to: 4.4.2
Stable tag: 2.0.1
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ad King Pro allows you to easily manage and track your on-site advertising. Upload, link, go.

== Description ==

--

Stay up-to-date with the latest by following [@kingproplugins on Twitter](http://twitter.com/kingproplugins), [KingProPlugins on Facebook](http://facebook.com/kingproplugins) or [King Pro Plugins on Google+](https://plus.google.com/b/101488033905569308183/101488033905569308183/about)

--

[Ad King Pro](http://kingpro.me/plugins/ad-king-pro/) allows you to easily manage and track, via Google Analytics, your on-site advertising. Upload your banner/flash banner/adsense code/text, add the link its to go to then 
your ready to go. Set it to start and end at a certain time if needed. Ad King Pro can be placed into any page or post by using the shortcode. It can also be placed directly into 
theme files if need be. Create types and assign multiple banners to randomly show one on every page refresh, define a category to display in
a specific spot, even define a particular ad to display. Want to show multiple on a single page, no problem, change the 'render' attribute to
the amount you are after. Want those to then rotate on the spot? Got you covered. Turn the 'rotate' attribute to 'true' and your ads will fade between each other.

= Features =

- Easily manage banners globally
- Track impressions and clicks in your Google Analytics account
- Supports images, flash, adsense, HTML iframe and text as an "advert"
- Schedule start and end times
- Shortcode available
- Display options include single display, randomised display and rotate display

= Translations =

Thanks to the team at [Web Hosting Hub](http://www.webhostinghub.com) for providing the two translations for this plugin:
- Spanish
- Serbian

--

If you have any suggestions or would like to see a feature in the plugin, please let me know in the support forum.

Any issues you are having, I'd also love to know, so again, please let me know using the support forum.

--

[Check out the King Pro Plugins range](http://kingpro.me/)


== Installation ==

1. Download and unzip the zip file onto your computer
2. Upload the 'adkingpro' folder into the `/wp-content/plugins/` directory (alternatively, install the plugin from the plugin directory within the admin)
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Create your first advert within the 'Advert' section of the admin (Make sure you assign it to a type)
5. Within the WYSIWYG editor, place the short code '[adkingpro]' or within the code, &lt;?php if (function_exists('adkingpro_func')) echo do_shortcode('[adkingpro']); ?&gt;

--

Having Trouble? Get support either on the support forums here or at [@kingproplugins on Twitter](http://twitter.com/kingproplugins), [KingProPlugins on Facebook](http://facebook.com/kingproplugins) or [King Pro Plugins on Google+](https://plus.google.com/b/101488033905569308183/101488033905569308183/about)

--

== Frequently Asked Questions ==

= After activating this plugin, my site has broken! Why? =

Nine times out of ten it will be due to your own scripts being added above the standard area where all the plugins are included. If you move your javascript files below the function, "wp_head()" in the "header.php" file of your theme, it should fix your problem.

= I want to track clicks on a banner that scrolls to or opens a flyout div on my site. Is it possible? =

Yes. Enter a '#' in as the URL for the banner when setting it up. At output, the banner is given a number of classes to allow for styling, one being "banner{banner_id}", where you would replace the "{banner_id}" for the number in the required adverts class. Use this in a jquery click event and prevent the default action of the click to make it do the action you require

= I have created an Advert and added the shortcode onto my page but nothing shows up. Why? =

Be sure that you have assigned your advert to an "Advert Type". One called sidebar is automatically created for you when you install the plugin. It is this type that is pulled automatically in the default shortcode. Also in some cases you don't need to wrap the type in quotes (eg [adkingpro type=sidebar]).

--

Have a question thats not listed? Get support either on the support forums here or at [@kingproplugins on Twitter](http://twitter.com/kingproplugins), [KingProPlugins on Facebook](http://facebook.com/kingproplugins) or [King Pro Plugins on Google+](https://plus.google.com/b/101488033905569308183/101488033905569308183/about)

--

== How To Use ==

= Use Shortcodes =
Shortcodes can be used in any page or post on your site. By default:
`[adkingpro]`
is defaulting to the advert type 'Sidebar' and randomly chosing from that. You can define your own advert type and display the adverts attached to that type by:
`[adkingpro type="your-advert-type-slug"]`
Alternatively, you can display a single advert by entering its "Banner ID" which can be found in the table under the Adverts section:
`[adkingpro banner="{banner_id}"]`
Have a select few adverts that you'd like to show? No problem, just specify the ids separated by commas:
`[adkingpro banner="{banner_id1}, {banner_id2}"]`
Want to output a few adverts at once? Use the 'render' option in the shortcode:
`[adkingpro banner="{banner_id1}, {banner_id2}" render='2']`
`[adkingpro type="your-advert-type-slug" render='2']`
Only have a small space and what a few adverts to display? Turn on the auto rotating slideshow!:
`[adkingpro type="your-advert-type-slug" rotate='true']`
There are also some settings you can play with to get it just right:
- Effect: "fade | slideLeft | none" Default - fade
- Pause Speed: "Time in ms" Default - 5000 (5s)
- Change Speed: "Time in ms" Default - 600 (0.6s)

Use one or all of these settings:
`[adkingpro rotate='true' effect="fade" speed="5000" changespeed="600"]`
To add this into a template, just use the "do_shortcode" function:
`&lt;?php if (function_exists('adkingpro_func')) echo do_shortcode("[adkingpro]"); ?&gt;`

--

Having Trouble? Get support either on the support forums here or at [@kingproplugins on Twitter](http://twitter.com/kingproplugins), [KingProPlugins on Facebook](http://facebook.com/kingproplugins) or [King Pro Plugins on Google+](https://plus.google.com/b/101488033905569308183/101488033905569308183/about)

--

== Screenshots ==

1. Edit screen with all the options you'll ever need
2. Settings screen ensuring your system is set up for tracking

== Changelog ==

= 2.0.1 =
* Code refresh
* Removal of local tracking
* Cleaning up the admin
* Auto detection of GA install on site

= 1.9.17 =
* JS fix from preventing a JS error on GA click events

= 1.9.16 =
* Updates for 4.0
* Option to remove all stored data on delete
* Fix to widget banner ID dropdown

= 1.9.15 =
* Fix to widget output when using single banner calls and having the right advert type added as class

= 1.9.14 =
* Update settings on custom post types to prevent URLs being created
* Enable or disable tracking or impressions and clicks
* Added ability to add rollover images

= 1.9.13 =
* Fix to permissions which cause bbPress to stop working with Ad King Pro
* Fix to shortcode builder code changing the post ID on the edit screen
* Addition of GA integration functionality

= 1.9.12 =
* Addition of default settings for creating new adverts
* CSS update for latest version of WP
* Addition of shortcode builder in edit screen
* Addition of some extra columns to advert list

= 1.9.11 =
* Serbian Translation included thanks to Borisa @ WebHostingHub.com

= 1.9.10 =
* Fix to report PDF when generating for text advert

= 1.9.9 =
* Updated Spanish translation

= 1.9.8 =
* Spanish Translation included thanks to WebHostingHub.com
* Update to KPP section with release of new plugin
* Created local copy of Font Awesome as requested by Wordpress
* Addition of HTML5 Banner option

= 1.9.7 =
* Text updated to allow for internationalisation - if you would like to submit your translation, please email the compiled language files to plugins@kingpro.me

= 1.9.6 =
* Update to user role hiding of admin pages

= 1.9.5 =
* Major styling update to settings page
* Update to KPP Page styling and layout

= 1.9.4 =
* Update to KPP page with new plugin details
* Removal of forced role
* Added error check for missing capabilities

= 1.9.3 =
* Update to datepicker class to avoid conflict
* Update to admin enqueue function to only include on required pages
* Addition of authorised role option in settings

= 1.9.2 =
* Updated details including new release of King Pro Plugin
* Changed location of settings page in menu.

= 1.9.1 =
* Removal of expiry option on all post types except Ad King Pro
* Addition of the ability to add nofollow to links and control target

= 1.9.0 =
* Fixed up some CSS in the admin
* Added field to add an alt tag to the image advert output

= 1.8.2 =
* Small fix to install/update code
* Update to links to point to new website

= 1.8.1 =
* Fix to shortcode output when not specifiying a render value
* Cosmetic images in admin

= 1.8 =
* Fix to the reporting cost figures not rendering on the detailed summery page
* Addition of functionality to render multiple adverts at 1 time
* Addition of functionality to turn the multiple adverts output into a rotating banner
* Addition of tracking data removal on edit screen of advert

= 1.7.1 =
* Removal of left over echo in output

= 1.7 =
* Added option to set a size to an advert type, generating that image size from the images you upload.
* Added support for lack of 'post-thumbnail' support
* Added 'text' media type

= 1.6.1 =
* Issue with CSV and PDF generation fixed

= 1.6 =
* Addition of expiry date/time functionality

= 1.5.1 =
* Adding missing functionality for flash upload button

= 1.5 =
* Added support for flash and Google AdSense banners

= 1.4.2 =
* Update compatible with 3.5.2

= 1.4.1 =
* Fix to install error

= 1.4 =
* Widget option added

= 1.3 =
* Update to how admin scripts are included

= 1.2 =
* Addition of revenue allocation and calculation
* Addition of PDF themes
* Fix to week starts dropdown

= 1.1 =
* Addition of impressions
* Addition of impression settings
* Update to settings page
* Update to PDF output - display of banner refined

= 1.0 =
* Initial

== Upgrade Notice ==

= 1.9.17 =
* JS fix from preventing a JS error on GA click events

= 1.9.16 =
* Updates for 4.0
* Option to remove all stored data on delete

= 1.9.15 =
* Fix to widget output when using single banner calls and having the right advert type added as class

= 1.9.14 =
* Update settings on custom post types to prevent URLs being created
* Enable or disable tracking or impressions and clicks
* Added ability to add rollover images

= 1.9.13 =
* Fix to permissions which cause bbPress to stop working with Ad King Pro
* Fix to shortcode builder code changing the post ID on the edit screen
* Addition of GA integration functionality

= 1.9.12 =
* Addition of default settings for creating new adverts
* CSS update for latest version of WP
* Addition of shortcode builder in edit screen
* Addition of some extra columns to advert list

= 1.9.11 =
* Serbian Translation included thanks to Borisa @ WebHostingHub.com

= 1.9.10 =
* Fix to report PDF when generating for text advert

= 1.9.9 =
* Updated Spanish translation

= 1.9.8 =
* Spanish Translation included thanks to WebHostingHub.com
* Update to KPP section with release of new plugin
* Created local copy of Font Awesome as requested by Wordpress
* Addition of HTML5 Banner option

= 1.9.7 =
* Text updated to allow for internationalisation - if you would like to submit your translation, please email the compiled language files to plugins@kingpro.me

= 1.9.6 =
* Update to user role hiding of admin pages

= 1.9.5 =
* Major styling update to settings page
* Update to KPP Page styling and layout

= 1.9.4 =
* Update to KPP page with new plugin details
* Removal of force role
* Added error check for missing capabilities

= 1.9.3 =
* Update to datepicker class to avoid conflict
* Update to admin enqueue function to only include on required pages
* Addition of authorised role option in settings

= 1.9.2 =
* Updated details including new release of King Pro Plugin
* Changed location of settings page in menu.

= 1.9.1 =
* Removal of expiry option on all post types except Ad King Pro
* Addition of the ability to add nofollow to links and control target

= 1.9.0 =
* Fixed up some CSS in the admin
* Added field to add an alt tag to the image advert output

= 1.8.2 =
* Small fix to install/update code
* Update to links to point to new website

= 1.8.1 =
* Fix to shortcode output when not specifiying a render value
* Cosmetic images in admin

= 1.8 =
* Fix to the reporting cost figures not rendering on the detailed summery page
* Addition of functionality to render multiple adverts at 1 time
* Addition of functionality to turn the multiple adverts output into a rotating banner
* Addition of tracking data removal on edit screen of advert

= 1.7.1 =
* Removal of left over echo in output

= 1.7 =
* Added option to set a size to an advert type, generating that image size from the images you upload.
* Added support for lack of 'post-thumbnail' support
* Added 'text' media type

= 1.6.1 =
* Issue with CSV and PDF generation fixed

= 1.6 =
* Now set expiry dates/times on your adverts

= 1.5.1 =
* Adding missing functionality for flash upload button

= 1.5 =
* Added support for flash and Google AdSense banners

= 1.4.2 =
* Update compatible with 3.5.2

= 1.4.1 =
* Fix to install error

= 1.4 =
* Widget option added

= 1.3 =
* Update to how admin scripts are included to work better with other plugins

= 1.2 =
* Themes now available for PDF reporting
* Now track how much your advertising is making you by entering revenue pricing for impressions and clicks

= 1.1 =
* Added tracking impressions and settings
* Banner rendering in PDF improved

= 1.0 =
* Gotta start somewhere