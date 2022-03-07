=== Content Views PRO ===
Author: Content Views
Website: http://www.contentviewspro.com/
Requires at least: 3.3
Tested up to: 5.3.2
Stable tag: 5.7.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Content Views Pro - Premium plugin which extends awesome features (more powerful settings, more amazing layouts) from the Content Views free plugin

== Description ==

You are using "Content Views PRO" plugin.

This plugin requires :
- WordPress 3.3 or higher
- Free version of Content Views plugin which is available at http://wordpress.org/plugins/content-views-query-and-display-post-page/

You can find documentation here http://docs.contentviewspro.com/

Copyright 2014 by http://www.contentviewspro.com/



== Installation ==

= Uploading in WordPress Dashboard =

1. Navigate to the 'Add New' in the plugins dashboard
2. Navigate to the 'Upload' area
3. Select `pt-content-views-pro.zip` from your computer
4. Click 'Install Now'
5. Activate the plugin in the Plugin dashboard



== Frequently Asked Questions ==

Please check here http://www.contentviewspro.com/faq/



== Screenshots ==



== Changelog ==

= 5.7.1 =
- Update: Add option to enable/disable the standard pagination structure for the View while replacing layout of archive pages.
Disable it when the View shows unexpectedly at top of archive pages, above all other things.
- Update: Extend the parent page settings to any hierarchical post types
- Fix: Prevent layout issue while showing custom field value with unbalanced HTML tags
- Fix: Some styling issues

= 5.7.0 =
- New: Add "Style Settings" options to Live Filter
- New: Add option to Live Filter of Custom Field, to get and show name/title from the ID in custom field's value
- Update: Improve SEO for Ajax pagination (update URL on changing page, each component pages are accessible individually, so on)
- Update: Improve SEO for Replace Layout on archive pages, to use the native pagination format on page
- Improvement: Display options more clearly in the setting page of Replace Layout feature
- Improvement: Improve back/forward history navigation of the Live Filter feature
- Improvement: Optimize the size of view data saved in the database
- Compatible: Update the code to support the "Ultimate Member" plugin
- Some minor updates and fixes

= 5.6.1 =
- New: add option to set thousand separator for Numeric Range Slider type of Live Filter
- Update: clarify some descriptions and settings in Add/Edit View page
- Update: improve output of Numeric Range Slider type in some cases, remove the numbers below the range slider
- Update: add some filters to modify output using code
- Fix: some layout issues cause by specific themes or plugins

= 5.6.0.2 =
- Fix: Reverted change to wrapper element when replacing layout which might cause theme layout issue

= 5.6.0 =
- New: Add Catalog visibility, Attributes as new options to filter WooCommerce products
- New: Add option to Settings page to enable using custom CSS for all Read More buttons, or to keep Green background as the free version
- Fix: "Overlay clickable" not trigger on some fields
- Fix: Prevent duplicate lightboxes in ajax requests
- Fix: Pagination of Live Filter issue with Internet Explorer 11
- Improve compatibility with Avada theme and Visual Composer, Relevanssi plugins
- Improvement: Support Live Filter feature when reusing a View with extra parameters, by reloading page on changing filter
- Improvement: Refine some notices, CSS styles

= 5.5.0.1 =
- Fix: navigation of lightbox image not work since previous version
- Test up to WordPress 5.2

= 5.5.0 =
- Improvement: show hierarchy output for live filters of taxonomy
- Improvement: refine the overlay clickable feature
- Improvement: make hard resize to work with default image
- New: support MemberPress plugin to show posts in grid/list to only allowed users/members
- New: add "Set thumbnail" feature for taxonomy's term when "Show terms as output"
- New: add option to select custom field as substitute of thumbnail (without extra code)
- New: add align options (Center, Left, Right) for thumbnail
- New: add option to use results of another plugin in search results page when enabling "Replace Layout" feature
- New: add option to hide the posts which don't have taxonomy when enabling live filter of that taxonomy
- New: add options "In the past", "Today in history" to filter by published date
- New: add option to show only sticky posts
- New: add sort by option "Relevance to the searched keyword"
- Update: support decimal value as step for "Range Slider" type of live filter
- Some other small fixes and tweaks

= 5.4.1 =
- Fix: Click anchor link with hash mark (#) causes the page with live filter to reload
- Update: Support setting values for multiple custom fields while reusing View shortcode (using the "custom_field_value" parameter)
- Improvement: Prevent direct access to plugin files
- Improvement: Track page views (by Google Analytics) when opening lightbox which shows only specific content area of a page
- Improvement: Add option to sort Glossary heading by locale (site language)
- Improvement: Prevent potential layout issues when double-click option of Shuffle filter, while the animation is not finished
- Some other fixes, adjusts and improvements

= 5.4.0 =
- New: Add options to remove box shadow, and border between fields of the Masonry layout
- New: Allow filtering by custom field has value in Unix Timestamp format
- New: Support Custom-Post-Type-powered taxonomy created by CPT-onomies plugin
- New: Allow HTML in custom name when showing custom field
- Fix: Live filter by multiple custom fields with the OR logical relationship not showing all options of each field
- Fix: Remain current language argument of translation plugin in URL on selecting live filter options
- Fix: Pinterest layout issue in edge cases
- Fix: Hard resize not working with Media content type
- Fix: Soft resize reverts to default size on Ajax pagination
- Fix: The number 0 in post title is ignored and not shown as index in Glossary layout
- Fix: Can't open full screen video in lightbox content
- Improvement: Improve performance when filtering by multiple custom fields with the OR logical relationship
- Some other fixes and improvements

= 5.3.4.3 =
* Fix notice and warning in PHP 7.1, 7.2 in some edge cases
* Improve the compatible fix with "The Events Calendar" plugin in previous version

= 5.3.4.2 =
* Fix:
- Display issue of live filter dropdown type occurred since version 5.3.4.1
- Compatible fix: filter past events of "The Events Calendar" plugin not work because that plugin prevented past events from showing

* Update:
- Able to set limit (total number of posts to show) when replacing layout
- Add/adjust some description texts

= 5.3.4.1 =
* Fix: Malware found in Mobile_Detect.php

= 5.3.4 =
* Update:
- Support "The Events Calendar" plugin: able to show venue name and organizer name by showing 2 custom fields  _VenueVenue, _OrganizerOrganizer
- Support filter by date custom field has value not in Year-month-date format. No need to create alias field as in previous versions.
- Support live filter by custom field which contains space in name/key
- Improve output of live filter elements (dropdown, radio, checkbox)
- Able to set multiple parent pages to show children pages, by using the reusable parameter "post_parent" (separate parent IDs by commas)

* Fix:
- Slow query caused by live filter custom field which has serialized value
- Live sort by custom field (has decimal value) returns incorrect results in some cases
- Fix some small layout style issues

= 5.3.3.2 =
* Fix:
- Revert commit in 5.3.3 (enable soft resize automatically when use grid line up/ same height), to prevent affecting existing Views. Show a notice below that setting instead.

= 5.3.3.1 =
* Fix:
- Remove space below images when enabled the "Line up fields across items" feature in the Grid layout
- Replace layout with live filters might return no results when used the default pagination of page

= 5.3.3 =
* New:
- Add option to exclude children pages, to show only top level pages

* Update/Improve:
- Improve output of the border feature in the Grid layout. Switch from the border between posts to border around posts.
- Make the lightbox feature to be responsive on resizing the window
- Easy to change the text of Submit, Reset buttons of Live Filter using Javascript variables
- Add & update some texts in View editing page, Replace Layout page for better instruction
- Some styles improvements

= 5.3.2 =
* Update/Improve:
- Can show video, audio, pdf directly in Lightbox
- Can include/exclude Social buttons from the overlay
- Avoid sending live filter Ajax request in some cases
- Can execute shortcode in description of category, when showing category as output
- Improve description of some settings/messages to better explain what they do
- Improve style of some elements

* Fix:
- Compatible fix for "Ultimate Member" plugin (version > 2.0)
- Sort by custom field when replacing layout with Ajax pagination not working
- Fix thumbnail issue of Collapsible, Scrollable list when showing images in same size, or using soft resizing feature
- Fix Timeline layout on mobile devices when using the long-mode feature
- Fix PHP warning/notice in some edge-cases

= 5.3.1.1 =
- Update: Restrict the soft resizing responsive (in version 5.3.1) to some specific cases only
- Update: Handle the case when sorting by custom field whose value uses commas as thousand separator

= 5.3.1 =
* Update:
- Support some plugins which don't use WordPress featured image but a custom field to store thumbnail
- Able to show embedded video from videopress.com as thumbnail
- Make the soft resizing responsive
- [Live Filter] Restrict results to selected taxonomies (which no terms are selected in View panel) by default
- [Live Filter] Change the sorting parameter from "orderby" to "_orderby" to prevent conflicts with default WordPress sorting feature

* Fix:
- When replacing layout, sorting by a custom field in View was NOT applied to the results
- "Full Size" thumbnail of the Media content type doesn't show the original image
- Compatible with the "NextGEN Gallery" plugin version 3.0: Color picker in Style Settings disappears when activate the "NextGEN Gallery" plugin

= 5.3.0 =
* New:
- [Live Filter] Able to reposition filters (drag & drop to change filters positions)
- [Live Filter] Able to sort options of a filter by posts count, display text, raw value
- [Replace Layout] Able to show all children terms of current term in taxonomy archive page
- [Show terms as output] When no terms selected manually, show all terms automatically

* Update:
- [Live Filter] Able to change the default text of the Button type
- [Live Filter] Able to remove the default label text
- [Scrollable list] Update some elements styles when set custom item margin values

= 5.2.1 =
* New:
- Add setting to show text below thumbnail in the Scrollable list
- Add setting to repeat advertisements automatically
- Add setting to change the "ALL" text in the Glossary layout

* Update:
- Prevent the Limit value of View from affecting the number of posts to show when replacing layout but not enabling pagination in View
- Support post_parent="GET_CURRENT" (use the current page as parent page) when reusing a View
- Remove animation when showing only title with the "Show terms as output" feature
- Tweak text of some settings

= 5.1.2.2 =
* Fix:
- Ajax pagination does not return results when replacing layout after the 5.1.2 update

* New:
- Able to show full image of post thumbnail in lightbox

= 5.1.2 =
* New:
- Support the "Restrict Content Pro" plugin: restrict posts to only allowed users/members

* Update:
- [Replace Layout] Keep results of the Relevanssi plugin when replacing layout of the Search results page
- [Live Filter] Move keyword search field (if enabled) to top of the filters list for better UX
- Shows bottom border for whole grid, when enabling border around posts in grid layout
- Support keyboard navigation for the Scrollable list
- Show post title or image alt text when showing lightbox of post thumbnail
- Add some CSS to prevent layout issues
- Prevent blank images in View caused by the lazy load feature of the theme, or another plugin

= 5.1.1 =
* Update:
- [Live Filter] Improve performance when filtering thousands of posts
- [Live Filter] Show submit, reset buttons when using the Range Slider type
- CSS updates for video thumbnail, Scrollable List, Live Filter reset button

* Fix:
- [Live Filter] Page reloading issue in Safari browsers

= 5.1 =
* Update:
- [Live Filter] Hide the submit, reset buttons by default
- [Live Filter] Reset page number when searching by keyword
- [Live Filter] Improve performance on filtering by custom field
- [Shuffle Filter] Remove the features "Show posts count of each term", "Hide empty terms" which are unusable in some cases. To use these features, please switch to Live Filter http://docs.contentviewspro.com/switch-shuffle-filter-live-filter/

* Fix:
- [Live Filter] Sort by comment count does not work
- Fix issues of the One & Others layout in some edge cases

= 5.0.1.1 =
* Fix: Terms as output show links to current page in some edge cases

= 5.0.1 =
* Update: Support Live Filter feature when replacing layout of the Search results page
* Update: Support "Open item in", "Make the overlay clickable" features when showing taxonomy (category, tag, custom) as output
* Update: Disable Replace Layout in feed page
* Update: Change the default option of some View settings
* Update: Remove the white overlay when doing Live Filter
* Fix: Timeline layout issue in pagination of Live Filter

= 5.0 =
* New: [Live Filter] Add setting to set text for the first (default) option in Radio, Dropdown type
* New: [Live Filter] Add setting to set label, placeholder text for the text search field
* New: [Live Filter] Add setting to set label, default text for the "Sort by"
* New: Add setting to set custom CSS classes for the View
* New: Add style settings (color, font, etc.) for Glossary index
* Fix: Prevent unexpected issues caused by impacts of some themes and plugins
* Improve: Handle some edge cases when replacing theme layout by CVPro layout
* Improve: Make the grid same height feature works in hidden tab, accordion
* Improve: Improve styles of Glossary list, Collapsible list, Shuffle Filter dropdown
* Update: Enable existing advertisements in View when reusing that View
* Update: Show taxonomies in manual selected order of "Let me choose" setting
* Update: Replace the title attribute by the alt attribute when showing an image custom field
* Update: Adjust descriptions and positions of some View settings
* Update: Make Glossary list works with Live Filter

= 4.9.1 =
* Fix: Color picker does not show in WordPress 4.9
* Fix: PHP warning in file live-filter/custom-field.php
* Update: Rename "Pagination" to "Pagination Number" in the Style Settings tab, disable its redundant "Text Align" setting
* Update: Small CSS update for the One & Others layout

= 4.9.0 =
- New: Add setting for the Masonry layout to set which posts (by IDs, indexes) to show widely
- New: Add setting for the Timeline layout to enable/disable the fixed structure
- New: Add the DECIMAL type for filtering by custom fields
- New: Able to show Location details of the Events Manager plugin by showing custom fields
- Fix: Incorrect filters and results of Live Filter in some cases
- Fix: Some minor issues
- Update: Improve the support for the WPML, Polylang plugins
- Update: Support the Overlay feature when showing categories/tags as output
- Update: Support the custom size of thumbnail when showing categories/tags as output
- Update: Remove the code which supports showing custom fields as Shuffle Filter, because of the new Live Filter supports it
- Update: Add some notices to the Add/Edit View page

= 4.8.1 =
* New:
- Able to use any English textual datetime (tomorrow, next Monday, next week, next month, +3 days, +1 week and so on) to get posts by a Date custom field
- Add 2 new sort options:  Sort by Post type, Sort by Author

* Fix:
- Show incorrect available Live filters of taxonomies, when these taxonomies have the same term slug
- Convert Date custom field to another format returns incorrect result in some cases
- Incorrect overlay height of other posts in One & Others layout, when enables the soft resize option of thumbnail


* Update:
- Apply the Thumbnail style to the Overlay
- Make the "Show in special place" feature of taxonomy works on other posts in the One & Others layout
- Strip slashes from quote characters in the label of Live Filter
- Add/update some admin notices

= 4.8.0.1 =
- Update: Make the "Show in special place" feature works with other posts in the One & Others layout
- Fix: Sort by custom field in a View affects result of following Views in the same page (since version 4.8.0)
- Fix: Warning "Invalid argument supplied for foreach() in includes/components/live-filter/taxonomy.php on line 128"

= 4.8.0 =
* New:
- Faceted Search: the Live Filter feature
- Alternate thumbnail position
- [Replace Layout] Able to use any settings in the "Filter Settings" tab of the selected View, to overwrite the posts result completely

* Fix:
- Open two tabs when enables the "Make the overlay clickable" option
- Fix some issues of custom field displaying feature

* Tweak:
- Update some descriptions, notices in Add/Edit View page

= 4.7.4 =
* New:
- Add "Now and the past" option for querying by date custom field
- Add setting to do shortcodes and apply filters in post content before generating excerpt

* Update:
- [Shuffle Filter] Optimize query on pagination
- Update CSS when showing images in same size

= 4.7.3 =
* New:
- Add font size settings for table, mobile devices to Style Settings tab, for all elements
- Add "Today" option for filtering by Custom field date

* Fix:
- "Exclude current post" setting causes duplication of post in ajax pagination

* Update:
- Make "Open post on click the overlay" works with any "Open In" options
- Update CSS of shuffle filter dropdown

= 4.7.2 =
* Compatible:
- Support Woocommerce sort by options (popularity, rating, newness, price) when using Replace Layout feature in product category page

* Feature:
- Enable Thumbnail Style when uses "Soft resize", or "Show all images in same size"
- Enable Exclude settings when shows X posts of each selected terms
- Enable Grid line up fields script in mobile devices

* Tweak:
- Update CSS custom field
- Update padding of grid items when uses Shuffle Filter
- Update thumbnail shadow style
- Remove width, height attributes in HTML output of ACF image
- Add JS variable to disable animation of Shuffle Filter
- Add filter to enable Parent Page settings for custom post types

= 4.7.1 =
* Compatible:
- Fix: No featured products found of WooCommerce 3.0.0 or later
- Fix: No posts found in non-default languages of WPML with WordPress 4.8.0
- Fix: Error "Call to undefined function wc_get_product()" after deactivate WooCommerce plugin, in the View which enables "Show Sale Badge"

* Tweak:
- [Replace Layout] Remove some classes of old layout while replacing layout of archives pages
- Add filter "pt_cv_ads_slots" to modify ads slots (default value is 10)

= 4.7.0 =
* New:
- Introduce the soft resizing feature for images
- [Replace Layout] Add options to fix some conflicts with theme

* Compatible:
- Fix issue of Pinterest, Masonry layout when enabled lazyload feature of WP Rocket plugin

* Update & Improve:
- [Replace Layout] Completely disable existing pagination of WordPress archives page when use custom pagination in selected View
- [Replace Layout] Show advertisements if they existed in the View, and remove the relative setting option in Content Views >> Settings page
- [Sticky post] Leverage code in WordPress core to handles the "Place all sticky posts at the top of list" option, and remove relative CVP code
- More smooth animation when appending posts for Pinterest, Masonry, Shuffle Filter with load-more, infinite scrolling pagination

= 4.6.1 =
* Fix:
- Float issue of other posts in One & Others layout

* Update:
- Able to replace layout of only specific terms and keep old layout of other terms
- Add some filters to customize View output, to modify thumbnail substitute

= 4.6.0 =
* New:
- [Replace Layout] Able to set different Views for different categories, tags...
- [Replace Layout] Able to show comment block when replacing layout of single post, page, custom post type
- [Replace Layout] Completely support all Shuffle Filter settings when replacing layout
- [Style Settings] Add "Text Align" setting for all elements
- [Display] Able to allow all HTML tags in post excerpt's output
- [Display] Able to execute shortcode in custom field's value
- [Display] Able to leave width or height empty (to maintain image proportion) when set custom size for thumbnail
- [Display] Support relative URL when customize link of a post title, thumbnail, read-more button in View
- [Display] Able to drag & drop to change display order of taxonomies under "Meta fields >> Taxonomy >> Let me choose"

* Improve:
- [Style Settings] Remove "Color & Font" label, use clearer description/text for some settings
- [Display] Use post title as alt for featured image if its alt is empty
- [Lightbox] Show whole page content if the "Content Selector" matches no element
- [Lightbox] Disable page scrolling when lightbox is open

* Compatible:
- Replace Layout of Taxonomy Archives returns no posts found when the "Search Everything" plugin activated
- Fix warning when WordPress filter "wp_get_attachment_image_attributes" is applied in theme or another plugin, but missing argument 2 or 3
- Unable to get updates with iThemes Sync

= 4.5.0 =
* New:
- "Replacing Layout" now works for single post, page, post type
- Able to use custom fields to shuffling posts in front-end, for example `[pt_view id="VIEW_ID" shuffle_custom_field="FIELD_1, FIELD_2, FIELD_3"]`
- Add setting to exclude password protected posts
- Add style setting for inactive pagination items

* Compatible:
- Pinterest/Masonry layout is not shown when using View to show results of FacetWP plugin
- Support WooCommerce category thumbnail when using "Show terms as output" feature

* Update:
- Able to set operator for second taxonomy when reusing View

= 4.4.0 =
* New:
- Show related posts of current post easily, for example `[pt_view id="VIEW_ID" cat="GET_CURRENT"]`, `[pt_view id="VIEW_ID" taxonomy="GET_CURRENT" terms="GET_CURRENT"]` (with VIEW_ID is ID of the View which configures the desired layout, GET_CURRENT is the constant)
- Show custom field, meta field... of current post easily, with shortcode `[pt_view id="VIEW_ID" post_id="GET_CURRENT"]` (with VIEW_ID is ID of the View which configures which information of post to show, GET_CURRENT is the constant)
- Can use "Custom Size" without setting Height value, to resize the image but keep its natural ratio
- [Masonry layout] Add filter to customize which posts to be shown bigger
- Add setting to exclude any fields from the overlay of thumbnail easily

* Fix:
- [Conflict with Photon feature of Jetpack plugin] Thumbnail is not visible in mobile devices, when enable lazy loading

* Update:
- Refactor functions of "Show terms as output" feature

= 4.3.0 =
* New:
- Can use "Sort by" setting of selected View when Replace Layout of Blog, Category... page
- Can use Shuffle Filter with Collapsible layout
- Can adjust border width, color, style in Grid layout with new style settings
- Can filter posts by month 1 to 12 (for example filter posts in January of every year)
- Can show both Author name & avatar
- Can add words to ignore when extract index in Glossary layout
- Can change display order of taxonomies in Shuffle Filter
- Can reuse View by set new value to compare for selected custom field in the View

* Improve:
- [Shuffle Filter] Increase speed and reduce CPU usage on displaying new posts which are loaded dynamically by pagination
- Update custom-size image function to resize image by URL rather than attachment ID
- More clear and simple label, text for some settings

* Fix:
- Shuffle Filter does not work when shows Advertisement in View

= 4.2.2 =
* Update:
- Able to show Advertisement in "All" tab of Shuffle Filter
- Update Lazyload script to handle cached images by browser
- Remove default underline text decoration for links on hover, in Timeline layout

= 4.2.1.2 =
* Fix:
- Insufficient results when filter by "Today and future" date
- Remove border in Tablet devices when "Items Per Row (Tablet)" is 1
- Correct output of custom field in Tablet devices

= 4.2.1.1 =
* Fix: The thumbnail doesn't display at top with format "Show thumbnail on the left/right of text" in old Views

= 4.2.1 =
* New:
- [Shuffle Filter] Add setting to hide the "ALL" option
- [Collapsible List] Add setting to open all items by default

* Improvements:
- [Add/Edit View] Simplify label, description of some settings. Add friendly popover description for Shuffle Filter.
- Many small style improvements

= 4.2 =
* New:
- [Performance] Improve performance with lazy loading for image, iframe
- [Style Settings] Add text-transform, line-height, letter-spacing settings. Improve UI for font-weight, font-style, text-decoration. Able to set custom font-family (besides Google fonts from previous versions).
- [Shuffle Filter] Add style settings for active, heading element
- [Filter by Custom Fields] Add DATETIME type to able to compare more precise by hour, minute, second
- [Advertisement] Able to show Advertisement which is made by shortcode
- [Sort by Custom Field] Able to specify date format for custom field to correct sorting result

* Integrate with other plugins:
- "The Events Calendar" plugin: correct output for venue, organizer of events
- MemberMouse plugin: show content only if current visitor has access to
- SearchWP plugin: retain SearchWP order for search results page when using Content Views Pro to replace layout

= 4.1.1 =
* Fix: Custom color of text (title, content) in Overlay doesn't work

= 4.1 =
* New:
- [Meta fields] Able to set custom format for Date
- [Shuffle Filter] Able to show posts count on each filter

* Fix:
- Compatibility issue with Relevanssi plugin: "No posts found" when use CVP to replace search results layout

* Improve:
- [Shuffle Filter] Prevent issues when 2 terms in different taxonomies but have same slug (by replacing term slug in data-value, data-groups attributes by taxonomy name & term ID)

* Update:
- [Shuffle Filter]: Enable "Load more posts automatically when click on term" by default
- Remove restriction of Layout format in Timeline, Glossary layout
- Update style for right to left text direction
- And many small updates, improvements

= 4.0 =
* New:
- Complete new solution to replace layout in Blog, Category, Search... page: without modifying file, works across themes
- Date Settings: Able to show posts of specific Year

* Improve:
- Better support for custom field of Pods, Toolset Types plugin
- Better support for Polylang plugin: easy to add translation of View

* Update:
- [Overlay & Animation] Update description of settings, enable 2 settings for "always" overlay

* Fix:
- [One & others layout] Fix output issues of thumbnail

= 3.9.9 =
* Update (View dashboard):
- Merge "Put mask of fields in front of thumbnail", "Hover animation" to one setting "Overlay Thumbnail With Text". Rename tab "Animation" to "Overlay & Animation"
- Add setting to set color of Overlay text, to set background color of Title
- Replace "Top margin in hover box" by more versatile setting "Overlay position"
- Remove setting "Remove space between posts"
- Visual simulator for font style & font-weight
- Add clear button for padding, margin settings

* New & Improvement:
- Able to overlay thumbnail with text always
- Able to set position (top, middle, bottom) of overlay text
- Rebuild padding & margin system, work more effectively with any layouts
- Show alt tag of image inside post content (when no Featured image found)

= 3.9.8.2 =
* New: [One & Others layout] Able to show Taxonomy
* Fix: Compatibility with QTranslate X plugin (posts which language was not set are not shown)
* Update:
- Use 'inherit' (instead of 'any') status when filtering Media (attachment)
- Apply custom style settings of Content to all elements in content div, except Read more button
- Set line height as 1.3 multiples of element's custom font size, to prevent text overlap each other

= 3.9.8 =
* New:
- Hover Animation, Scrollable list: Able to show mask/caption directly on Mobile devices & small screens (<=480px)
- Able to show navigation in Lightbox of thumbnail

* Update:
- Cache social share count of posts in 2 hours to prevent prohibition of access these APIs
- Apply forced mask, post border for Grid layout only
- Add explicit option for using current page as current/base page
- Remove setting "Show only glossary index" of Glossary layout

* Fix:
- Reusing View with limit, offset parameters does not work with pagination

= 3.9.7.1 =
* Fix: No media found when querying media without specifying status
* Improvement: Smooth initiation of Shuffle Filter layout in hidden area (tab, toggle) when it becomes visible

= 3.9.7 =
* Fix: Conflict with Elementor pagebuilder plugin
* Improvement: [Line up fields across items] faster, better
* Improvement: [Custom Fields] Support more date formats when customizing date output
* Update: Restructure Content Views Settings page

= 3.9.6 =
* New: [Shuffle Filter] Able to set operator cross taxonomies, hide filter bar of any taxonomy
* New: [For Woocommerce] One-Click to display "Out of stock products"
* New: Able to show custom field when display taxonomy as output
* New: Able to set manual positions for Advertisements
* Update: Show tab "Advertisement" by default. Add option to display ads when replacing theme layout

= 3.9.5.2 =
* Fix: Facebook share count returns 0 (due to the recent changes in Facebook Graph API)
* Fix: Some fields has no bottom margin in Grid layout
* Fix: Notice undefined index in file wp-updates-plugin.php
* Improvement: Cleanup some CSS code

= 3.9.5 =
* New: Cool Grid layout with mask of fields & without space between posts
* New: Able to add border between posts for Grid layout
* New: Add option to exclude content of any HTML tags in excerpt
* New: Add option "Do not show default image"
* New: [Hover animation] Make it clickable on hover
* Update: Drop "View count" sorting option because of view counter is too simple and inaccurate
* Update: Add "License Details" link to Content Views Settings page
* Improvement: More friendly padding, margin settings
* Improvement: More friendly settings for Scrollable list

= 3.9.4 =
* New: Add "Troubleshoot problems" section to Settings page, to fix Facebook share shows wrong image
* Update: [Shuffle Filter] "Load more posts automatically when click on term" should be triggered one time
* Fix: Shuffle Filter layout goes wrong in hidden container

= 3.9.3 =
* Fix: Conflict with plugin Relevanssi (filter by multiple keywords show no posts)
* Fix: Broken View output when put View shortcode in Text element of Divi Builder plugin
* Fix: [Glossary list] Invalid heading character for Arabic, Japanese, Chinese...
* Fix: gzinflate() data error on update message
* New: [Scrollable list] Support swipe action on mobile, tablet devices
* New: Add filter to enable lazy loading for Youtube video
* Update: Remove setting "Include current post" setting

= 3.9.2 =
* Fix: Shuffle Filter shows posts of not selected term
* Fix: background color, padding setting are not updated for new Pinterest/Masonry layout
* New: [Terms as output] Able to show Read more button
* Tweak: Add filter hook to modify value of custom field before querying

= 3.9.1 =
* Fix: Conflict with CloudFlare Rocket Loader

= 3.9 =
* New: Able to use Pinterest, Masonry layout with Shuffle Filter
* New: Able to use View pagination when replacing layout of page (Category, Blog, Archive...)
* New: [One & others layout] Able to show custom field, able to show Read-more button independently (without showing Excerpt)
* New: Able to reusing View by keyword, post ID
* And many small improvements

= 3.8 =
* New: (Shuffle Filter - Group options by Taxonomy): Able to select AND/OR operator for each taxonomy
* New: (Shuffle Filter) Able to show All/Limit posts of selected term on pagination
* New: (Shuffle Filter) Able to load posts automatically when click on term
* New: (Meta fields) Able to choose more than 1 taxonomy in "Let me choose" section
* New: Able to force replacing featured image by image/audio/video in post content
* New: Able to show Full Content of other posts in "One & others" layout

= 3.7 =
* New: Able to show ads (Google Adsense, banner...) randomly in View output with friendly settings
* New: Able to sort posts by Drag & Drop in Preview panel
* Update: Add icons for View types, restructure/update settings to improve usability
* Update: Leverage WordPress core translations for text in View dashboard, View output to minimize user translation effort & improve usability

= 3.6.2.3 =
* New: Complete solution to handle manual excerpt (show its original content, trim & format it like generated excerpt, ignore it)
* Update: Show '...' at end of Title when trimming Title length to specific number of letters

= 3.6.2.2 =
* Update: Remove "View type settings" of Collapsible List (includes 2 features: "open first item" will be implemented by default, "open multiple items at same time" is not user-friendly experience)
* Update: Able to show "Edit Post" link even Post Title was not shown (that link was append to Title in prior versions)

= 3.6.2.1 =
* Fix: Incorrect text align for RTL direction
* Fix: Conflict with Javascript library (imagesLoaded)

= 3.6.2 =
* New: Able to show terms (with thumbnail, title, description) on any layout
* New: [Style Setting] Add "Hover animation", "Caption (Scrollable list)" background color setting (it was configured via Content's background color in prior versions)
* New: Able to show X posts of each selected terms (X is an input number)
* New: [Reuse View] Able to filter posts IN category and NOT IN another category
* Fix: Title hover color does not work in Collapsible list
* Update: Remove default font-size in some View elements
* Update: Disable Line up fields when enable Shuffle Filter (it caused some small style issues)
* Update: Hide "Hide this post" button by default
* Tweak: Add description under "Custom size" setting when images are not same size
* Tweak: Add filter to "exclude another field on mouse over", "change loading icon" by custom PHP code
* Improvement: styles for Pinterest, Glossary list, Hover animation

= 3.6.1.1 =
* Fix: TGM-Plugin-Activation stands as another plugin

= 3.6.1 =
* Fix: Conflict with "mootools-1.2.5-core-yc.js"
* New: Able to disable Hover animation on mobile devices
* New: use TGM-Plugin-Activation library to require, install, update Content Views free

= 3.6.0 =
* Bug fixed: [Shuffle filter] Empty filter text in other languages of WPML plugin
* Improvement: Prevent errors of Masonry layout, Shuffle filter (caused by impacts of scripts from theme/other plugins)
* Improvement: Show option to control behavior with Membership plugin (Ultimate Member, Members, Paid Memberships Pro) & Translation plugin (WPML, Polylang, qTranslate)
* Improvement: Twitter share count are back! Fixed performance issue when enables "Show share count"
* Improvement: [Meta fields settings] cleaner structure, add option to remove slash (/) between fields
* Improvement: Style of Masonry, Shuffle filter dropdown
* Update: Resize image inside post content if uses "Custom size"
* Update: Able to reuse View with "post_parent" parameter

= 3.5.5 =
* Improvement: Smooth Pinterest/Masonry layout when do pagination
* Update: [Shuffle Filter & Pagination] Pull all posts of selected filter (term) on click
* Update: Supports "Members", "Paid Memberships Pro" plugin
* Update: [Infinite pagination] Load posts earlier on scroll
* Bug fixed: "No post found" with Polylang 1.8.0
* Bug fixed: "No post found" when filter by taxonomy, with WPML 3.2
* Bug fixed: Style issue by Social buttons text
* Improvement: Style of WooCommerce price, Hover-animation box
* Improvement: [View dashboard] Add/update description, correct dependencies of some settings

= 3.5.4.1 =
* Bug fixed: Responsive settings for Pinterest layout does not work

= 3.5.4 =
* Improvement: Best "line up fields across items" ever for Grid layout
* Improvement: Better description for settings of "One and others" layout
* Update: Hide post if no content found for current language of qTranslate-X plugin
* Bug fixed: Remove empty space of Masonry, One and others layout

= 3.5.3 =
* Bug fixed: Google font works on preview but not on website
* Bug fixed: Popup window (in Firefox browser) has no scrollbar when open item in new window

= 3.5.2 =
* Bug fixed: Read-more button covers content when resize browser
* Improvement: Better Masonry layout for small screens

= 3.5.1 =
* Improvement: Better responsive output for One & others layout

= 3.5 =
* New feature: Show format icon for Post
* New feature: Custom format for Date custom field
* New feature: Can use Limit setting of View when replace WordPress layout (*check doc*)
* New feature: Can set Limit, Offset when reuse View
* Bug fixed: Duplicated posts, show wrong number of posts per page when order randomly & enable pagination
* Bug fixed: Twitter share does not work with Title contains vertical slash "|"
* Bug fixed: Shuffle filter with numbered pagination
* Update: Can select multiple (instead of all) post types
* Update: Can adjust style of active filter in 3rd style of Shuffle-filter
* Update: Do not shuffle posts automatically when Shuffle-filter is enabled
* Update: Disable custom size thumbnail if screen width < 992 pixels
* Update: Sort posts automatically when select posts for "Include only" setting
* Improvement: **View dashboard revolution** (more friendly Style Settings, simplify/remove/restructure text & description, improve display in Tablet)
* Improvement: Better responsive output
* Improvement: Better Shuffle-filter output

= 3.4 =
* New feature: Able to display taxonomy in special place (sample)
* New feature: Able to show author avatar on every layout
* New feature: Able to select what taxonomy to display terms in Meta fields output
* Improvement: [Pinterest layout] Remove "Minimum width" setting. Update responsive output for small screens.
* Improvement: [Pinterest layout] Restructure & update description of settings
* Improvement: [View dashboard] Able to toggle setting groups under "Fields settings"
* Update: Add option to hide prefix "in" (before terms), prefix "by" (before author name) in Meta fields output
* Update: Simplify description of some settings
* Update: Use flat button (border radius = 0) by default
* Tweak: Update filter "pt_cv_ctf_value"

= 3.3 =
* Bug fixed: Custom field value displays incorrectly when contains URL
* Bug fixed: Line up fields across items does not work when Shuffle Filter is enabled
* Improvement: Better function to resizing image to custom size
* Improvement: Better responsive output of One and others layout
* Improvement: Able to replace pagination of page while replacing page layout
* Improvement: Output of meta-fields in Timeline layout when Hover animation is enabled
* Improvement: How numbered pagination show/hide when Shuffle Filter is enabled
* Improvement: Able to show "Edit Post" on Collapsible list
* Improvement: Better responsive output for "Group filter options" type of Shuffle Filter
* Improvement: Style of Scrollable list, center "Text align", "Edit Post" button, Shuffle Filter, WooCommerce products...
* Update: Prevent posts of child terms from being retrieved when Shuffle Filter is enabled
* Update: Disable "the_content" filter for manual excerpt
* Update: Use View ID in Shuffle Filter ID to easy management
* Update: Disable position setting for "Group filter options" type of Shuffle Filter

= 3.2 =
* New feature: New layout "One and others"
* New feature: Able to set padding for each Item
* New feature: Able to reuse View by another post type, by author
* Bug fixed: Include posts does not work with 'Any post types'
* Bug fixed: Not good output of custom field image in Safari, IE
* Bug fixed: Warning messages relates to Twitter share count function
* Update: Reset Offset when reuse View
* Tweak: Change min-height of Pinterest item

= 3.1.2 =
* Bug fixed: Custom field value displays in 2 lines on Firefox
* Improvement: Thumbnail does not fit Pinterest layout
* Improvement: Cleanup script of Content animation

= 3.1.1 =
* Bug fixed: ACF image not found
* Improvement: Avoid bugs caused by ambiguous comparison

= 3.1 =
* Improvement: Reduce processing time by optimizing conditional statements & functions
* New feature: [Woocommerce 2.4.8] Able to show Sale products with 1 single click
* New feature: [Woocommerce 2.4.8] Able to show Sale badge for products
* New feature: Able to set background color for whole item
* New feature: Able to set color, decoration for Tile on hover
* Bug fixed: Fix bug in support for Paid Membership Pro plugin
* Bug fixed: [Woocommerce 2.4.8] Top rated products does not work
* Bug fixed: Images look distorted when use custom size
* Bug fixed: Custom color of content does not work in some themes
* Improvement: [View dashboard] Better descriptions for some settings
* Improvement: Update styles/scripts of Pinterest layout, custom field, pagination to prevent issue caused by style of theme
* Update: [ACF] Show full image (instead of thumbnail image)

= 3.0 =
* New feature: Make Shuffle Filter works with any types of Pagination
* New feature: [View settings] Able to search posts by Title to include, exclude
* New feature: [View settings] Intuitive button to exclude any post (in preview panel)
* New feature: Able to use "Hover animation" for all layouts
* New feature: Able to center fields in hover box vertically manually
* Bug fixed: Colorbox conflict with other plugins
* Bug fixed: Duplicated ID of multiple Shuffle Filter bars
* Improvement: More sexy Collapsible list
* Improvement: Little better Glossary list
* Improvement: Better style for multiple Shuffle Filter bars
* Improvement: Clean code relates to assets_compress_loading, uncompress_assets
* Update: Style for Masonry overlay
* Update: Style on mobile devices
* Update: Style for media thumbnail with layout-format = 2 columns
* Tweak: Update description of some settings

= 2.5.2 =
* Update: Able to select multiple options for Multi-Shuffle Filter
* Update: Able to use Type "Group filter options by Taxonomy" even for one taxonomy
* Update: Better function to extract images in post content: supports WordPress gallery shortcode & shortcode with format [shortcode_for_image src=""]
* Improvement: Update styles for Shuffle Filter dropdown, Collapsible list, pagination, Hover box

= 2.5.1 =
* New feature: Able to filter by any taxonomies if Content type is 'Any post types'
* Bug fixed: Loading icon was stretched in Pinterest, Masonry layout when option "resize to same width/height" was ticked
* Bug fixed: Term as heading does not work for non-latin term (chinese, russian...)
* Bug fixes: Media thumbnail does not fit its container
* Update: Show Large thumbnail (instead of Full image) for "Light box of Full thumbnail" to minimize load time
* Update: CSS improvements for Pinterest layout, custom field
* Tweak: Add filter 'ctf_value' to alter custom field value

= 2.5 =
* New feature: Able to open Full thumbnail in light box
* New feature: Able to resize thumbnail to same width, height
* Bug fixed: Did not display image/icon when query Media files
* Bug fixed: Round border for hover box when Thumbnail style = Rounded
* Improvement: Better default thumbnail image

= 2.4.1 =
* Bug fixed: Can't click on thumbnail on Mobile devices
* Bug fixed: Media thumbnail does not work

= 2.4 =
* New feature: Able to query Media files, any post types in a View
* New feature: Able to display select term as Heading of View
* New feature: Able to show social share count
* New feature: Able to query "in the past" posts by a date custom field
* Bug fixed: Masonry does not work with pagination
* Bug fixed: Solve problems with category/tag name in non-latin languages
* Bug fixed: Timeline body part is empty when untick "Show Content"
* Improvement: Show loading icon before Pinterest, Masonry layout finished
* Improvement: Restructure Taxonomy custom settings
* Improvement: Better instruction for filtering by Custom field. Correct some condition of date value.
* Improvement: Add link to document "Filter by a Date Custom field"
* Update: [Hover animation] Improve hover animation on mobile devices
* Update: Custom fields - sanitize field name before adds as class name of custom field output
* Update: Modify CSS for custom fields
* Update: CSS for hover animation, Pinterest layout

= 2.3 =
* New feature: [Hover animation] Show content block on click (on mobile devices)
* Bug fixed: Excerpt length does not work with Chinese, Japanese...
* Bug fixed: Error when filter by blank custom date/start date/end date
* Update: Use translation of Content Views free if Read-more text is 'Read More' (default text of this button)
* Update: Add filter "social_url"
* Update: Regenerate POT file
* Update: Some CSS modifications

= 2.2 =
* Bug fixed: Supports Ultimate Member ("Content accessible to Logged Out Users" does not work)
* Bug fixed: [Hover animation] Fix background height
* Bug fixed: Order posts by IDs in the list
* Bug fixed: Uncaught query function not defined for Select2 undefined
* Bug fixed: Grid layout for custom fields applied properties of Grid layout for posts. Which causes problem with Shuffle Filter...
* Improvement: More elegant UI for Fields settings
* New feature: [Hover animation] Able to always show Title without hover

= 2.1 =
* Improvement: Better Masonry layout
* Bug fixed: Missing section in some one-page themes when put multiple View shortcodes to sections
* Bug fixed: Height of hover content box is incorrect when images on row have different heights

= 2.0 =
* New feature: Masonry layout
* New feature: New animation effects for showing content on hover
* New feature: Shuffle Filter uses fade out effect
* New feature: New option "Shadow" for Thumbnail style, which add shadow box to thumbnail
* New feature: Add Opacity for Color picker
* Bug fixed: Broken images when set custom sizes for thumbnail
* Bug fixed: Custom fields is clipped off in small window sizes
* Bug fixed: Can't sort by Price of Woocommerce (ver 2.4.6)
* Update: Handle excerpt length of Chinese language
* Update: New system for updating plugin
* Update: More options for "Parent page"
* Improvement: Add default image when no thumbnail found

= 1.8.9 =
* Bug fixed: "Operator to compare" is not saved after reload
* Bug fixed: Fatal error on PHP < 5.4
* New feature: Able to change Name/Label of custom fields in output
* New feature: Able to display random posts from list "Common filters" > "In list"
* New feature: Able to Force same width, height for Custom size thumbnail
* Update: Can filter by 2 custom taxonomy when reuse a View
* Update: Ignore sticky posts for non-builtin post types
* Improvement: display large video (from value of custom field) in Mobile
* Improvement: Better output for Meta fields

= 1.8.8 =
* New feature: Able to place ALL sticky posts at top of View
* New feature: Able to display colon after name of custom field
* Bug fixed: Distorted image in mobile when custom-size is enable
* Bug fixed: Exclude sticky post does not work
* Bug fixed: Height of Hover content block does not correct in Hidden tab
* Update: Support serialized value of custom field (support wp-types checkbox)
* Improvement: Teak HTML of Timeline layout
* Improvement: Update settings for Excerpt

= 1.8.7 =
* New feature: Able to display content relevant to user's role (supports Ultimate Member plugin)
* Bug fixed: Pinterest displays incorrect number of items per row after pagination finished
* Bug fixed: Height of content-hover box is little insufficient
* Bug fixed: Custom background does not work when displays Readmore text as link
* Update: Display image tag if custom field's value is an image URL

= 1.8.6 =
* Update: Big update to improve page performance
* Bug fixed: Show duplicated inline style of View on page
* Bug fixed: Items per row of Pinterest does not work well
* Bug fixed: Title has no link when enable "Edit Post" button
* Update: Append 'future' status automatically if querying by date 'Today and future'
* Improvement: Reload Pinterest page if post's content contains Iframe

= 1.8.5.1 =
* Improvement: Don't execute shortcode in excerpt automatically, update admin css, fix bug JS admin
* Bug fixed: Show 'Edit Post' button for all users

= 1.8.5 =
* Bug fixed: Can't translate strings
* Bug fixed: Text of social buttons display out of position
* New feature: Able to display nothing (video/audio) if no thumbnail found
* New feature: Custom CSS & JS box in Content Views Setting page
* Improvement: More correction in width of Pinterest item
* Update: Move position of "Style Settings" tab for best user experience

= 1.8.4 =
* Bug fixed: Lot of space between items in Shuffle Filter list
* Bug fixed: Can't filter by value of Custom field
* New feature: Support Polylang plugin (1.7.6)
* New feature: Able to display "Edit Post" button for each post in View
* New feature: Grid layout for Custom fields
* Update: Enable Content, Thumbnail... in Glossary list
* Update: Change name of Mobile_Detect class, to prevent bug 'class existed'

= 1.8.3 =
* Bug fixed: Custom field does not show in Timeline layout
* Bug fixed: Can not set negative value for margin
* Bug fixed: Dropdown menu is hidden
* Bug fixed: Click Youtube video in No-action item causes error in IE

= 1.8.2 =
* Bug fixed: Pinterest does not work if parent element is hidden
* Bug fixed: Glossary heading is not ordered A-Z when add filter 'glossary_title_to_extract'
* New feature: Add "Edit View" button to output of View
* Improvement: Add animation for displaying terms as output
* Update: Move "Text direction" to "Style Settings" tab

= 1.8.1.2 =
* Bug fixed: Unwanted output is displayed in excerpt (caused by enabling filter)
* Update: Add option to enable/disable filter in excerpt

= 1.8.1.1 =
* Bug fixed: Unwanted output is displayed in excerpt (caused by enabling filter)

= 1.8.1 =
* New feature: Add option to display which (image or video/audio), if thumbnail not found
* Bug fixed: Translation does not work in excerpt
* Bug fixed: Number of "items per row" does not work well in Tablet
* Bug fixed: Can not redeclare class Mobile_Detect
* Bug fixed: Can not get Youtube embed video to display as thumbnail
* Update: Remove "Unload Colorbox" option in Settings page. Add filter as alternative solution
* Update: Disable "Don't compress styles & scripts of CVPro"
* Update: Always open link of custom field in new tab/window
* Update: Re-generate .po file

= 1.8.0 =
* New feature: Support "Paid Memberships Pro" plugin
* New feature: Display correspond output if custom field's value is url, email, link to mp3 file, link to mp4 file
* New feature: Hide empty terms (which has no posts) in Shuffle Filter list
* New feature: Able to adjust "All" word in Shuffle Filter list
* Update: More option for filtering by Custom fields
* Update: Restructure plugin's core functions & variables
* Update: Use alt tag of post thumbnail for Pinterest sharing button
* Update: Remove special chars from Glossary header
* Bug fixed: Can not click on Glossary header in Preview panel
* Bug fixed: The collapsible list does not toggle when click on "+, -" icon
* Bug fixed: Shuffle Filter does not work
* Bug fixed: Can not order posts by "In list"

= 1.7.2 =
* New feature: Able to change style of Woocommerce "Add to cart" button
* New feature: Add "Report bug" button
* Bug fixed: 'array_replace' Function undefined in PHP < 5.3
* Bug fixed: Can't save Font style in Style Settings tab
* Bug fixed: Can't save display order of selected terms
* Update: Update style & behavior of pagination for Timeline layout
* Update: Update social link of Twitter, Pinterest
* Update: Execute shortcode in Excerpt
* Update: Decrease minimum item width of Pinterest layout
* Update: Better excerpt for Chinese content

= 1.7.1 =
* Improvement: Better responsive for mobile devices

= 1.7.0 =
* Bug fixed: Pagination does not work in page has more than 2 Pinterest Views
* Bug fixed: Blank space in layout which uses Shuffle Filter
* New feature: Able to display Social share links (Facebook, Twitter, Google +, LinkedIn, Pinterest)
* New feature: Able to set number of items per row in Mobile devices
* New feature: Include or exclude posts of children taxonomies
* Update: Resize thumbnail on the fly when 'custom size' is selected
* Update: Able to execute shortcodes before generating excerpt

= 1.6.9 =
* Bug fixed: Multiple paginations on same page do not work
* Bug fixed: Can not re-use a View
* New feature: Filter written/not written by current user

= 1.6.8 =
* Bug fixed: Does not display enough terms ("Display selected terms as output" feature)
* Bug Fixed: "Line up fields" is broken when window resizes
* Bug fixed: Thumbnail is distorted in Tablet
* New feature: Get one post of each selected terms
* New feature: Able to set border-radius of buttons
* Update: Able to use Shuffle Filter with "Normal" Pagination
* Improvement: Force displaying higher dimensions on Mobile

= 1.6.7 =
* Bug fixed: RTL does not work
* Bug fixed: Pinterest layout does not display images on Mobile
* Update: Able to display only index of Glossary layout
* New feature: Able to display terms (category item, tag item...) as output

= 1.6.6 =
* New feature: Glossary list
* New feature: Able to get fields of current post
* Bug fixed: "Read more" button in Grid layout covers content area
* Bug fixed: Media Thumbnail is not shown if Thumbnail size is "Original resolution..."
* Update: Support ACF "Page link" field
* Update: Date format in Timeline view is controllable with 2 options: human readable format OR WordPress format (default value)

= 1.6.5 =
* New feature: Able to display "Read more" as a link, not button
* New feature: Able to configure minimum width of Pinterest item
* New feature: Beautify name of custom field automatically
* Improvement: Enable assets (libraries, view types, common) compression
* Improvement: Update code quality

= 1.6.4 =
* Bug fixed: Googlebot doesn't fetch Pinterest content
* Bug fixed: Colorpicker doesn't work
* Bug fixed: Repeater fields of ACF shows duplicated content
* New feature: Items on filter options bar will be sorted by their appearance in "Select terms" option when "Operator" is "IN" or "AND"

= 1.6.3 =
* Bug fixed: Pinterest layout is broken after paging
* New feature: Able to use Normal pagination (without Ajax)
* New feature: Excludes current post from View output
* New feature: [Advanced filter - Date] Able to display "Today and future" posts (no past posts)
* New feature: [Advanced filter - Custom fields] Able to display "Greater or Equal Today" posts (no past posts)
* New feature: [Pinterest layout] Able to hide bottom border of each fields

= 1.6.2 =
* Bug fixed: Pinterest layout is broken when pagination
* Bug fixed: Center layout disappears when resize window
* New feature: Able to Sort by order of appearance in "Common filters > In list"
* New feature: New option to set Nofollow for item links

= 1.6.1 =
* Bug fixed: Stripped content in Shuffle Filter list
* Update: Add 'EXISTS', 'NOT EXISTS' options to filter by Custom fields
* Update: Able to adjust Font settings for Numbered pagination
* Improvement: Show human readable format (meta field)
* Improvement: Better Pagination style
* Improvement: Update descriptions and positions of setting options

= 1.6.0 =
* New Feature: Hide empty custom field
* New Feature: Prepend sticky posts to beginning of output
* Bug fixed: Fix some bugs with Easy Digital Download
* Bug fixed: Fix warning with ACF select box
* Bug fixed: Editors still can see CVPro setting menu when set Administrator for "User role who can manage Views"
* Bug fixed: 'No post found' when reuses a View with a numeric term value
* Bug fixed: Can't set background color for Scrollable list

= 1.5.0 =
* Bug fixed: Important bug which reset settings on front-end

= 1.4.9 =
* New Feature: Enable to limit Title length (letters)
* New Feature: More options for Sticky posts (prepend to output)

= 1.4.8 =
* Bug fixed: Override WP layout shows empty output
* Bug fixed: Scrollable's transition does not look good in Safari
* Bug fixed: Pinterest layout is weird when click pagination button
* Improvement: Better responsive Pinterest layout
* Improvement: Re-arrange options for Scrollable List
* Improvement: Code refinement

= 1.4.6 =
* Bug fixed: Items in view type are cut off height
* Bug fixed: Shuffle Filter - Match wrong terms if they contain a same string
* Improvement: Better Pinterest layout when browser resizes

= 1.4.5 =
* Bug fixed: Layout is broken when overrides layout of WordPress
* Bug fixed: Layout of Shuffle Filter list is broken
* Bug fixed: Dimensions of image was incorrect if that was image inside content of post

= 1.4.4 =
* Bug fixed: Shuffle Filter has gap after sorting
* Bug fixed: Wrong 'ago' time of Timeline
* Bug fixed: Browser opens new tab in Firefox with 'No action' of 'Open item in'
* Bug fixed: 'Show content on hover' display does not well if thumbnails have different dimensions
* New Feature: Order by Custom fields
* New Feature: Reuse a View - able to filter by multiple taxonomies
* Update: Don't auto select 'Or automatically set current page (or its parent) as Parent for the list'
* Update: Lightbox does not display well in mobile if width, height as 50% x 50%

= 1.4.3 =
* Improvement: A very new customized Bootstrap style
* Bug fixed: Style settings of Title doesn't work when select 'None' as 'Open item in'

= 1.4.2 =
* New Feature: Order by 'Page Order'

= 1.4.1 =
* Bug fixed: Show 'custom-fields' instead of name of custom field

= 1.4 =
* Bug fixed: Pinterest layout is broken when View is loaded by Ajax
* Bug fixed: Icons is not displayed correctly in Meta fields when select custom font-family
* New Feature: Animation & Effect - Show Content on hover
* New Feature: Infinite scrolling pagination
* New Feature: Line up fields (Title, Content...) across items
* Update: Able to show/hide '...' at tail of Excerpt
* Update: Refine Javascript code for Preview/Front-end

= 1.3.6 =
* New Feature: Automatically set current page (or its parent) as Parent for the list (when filter by Parent page)
* Bug fixed: Don't show 'Read more' button if manual excerpt length is smaller than 'Excerpt length'
* Update: Auto trim manual excerpt by 'Excerpt length'

= 1.3.5 =
* New Feature: Filter by Custom field
* Update: Add class for each ACF field, remove link from image field
* Update: Able to display fields dynamically in Pinterest layout

= 1.3.4.1 =
* Bug fixed: Read more settings does not work

= 1.3.4 =
* Update: Support most types of Advanced Custom Fields (ACF)
* Update: Able to drag & drop to change display order of Custom Fields
* Update: Extends feature "overwrite output of WordPress by CVPro layout", allow to pass array of $post

= 1.3.3 =
* New Feature: Filter by Date
* New Feature: Add Text align option
* Update: Auto load refined Bootstrap for Pro users by default

= 1.3.2.3 =
* Bug fixed: Fix bugs of Shuffle Filters (by multiple taxonomies)

= 1.3.2.2 =
* Bug fixed: Custom thumbnail sizes affect other Views in same page
* Improvement: Better label for Background color option in 'Font settings' section

= 1.3.2.1 =
* Bug fixed: Fix display problem when use large font size
* Bug fixed: Fix teaser/more tag problem

= 1.3.2 =
* New Feature: Group filter options by Taxonomies (for Shuffle Filter feature)
* New Feature: Pinterest layout with "Border box" style
* Improvement: Refine layout rendering mechanism of Pinterest

= 1.3.1.1 =
* Bug fixed: Style settings is not applied when replace WordPress layout by CVPro layout
* Update: Restructure Taxonomy filter (remove "Not In" list, add operator[In, Not in, And])
* Improvement: Update style for WooCommerce (Add to cart button)

= 1.3.1 =
* Update: Completely new documentation with lot of update
* New Feature: Customizable Load more button (text of button, Font settings [color, font family, font style, font size])

= 1.3.0.2 =
* New Feature: Able to load only content of post in Lightbox

= 1.3.0.1 =
* Update: Small update for responsive layout in smartphones

= 1.3.0 =
* New Feature: Able to show Custom fields and control its style (font, color)
* New Feature: Auto extract Youtube, Vimeo, Dailymotion, Soundcloud from posts if thumbnail is not found and there is no image in post content
* Improvement: Control style of "Read more" button, Filter options completely (font, color, background color)
* Improvement: Always display an even number of items per row in smaller device (to remove gap/space in rows)

= 1.2.6 =
* Update: Important update about caching mechanism
* Update: Update translation file

= 1.2.5 =
* Improvement: Add option to load refined Bootstrap style (which removed font-size, color properties of Bootstrap for Heading, Link...)
* Update: Able to use 2 columns format in Pinterest layout
* Update: Force to resize image to selected custom sizes
* New Feature: Able to control what user role can manage (add, edit, delete) View
* New Feature: Duplicate a View

= 1.2.4.4 =
* Bug fixed: Images are not displayed in same dimensions

= 1.2.4.3 =
* Bug fixed: Thumbnail is not shown up in Timeline layout

= 1.2.4.2 =
* Update: Add option to decide whether or not to insert icon before meta fields
* Improvement: Show notices if Free plugin is not installed and activated

= 1.2.4.1 =
* Improvement: Adjust some styles for Shuffle Filter options, output generated by replacing WordPress layout by CVPro layout
* Update: Update documentation

= 1.2.4 =
* Improvement: A faster solution for overwriting output of WordPress template file
* Improvement: Better meta fields display (add icons, remove prefix text, remove '/' separator)
* Improvement: Add options to customize margin of View, color of fields. Move Font settings to "Style Settings" tab
* Improvement: Add option to get manual excerpt if it exists
* Improvement: Add option to hide sticky posts from output
* Improvement: Add option to customize border radius for rounded thumbnail
* Improvement: Add option to whether or not to open first item at page load (for Collapsible list)
* Improvement: Add constraint checking for Shuffle Filter (with Pagination and View type)

= 1.2.3 =
* Fix Colorbox style conflict: Add option to unload Colorbox assets in frontend
* Add Shuffle Filter feature
* Add "None" option to "Open item in"
* Update mobile, tablet breakpoints (show as many items as possible in mobile, tablet)
* Update: Enable to set offset value is greater than limit value

= 1.2.2 =
* Right to Left support

= 1.2.1 =
* Add new feature: Completely replace Taxonomy archive page by a configurable View

= 1.2.0 =
* Add Alignment option for Pagination
* Add options to quickly filter Terms (Start with, End with character)
* Add option to only display taxonomies which their terms are checked to filter posts (for case you only want to display Category or Tag)
* Fix Woocommerce order & orderby bug
* Optimize filters system

= 1.1.1 =
* Fix bug of width of item in Pinterest layout in mobile

= 1.1 =
* Activate/Deactivate request
* WooCommerce support: Quick filter products, show Price & Add to cart
* Update text of Preview button after sort fields/meta fields

= 1.0.5 =
* Fix offset bug for pagination

= 1.0.4 =
* Fix bug (remove warning when deactivate Free package)
* Fix minimum value bug of Offset option

= 1.0.3 =
* Fix bug (doesn't work with Free package in some cases)

= 1.0.2 =
* Add "Offset" option
* Do action only if Free plugin is installed

= 1.0.1 =
* Fix notice when update Free version

= 1.0.0 =
* Initial release
* Fix bug (doesn't work with Free package from wordpress.org)
* Update Timeline layout