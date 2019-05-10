=== User Post Gallery - UPG ===
Contributors: odude
Tags: guest post, user post, anonymous post, frontend post, guest author,  frontend content, frontend post, frontend upload, generated content, guest blog, guest blogging, guest publish, guest upload, post sharing, post submission, public post, share posts, submit post, user generated, user submit, user submitted post, visitor post
Donate link: http://paypal.me/gupta977
Requires at least: 3.8
Tested up to: 5.1.1
Requires PHP: 5.5
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Frontend/Guest submitted post, images, Youtube & Vimeo Gallery.

== Description ==
= UPG - User Post Gallery =

User Post Gallery (UPG) is the easy way to allow visitors/guest to post/edit images, article, YouTube, Vimeo videos without registration from the frontend. Submitted post can be shown inside BuddyPress, ultimate-member plugins in a user profile tab as a gallery.

Using layout editor, you can re-design completely using PHP & CSS.

That's all there is to it! Your site now can accept user generated content. Everything is super easy to customize via Plugin Settings page.

The pages like submission form, gallery page are auto created as soon as plugin is activated. 

== Independent Gallery ==
There are 2 types of UPG Gallery. 

* Embed gallery : [upg-attach] shortcode can be used in any wordpress post/pages. The images/video submitted at this page will have own set of gallery specific to embed page.
* Primary gallery : [upg-list] shortcode must be used in wordpress page. It will combine gallery of all the images/video posted on different post.  

== Embed Gallery ==
To embed gallery for WordPress post use shortcode [upg-attach] into the content area where ever required.
The image/video url posted on this post will not be visible on other post. 
It is full of ajax, hence no page refresh is required during submission and page navigation.
Lazy Load more button is available and images can be previewed in lightbox. 
Optimized pre loading of images

== Primary Gallery ==
It is independent gallery. All the UPG post submitted on different post can be visible at [upg-list].
It also works as the main page of UPG gallery.
It has lots of shortcode parameters to filter & change layouts.

== Submission Form [upg-post] ==
* Registered & visitors can post images/article/youtube video url from the front end.
* Ajax powered submission form. Form submitted on same place. No more form redirection. 
* Options of static page form submission. Best fit if javascript is not required.
* Redirect to selected page after form is submitted. (upg-pro)
* Ready layouts to be used for submission form.
* Options to create own custom fields. Get extra information from user during form submission. 
* Google ReCaptcha code for spam protection.  (upg-pro)
* Bulk image upload. (upg-pro)
* With the help of personal layout form, user can create own advanced personalized form with the help of PHP.
* Options to display submission button only to logged in users.  


== Admin Post Management ==
* Administrator can show or hide particular categories/albums from the frontend.
* Controls over custom fields to be displayed at backend & frontend.
* Options to set as approval of post/images before it is displayed at the frontend.
* Ability to approve/draft post in bulk
* Create unlimited albums and tags.
* Assign guest submission post to specific existing users.
* Ability to hide selected album/category from frontend & in widget category list.
* Own media sizes for thumbnail and preview page. 

== User Post Management ==
* Loggedin users can delete own uploaded post with ajax system.
* 'My Gallery' page for loggedin users. 
* User can edit & delete own post.
* Notification via email when someone submits form. (UPG-PRO)

== Display submitted post ==
* Responsive article/image/YouTube/Vimeo gallery for mobile & tablets.
* Automatically & manually display all submitted content on the frontend.
* Content & images can also be posted from the backend with additional options.
* External plugins shortcodes can be added near UPG post.
* Options for both lightbox and static page (Preview Page).
* Set number of images to be displayed per page.
* Multiple layout options available. You can create own layout from scratch using personal layout.
* Navigate posts/images with album or tags using widgets.
* Page navigation with the help of WP-PageNavi plugin.
* Ability to show gallery based on username, category, albums, tags with the help of shortcodes
* Display gallery in sliding or carousal layout with plenty of parameters.
* Camera EXIF Data is auto extracted form image uploaded by user.

= <a href="https://wordpress.org/plugins/ultimate-member/">Ultimate-Member</a> & <a href="https://wordpress.org/plugins/buddypress/">BuddyPress</a> Plugin  =
* Integrated with Ultimate-Member & BuddyPress plugin 
* Gallery tab is created on profile page.
* Gallery profile avatar will link to social profile page

= YouTube & Vimeo URL submission =
* User can submit video url with title
* Static thumbnail image is created automatically based on video
* Video can be shown in popup or link to different page.
* Video and Image gallery can be on same page. 

= <a href="https://wordpress.org/plugins/listpress/">ListPress </a> Plugin =
* Popup contact/query/feedback button can be placed on preview page
* Image of UPG post is included in form.

= <a href="https://wordpress.org/plugins/odude-ecard/">ODude Ecard</a> Plugin =
* Submitted post can be sent as ecard.
* Full featured greetings card site can be created with user submission.

== Other features ==
* Options to include posts into archive pages
* Widgets to list categories & tags.
* Widgets of submission form powered with ajax. 
* Multisite compatible
* Bulk Image Upload with options to limit number of image to upload. (upg-pro) 
* Other plugin shortcode can be displayed near image in preview layout. 
* REST-API with UPG custom fields



Basic installation video
[youtube https://youtu.be/Mu_-MD4dXYQ]



= Support =

For further questions feel free to drop a line at navneet@odude.com.
or
Go to our site to read full updated documentations and features at UPG FAQ. 

= Live Demo & Documents =
* <a href="http://odude.com/demo/faq/" target="_blank">Documents & FAQ</a>
* <a href="https://odude.com/demo/photo/" target="_blank">Photo Layout Demo</a>
* <a href="http://odude.com/demo/upg/sample-page/basic-layout/" target="_blank">All in One Demo</a>

= Development =

* <a href="https://github.com/gupta977/wp-upg">Fork the plugin or report an issue on Github</a>

= Language =

* German - Deutsche (de_DE)
* Spanish - Española (es_ES)
* Hindi - हिंदी (hi_IN)
* Italian - Italiana (it_IT)
* Swedish - svenska (sv_SE)

== Installation ==
= Steps to Install =

Some pages are auto created. Do not delete them even if not required.

* 1. User’s Post Gallery: Main UPG gallery page.
* 2. Post Image: Submission page for images.
* 3. Post Video URL: Submission page for youtube/vimeo url.
* 4. Edit UPG Post: Let users to modify/update own UPG post.
* 5. My Gallery: Registered user can see own submitted post.
	
Go to UPG Settings and select those pages at appropriate location.

= Shortcodes =

* Use shortcode [upg-attach type="image"]or [upg-attach type="youtube"] to create gallery on specific page/post
* Use shortcode [upg-list] to display UPG post from all the places

= Steps to Download =
* Go to your Plugins page inside your Wordpress installation and search `wp-upg` by keyword. Then choose User Post Gallery and click install. It will be installed in a few seconds.
* Activate the plugin from `Plugins` menu after installation
* Submission form and gallery and other pages are auto created. Select those pages at UPG settings.


== Frequently Asked Questions ==

= 1. How to display gallery =

Copy paste shortcode to post/page where you like to display gallery.
[upg-attach type="image"] or [upg-attach type="youtube"]

To display gallery based on album, tags, date, or more.. use shortcode
[upg-list]

= 2. What type of images does WP-UPG support? =

UPG supports the following types of image files: JPG, JPEG, PNG, GIF, YouTube URL, Vimeo URL

= 3. Create submission form =
Submission page are auto created when plugin activated. 
Or manually create page & insert the shortcode 
[upg-post type=image] 
in the description area. Link this page at your upg settings.

= 4. Show images from specific album/category =

Insert this shortcode in the textarea for a page and link that page to your menu.
[upg-list album="slug_name_of_your_upg_album"]

* <a href="http://odude.com/demo/faq/upg/shortcode-to-display-gallery/" target="_blank">Shortcode to Display gallery</a>

Leave album blank to show all UPG posts. 

= 5. What happen, if I update plugin =
When plugins are updated, the plugin/wp-upg folder is deleted and new one is created.
But this will not delete any uploaded post/media. 
If you are using 'personal layout'. Your UPG post may be blank page for 1st time. After refresh it will reappear. 
It copies files from upload folder to layout folder. 
But we advice to take backup before update.

= 6 . How 'personal layout' is different from other layout =
'personal layout' is a layout which is created by you. It is blank at the beginning. 
Whenever you use UPG 'layout editor', it copies the code from other layout to personal layout with the changes you have done.
It creates the physical file placed at wp-content\uploads\ folder. 
When plugin is updated, these files are copied at wp-content\plugins\wp-upg\layout\ folder.

== Screenshots ==
1. UPG Basic Layout
2. Drag & Drop Image (Bulk Layout)
3. UPG List Layout
4. UPG Photo Layout
5. [upg-attach] output
6. Submission Form based on settings
7. Layout Editor to design own layouts.
8. UPG admin settings
9. UPG admin dashboard
10. Lightbox/Popup to view image/video.

== Changelog ==
= 1.84 =
* noimg.png hidden from basic layout (preview page).
* Added bulk layout form (UPG PRO)
* Updated language file
* Selection of login page in UPG extra settings
* 'My Gallery' only accessible to loggedin user

= 1.83 =
* Updated photo layout
* Updated screenshots of layouts in settings

= 1.82 =
* Fixed debug error for 1.81 at setting.php page
* Sorry for trouble
* Fixed VIEW POST 404 error from UPG dashboard
* Updated settings page for easy view

= 1.81 =
* Deleted tag

= 1.80 =
* Options to enable/disable purecss.io, colorbox, fontawesome css file from frontend

= 1.79 =
* Added new 'Slide Layout'
* Updated style.css file
* Added settings to select 'my gallery' page.

= 1.78 =
* Fixes css issues in photo layout
* Fixes ultimate member function at shop layout
* removed wppost.php and upg-wp-post shortcode
* updated upg-attach css page

= 1.77 =
* Changed skin of reset button
* Bulk upload not supported by ajax
* Fixed photo layout

= 1.76 =
* New premium layouts are free
* UPG settings now toggle settings container

= 1.75 =
* Embed Photo Gallery for WordPress post & pages.
* Updated screenshots

= 1.74 =
* UPG media settings for thumbnail or media sizes.
* Admin notice after plugin activated

= 1.73 =
* Added default layout choice for form & media page in setting page.
* At admin addon page, separate tab for UPG layout.
* Updated language file.
* Updated basic layout, removed file upload information at form layout.
* Updated photo layout, masonry view at grid layout.

= 1.72 =
* Edit layout modify part is included with UPG PRO
* Star icon for important settings indicator at setting page
* Moved lib.php functions into functions.php
* Post modify now checks if post requires review as on settings. 

= 1.71 =
* Multiple form on same page fixed
* Updated language file


= 1.70 =
* Added ajax form submission
* Added ajax form widgets
* Added 'Simple' form layout (Only title & media field)

== Upgrade Notice ==
Backup your personal layout code before you upgrade. It may overwrite your layout with new one. If you got blank page, go to layout editor and choose layout to update automatically.