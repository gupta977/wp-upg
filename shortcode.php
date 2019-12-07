<?php
//Generate shortcode admin page
function upg_shortcode()
{
    ?>
    <div class="wrap">

        <?php
            do_action("upg_admin_top_menu");
            ?>

        <h2>Shortcodes included with UPG</h2>
        <h4>UPG comes with several shortcodes that can be used to insert content inside posts and pages.</h4>

        <script>
            jQuery(document).ready(function($) {
                $("#tabs").tabs();
            });
        </script>
        <div id="tabs">
            <ul>

                <li><a href="#tab-1"><?php echo __("[upg-list]", "wp-upg"); ?></a></li>
                <li><a href="#tab-2"><?php echo __("[upg-attach]", "wp-upg"); ?></a></li>
                <li><a href="#tab-3"><?php echo __("[upg-post]", "wp-upg"); ?></a></li>
                <li><a href="#tab-4"><?php echo __("[upg-form]", "wp-upg"); ?></a></li>
                <li><a href="#tab-5"><?php echo __("[upg-edit]", "wp-upg"); ?></a></li>
                <li><a href="#tab-6"><?php echo __("[upg-pick]", "wp-upg"); ?></a></li>
                <li><a href="#tab-7"><?php echo __("[upg-search]", "wp-upg"); ?></a></li>
                <li><a href="#tab-8"><?php echo __("[upg-album]", "wp-upg"); ?></a></li>
                <li><a href="#tab-9"><?php echo __("[upg-breadcrumb]", "wp-upg"); ?></a></li>
                <li><a href="#tab-10"><?php echo __("[upg-datatable]", "wp-upg"); ?></a></li>
            </ul>

            <div id="tab-1">
                <h3>Display Primary Gallery</h3>
                <h4> [upg-list]</h4>
                This will generate gallery of submitted images/video/post. If <code>[upg-list]</code> shortcode is used without parameters,
                the default settings applied at 'UPG settings'.
                But we can overwrite the settings with parameters into it.
                <hr>
                <b>Notes:</b>
                <ol>
                    <li>Do not use it in post page & widgets, if navigation required.</li>
                    <li>You can use it in front page, but page shouldn't be selected as 'main UPG page' in settings.</li>
                    <li>Parameters are case sensitive. Write all in lowercase.</li>
                </ol>

                <h4>Available Attributes:</h4>
                The following attributes are available to use in conjunction with the [upg-list] shortcode.
                They have been split into sections for primary function for ease of navigation, with examples below.
                <br>

                <div class="update-nag">
                    <ul style="list-style-type:circle;">
                        <li> <code>album</code> = "Slug name of album" - Displays gallery of specific UPG-Post album/category.</li>
                        <li> <code>tag</code> = "Slug name of tag" - To display gallery of specific UPG-Post tags.</li>
                        <li><code>tag_show</code>= "on/off" - To display related tags just above the gallery.</li>
                        <li> <code>perpage</code> = "No. of total post" - Number of total post to be displayed per page.</li>
                        <li> <code>perrow</code> = "No. of Rows/column" - Number of post to be displayed per row/horizontally.</li>
                        <li> <code>page</code> = "on | off" - Display page navigation if value is on. Only visible if <code>perpage</code> value is less then the total number of post.</li>
                        <li>
                            <code>orderby</code> = "date | title | modified | ID | rand" - 5 different ways the gallery can be sorted.
                            <ul style="list-style-type:disc;margin-left: 50px;">
                                <li>date - Order by date. ('post_date' is also accepted.)</li>
                                <li>title - List by post title.</li>
                                <li>modified - Order by last modified date. ('post_modified' is also accepted.)</li>
                                <li>ID - Order by post id. Note the capitalization.</li>
                                <li>rand - List random post.</li>
                            </ul>
                        </li>
                        <li> <code>layout</code> = "Gallery template name" - Each gallery can have their own type of layout. There are several default layouts available (i.e. list, flat , personal, etc.).</li>
                        <li> <code>popup</code> = "on | off" - The post when clicked will have a popup box instead going to another page. (Another page we call it as 'preview page')</li>
                        <li> <code>button</code> = "on | off" - The parameter is used to show a submission button at the gallery page. The submission button selected at UPG settings is displayed. If the shortcode parameter value is off , the buttons are not displayed even if it is set to show at UPG settings.</li>
                        <li> <code>author</code> = "on | off" - The parameter is used to show a author profile avatar at the top of gallery page.</li>
                        <li> <code>user</code> = "user's username" - The parameter is used to show a post gallery submitted by a particular username.<br>
                            show_mine user is reserved username of UPG.</li>
                        <li> <code>login</code> = "true" - Forces only logged in user can view the gallery.</li>
                        <li> <code>filter</code> = "image | embed" - If filter not specified it will show all upg post. </li>

                    </ul>
                    <h4>Scenario 1 – I want to display gallery where each column 3, total number of record each page is 6 from album 'fruits'</h4>
                    <code>[upg-list perrow="3" perpage="6" album="fruits"] </code>

                    <h4>Scenario 2 – I want only logged in member to view gallery</h4>
                    <code>[upg-list login="true"]</code>

                    <h4>Scenario 3 – I want to show gallery of current logged in user</h4>
                    <code>[upg-list user="show_mine"]</code>

                    <h4>Scenario 4 – I want to show latest uploaded gallery in 'slide' layout with popup enabled.</h4>
                    <code>[upg-list layout="slide" popup="on" orderby="modified"]</code>
                </div>



            </div>


            <div id="tab-2">
                <h3>Attached Gallery</h3>
                <h4> [upg-attach]</h4>
                This will display gallery with form to the specific page/post where this shortcode is inserted.<br>
                Picture/Video submitted at this page will not be visible at other post.
                <hr>
                <b>Notes:</b>
                <ol>
                    <li>This shortcode will use ajax. It cannot be altered. </li>
                    <li>'Load More' Button is available only to this. No page navigation is required.</li>
                    <li>Gallery layout is based on the UPG settings. It cannot be altered by shortcode.</li>
                    <li>If you want to display all gallery <code>[upg-attach]</code> in one place, use <code>[upg-list]</code> shortcode. </li>
                    <li>Parameters are case sensitive. Write all in lowercase.</li>
                </ol>
                <h4>Available Attributes:</h4>
                The following attributes are available to use in conjunction with the <code>[upg-attach]</code> shortcode.
                They have been split into sections for primary function for ease of navigation, with examples below.
                <br>

                <div class="update-nag">
                    <ul>
                        <li> <code>type="image"</code> - image is default type & it will display submission form for image only.</li>
                        <li> <code>type="embed"</code> - It will display form to submit youtube, vimeo, facebook, dailymotion and other URL.</li>
                        <li> <code>form_layout</code> = "Form template name" - Here layout is only used for submission form. <br>It will not have any affect on gallery layout. <br>You can find available layouts at 'layout editor'</li>
                        <li> <code>preview</code> = "Preview template name " - When form is submitted, it will assign a 'preview layout' to the post. <br>If not specified it will use default UPG settings. <br> If lightbox is enabled, the preview page is not required. <br>You can find available layouts at 'layout editor' </li>
                        <li> <code>button</code> = "on | off" - When off, post button is displayed only to user with editing rights.</li>
                        <li> <code>gallery_layout</code> = "Gallery template name" - Each gallery can have their own type of layout.</li>
                        <li> <code>popup</code> = "on | off" - The post when clicked will have a popup box instead going to another page.</li>
                        <li><code>private</code>="on | off" - If 'off', the submitted post will visible at [upg-list].</li>

                    </ul>
                </div>
            </div>



            <div id="tab-3">
                <h3>Built in Submission Form</h3>
                <h4> [upg-post]</h4>
                The front End submission form for image/video url is created as soon as you activate UPG plugin.
                You can make your own submission form by inserting the shortcode below into content area of a page or post.
                <hr>
                <b>Notes:</b>
                <ol>
                    <li>If only <code>[upg-post]</code> is used, it will use UPG settings.</li>
                    <li>Some form are ready to use, and it continuously compatible with latest version. </li>
                    <li>You can create your own form using 'layout editor'. The concept used is, editing the existing form to generate own 'personal layout'.</li>
                    <li>If you created your own form, use form layout as 'personal'.</li>
                    <li>Even after update, the created form won't be lost. It is copied at wordpress default upload folder. </li>
                    <li>You can add more custom fields, which needs to get enabled at 'UPG Advance Settings'.</li>
                </ol>
                <h4>Available Attributes:</h4>
                The following attributes are available to use in conjunction with the <code>[upg-post]</code> shortcode.
                They have been split into sections for primary function for ease of navigation, with examples below.
                <br>

                <div class="update-nag">
                    <ul>
                        <li> <code>type="image"</code> - It will display submission form for image only.</li>
                        <li> <code>type="embed"</code> - It will display submission form for oEmbed URL only.</li>
                        <li> <code>layout</code> = "Form template name" - It will change the design/layout for the submission form. Use <code>layout="personal"</code> if you have created your own form layout.</li>
                        <li> <code>preview</code> = "Preview template name" - When image/post/video are clicked, a page is opened which is called 'preview layout'. <br>This layout is not activated if popup is enabled in <code>[upg-list] or [upg-attach]</code>.</li>
                        <li> <code>form_name</code> = "any_form_name" - Sometime when there are multiple form on same page, the form may not work properly. <br>So it's better to differentiate form with their name.</li>
                        <li> <code>ajax</code> = "true | false" - If true , it will convert current form into ajax form. No page is changed after form submitted.</li>
                        <li> <code>login</code> = "true | false" - If true, only logged in user can view the submission form.</li>

                    </ul>
                </div>
            </div>


            <div id="tab-4">
                <h3>Create form with help of Shortcodes</h3>
                <h4> [upg-form] </h4>
                You can generate your own form with the help of shortcode.
                <code>[upg-post]</code> will use ready layouts whereas with this you can make your own.
                It is best suited for them, who don't have good php knowledge.
                If you are good at php/css, I recommend you to use <code>[upg-post]</code> with 'personal layout'.
                <br><br>
                The explanation and scope is very huge. Hence <b><a href="https://odude.com/upg-user-post-gallery/upg-form/" target="_blank" class="install-now button">Click here</a></b> for more details.
                <br><br>
                <b>Notes:</b>
                <ol>

                    <li class="page_item">This form cannot be used as 'form layout'.</li>
                    <li>This form is generated with the help of two shortcodes <code>[upg-form] & [upg-form-tag]</code></li>
                    <li><code>[upg-form-tag]</code> should always be between <code>[upg-form] .... [/upg-form]</code></li>
                    <li>This form is only for submit, it cannot be used for edit/modify form. </li>
                    <li>Form will always use Ajax. It will not redirect the page.</li>
                </ol>
                <h4>Scenario 1 – Form to submit into UPG</h4>

                <code>
                    [upg-form class="pure-form pure-form-stacked" title="Submit to UPG" name="my_form" taxonomy="upg_cate" tag_taxonomy="upg_tag"]
                    <br>
                    [upg-form-tag type="post_title" title="Title" value="" placeholder="main title"]
                    <br>
                    [upg-form-tag type="category" title="Select category" taxonomy="upg_cate" ]
                    <br>
                    [upg-form-tag type="tag" title="Insert tag"]
                    <br>
                    [upg-form-tag type="article" title="Description" placeholder="Content Plz"]
                    <br>
                    [upg-form-tag type="file" title="Select file"]
                    <br>
                    [upg-form-tag type="submit" name="submit" value="Submit Now"]
                    <br>
                    [/upg-form]

                </code>

                <h4>Scenario 2 - Form to submit post into WordPress. </h4>
                <code>
                    [upg-form class="pure-form pure-form-stacked" title="Submit to Wordpress" name="my_form" post_type="wp_post" taxonomy="category" tag_taxonomy="post_tag"]
                    <br>
                    [upg-form-tag type="post_title" title="Title" value="" placeholder="main title"]
                    <br>
                    [upg-form-tag type="category" title="Select category" taxonomy="category" ]
                    <br>
                    [upg-form-tag type="tag" title="Insert tag"]
                    <br>
                    [upg-form-tag type="article" title="Description" placeholder="Content Plz"]
                    <br>
                    [upg-form-tag type="file" title="Select file"]
                    <br>
                    [upg-form-tag type="submit" name="submit" value="Submit Now"]
                    <br>
                    [/upg-form]
                </code>

                <h4>Scenario 3 - Post YouTube greetings video via 'ODude ECard' plugin</h4>
                <code>
                    [upg-form class="pure-form pure-form-stacked" title="Upload Ecard" name="my_ecard" taxonomy="upg_cate" tag_taxonomy="upg_tag" post_type="video_url" preview="ecard"]
                    <br>
                    [upg-form-tag type="post_title" title="Title" value="" placeholder="main title"]
                    <br>
                    [upg-form-tag type="category" title="Select category" taxonomy="category" ]
                    <br>
                    [upg-form-tag type="tag" title="Insert tag"]
                    <br>
                    [upg-form-tag type="video_url" title="Insert YouTube URL" placeholder="http://" required="true"]
                    <br>
                    [upg-form-tag type="submit" name="submit" value="Submit Ecard"]
                    <br>
                    [/upg-form]
                </code>


            </div>


            <div id="tab-5">
                <h3>Modify/Edit Submitted Post</h3>
                <h4> [upg-edit]</h4>
                If you want, a regular visitor and wanted to edit the submitted post then use shortcode <code> [upg-edit]</code> on a page.<br>
                Don't forget to select that edit page in your UPG settings.
                <hr>
                <b>Notes:</b>
                <ol>
                    <li><b>It is available only to UPG-PRO version.</b></li>
                    <li>It is only accessible to loggedin users.</li>
                    <li>If in settings, edit button is enabled, user can edit the post.</li>
                    <li>Ajax modification is not available on this form.</li>
                    <li>You can have submission form different then edit form. This way you can add/remove some fields.</li>
                </ol>
                <h4>Available Attributes:</h4>
                The following attributes are available to use in conjunction with the <code>[upg-edit]</code> shortcode.
                <br>
                <div class="update-nag">
                    <ul>
                        <li> <code>layout</code> = "Form template name" - It will change the design/layout for the submission form. Use <code>layout="personal"</code> if you have created your own form layout.</li>
                        <li> <code>preview</code> = "Preview template name" - When image/post/video are clicked, a page is opened which is called 'preview layout'. <br>This layout is not activated if popup is enabled in <code>[upg-list] or [upg-attach]</code>.</li>
                    </ul>
                </div>
                <h4>Scenario 1 – Display 'Edit Form' with 'simple form layout'</h4>
                <code>[upg-edit layout="simple"]</code>
            </div>


            <div id="tab-6">

                <h3>Pick a Post</h3>
                <h4> [upg-pick]</h4>
                With the help of this shortcode, you can select any one UPG post and display it anywhere you like sidebar.
                <b>Notes:</b>
                <ol>
                    <li>More attributes will come soon. It is still under development.</li>
                </ol>

                <h4>Available Attributes:</h4>
                <div class="update-nag">
                    <ul>
                        <li> <code>id</code> = "UPG's Post ID" - Numeric post id of the UPG POST. This you can get from UPG list page looking at it's URL. POST={ID}</li>
                        <li><code>notice</code> = "Any text" - You can keep any extra text with image. Eg. Sale, Featured</li>
                        <li><code>layout</code>= "Gallery template Name" -It's a same as on <code>[upg-list]</code> layout.</li>
                        <li><code>popup</code>= "on | off" - If on, it will popup the post ignoring the 'preview layout'</li>
                    </ul>
                </div>
                <hr>
                <h4>Scenario 1 – Display UPG POST whose id is '44' and display as 'SALE'</h4>
                <code>[upg-pick id='44' notice='SALE']</code>

            </div>


            <div id="tab-7">

                <h3>Search UPG Post</h3>
                <h4> [upg-search]</h4>
                With this shortcode, user can search through the gallery. <br><br>
                <b>Notes:</b>
                <ol>
                    <li><b>It is available only to UPG-PRO version.</b></li>
                    <li>It will not work for <code>[upg-attach]</code> page.</li>
                    <li>UPG main page is used for search which is indicated at setting page.<br>
                        All parameters (layout, popup, etc.) applied on main page <code>[up-list]</code>is used. </li>
                    <li>Redesign search bar is not available. It is wrapped between div class "upg_search_bar".<br>
                        Using "pure-form" class in form tag.</li>
                </ol>

                <hr>
                <h4>Scenario 1 – Display search bar above gallery</h4>
                Just insert a shortcode before gallery shortcode.<br>
                <div class="update-nag"><code>[upg-search]<br>[upg-list]</code></div>
            </div>
            <div id="tab-8">

                <h3>List Album</h3>
                <h4> [upg-album]</h4>
                With this shortcode, you can list album/categories just above the gallery [upg-list] <br><br>
                <b>Notes:</b>
                <ol>
                    <li>It should be placed at the 'main upg page'.</li>
                    <li>It will work on other pages but will not list the post.</li>
                    <li>Try to match the parameter assigned in [upg-list]</li>
                </ol>

                <h4>Available Attributes:</h4>
                The following attributes are available to use in conjunction with the [upg-album] shortcode.
                They have been split into sections for primary function for ease of navigation.
                <br>

                <div class="update-nag">
                    <ul style="list-style-type:circle;">
                        <li> <code>filter</code> = "image or embed" - It will filter the categories based on the selection of album settings.</li>
                        <li> <code>class</code> = "css class name" - It will change the default class name used. ie. upg_album_container.</li>
                        <li> <code>perrow</code> = "number of column" - Number of column the album to display. It is by default to 1, if open in mobile browser.</li>
                        <li> <code>count</code> = "show | hide" - If show, counts number of post into album</li>
                        <li><code>root </code> = "show | hide " - If set to [upg-album root="hide"] at upg main page, it will hide the starting root categories. Specially used if [upg-album] is in different page. </li>
                    </ul>
                </div>

                <hr>
                <h4>Scenario 1 – Display album just above gallery</h4>
                Just insert a shortcode [upg-album] in main UPG page assigned in settings.<br>
                <div class="update-nag"><code>[upg-album]<br>[upg-list]</code></div>

                <h4>Scenario 2 – Display albums assigned for embed only</h4>
                Create new new page, insert a shortcode <code>[upg-album filter="embed"]</code><br>

            </div>
            <div id="tab-9">
                <h3>Display breadcrumb navigation at UPG page</h3>
                <h4> [upg-breadcrumb]</h4>
                With this shortcode, user can see breadcrumb navigation above gallery <br><br>
                <b>Notes:</b>
                <ol>
                    <li><b>It is available only to UPG-PRO version.</b></li>
                    <li>UPG main page is used as primary.</li>
                    <li>Redesign search bar is not available yet. </li>
                    <li>Developer can use special upg_show_breadcrumb() and pass css arguments to maintain look and feel.</li>
                </ol>

                <hr>
                <h4>Scenario 1 – Display navigation bar above gallery</h4>
                Just insert a shortcode before gallery shortcode.<br>
                <div class="update-nag"><code>[upg-breadcrumb]<br>[upg-list]</code></div>
            </div>
            <div id="tab-10">
                <h3>Display Data in tabular format.</h3>
                <h4> [upg-datatable]</h4>
                With this shortcode, user can see upg post and thumbnails will be hidden. <br><br>
                <b>Notes:</b>
                <ol>
                    <li>Best for huge database. Eg. More then 50,000+ records.</li>
                    <li>Complete ajax powered.</li>
                    <li>Powered by datatables.net</li>
                    <li>Ability to show records from custom post type. Eg. For woocommerce use post_type="product"</li>
                </ol>

                <hr>
                <div class="update-nag">
                    <ul style="list-style-type:circle;">
                        <li> <code>post_type</code> = "Custom Post Type" - 'upg' is default. For Wordpress post use 'wp_post'</li>
                        <li> <code>name</code> = "Table ID" - It will assign unique table name. Required if multiple table on same page.</li>
                        <li> <code>export</code> = "on | off" - It will show export buttons.
                            <ul style="list-style-type:disc;margin-left: 50px;">
                                <li> copy: Copy to Clipboard</li>
                                <li> csv: Save table to a CSV file</li>
                                <li> excel: Save table to an Excel (.xlsx) file</li>
                                <li> pdf: Save table to a PDF file</li>
                                <li> print: Show a Print view and dialog for the table</li>
                            </ul>
                        </li>
                        <li> <code>field</code> = "Label:Function_name:Parameter1:Parameter2:Parameter3" - Use own label and function. Separate with comma for multiple fields.
                            <ul style="list-style-type:disc;margin-left: 50px;">
                                <li> Label - Table Column Name</li>
                                <li> Function_name: Php function name. If not available create your own at theme's function.php</li>
                                <li> Parameter1: Text parameter function's first attribute</li>
                                <li> Parameter2: Text parameter function's second attribute</li>
                                <li> Parameter3: Text parameter function's third attribute</li>
                            </ul>
                        </li>
                    </ul>

                </div>
                <hr>
                <h4>Scenario 1 – Display wordpress post</h4>
                Image, Title, Author, Date column is displayed. Each column have own php functions.<br>
                <div class="update-nag"><code>[upg-datatable name="wp_post" post_type="wp_post" field="Title: upg_get_title:wp_post , Author:upg_author , Date:get_the_date"]</code></div>

                <hr>
                <h4>Scenario 2 – Display UPG post</h4>
                Title & Date column is displayed + UPG custom fields enabled for frontend in settings.<br>
                <div class="update-nag"><code> [upg-datatable field="Title: upg_get_title, Date:get_the_date "]</code></div>
            </div>


        </div>
    <?php
    }
    ?>