<?php
//UPG addons and Help page

function upg_addon_page()
{
  ?>
  <div class="wrap">
    <?php
      do_action("upg_admin_top_menu");
      ?>
    <h2>UPG (User Post Gallery) Free & Premium Extensions</h2>

    <script>
      jQuery(document).ready(function($) {
        $("#tabs").tabs();
      });
    </script>
    <div id="tabs">
      <ul>



        <li><a href="#tab-1">UPG <?php echo __("Addons", "wp-upg"); ?></a></li>
        <li><a href="#tab-2">UPG <?php echo __("Help", "wp-upg"); ?></a></li>
      </ul>
      <div id="tab-1">


        <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
        <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js'; ?>"></script>
        <style>
          .upg_hover-zoom {
            -moz-transition: all 0.5s;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
          }

          .upg_hover-zoom:hover {
            -moz-transform: scale(3.5);
            -webkit-transform: scale(3.5);
            transform: scale(3.5);
            border: 0;
          }
        </style>
        <script>
          jQuery(document).ready(function() {
            jQuery('#table_id').DataTable({
              "columnDefs": [{
                "targets": 'no-sort',
                "orderable": false,
              }],
            });
          });
        </script>
        <table id="table_id" class="display">
          <thead>
            <tr>

              <th><?php echo __('Title', 'wp-upg'); ?></th>
              <th class="no-sort"><?php echo __('Description', 'wp-upg'); ?></th>
              <th>Type</th>
              <th class="no-sort">Links</th>

            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Filter Layout</td>
              <td>Data Table based on UPG post. Ability to show custom fields.</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/filter-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/filter/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Classic Layout</td>
              <td>Responsive 3 column gallery with custom fields.</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/classic-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/classic/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Slide Layout</td>
              <td>Slides/carousels horizontal post with [upg-list] shortcode.</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/slide-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/slide/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Photo Layout</td>
              <td>Best suited for photographers.<br>Masonry grid view and preview page with uploaded picture auto extracted exif information.</td>
              <td>Gallery/Preview Template</td>
              <td><a href="https://odude.com/demo/albums/gallery/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/photo/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>


            <tr>
              <td>Basic Layout</td>
              <td>UPG Post with basic grid layout.</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/basic-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/basic/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Flat Layout</td>
              <td>UPG Post without title. Shows title on hover of image.</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/flat-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/flat/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>List Layout</td>
              <td>UPG Post with title and short description. Options to display custom fields</td>
              <td>Gallery Template</td>
              <td><a href="https://odude.com/demo/albums/list-layout/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/grid/list/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Ecard Layout - Preview</td>
              <td>All UPG post can be converted into ecard system. Requires UPG Ecard Plugin.</td>
              <td>Preview Template</td>
              <td><a href="https://odude.com/demo/ecard/users-post-gallery/"><?php echo '<img src="' . upg_PLUGIN_URL . '/layout/media/ecard/screenshot.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Personal Layout</td>
              <td>This layout is designed by you at layout editor</td>
              <td>All Template</td>
              <td><a href="http://odude.com/demo/faq/upg/personal-layout/" class="install-now button">More Info</a></td>
            </tr>

            <tr>
              <td>Breadcrumb Navigation</td>
              <td>You can include breadcrumb navigation bar above gallery using shortcode. <br>Use shortcode as [upg-breadcrumb] just above [upg-list] of main upg page.<br>It will will automatically appear above gallery.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/" class="install-now button"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/breadcrumb.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Search UPG</td>
              <td>You can include search bar above gallery using shortcode. <br>Use shortcode as [upg-search] at widgets or anywhere.<br>It will search and search bar will automatically appear above gallery.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/search.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>



            <tr>
              <td>Page Redirect</td>
              <td>Page can be redirect to the desired page after the form is submitted by user.<br>Works only if ajax is turned off.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/redirect.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Bulk Image Post</td>
              <td>Multiple images can be submitted at same time from the front end. <br> It can also restrict number of images to be uploaded at once.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/" class="install-now button">Buy Now</a></td>
            </tr>

            <tr>
              <td>Album List Widgets</td>
              <td>This will list Album/categories of UPG (User Post Gallery).<br>
                The album marked hidden will not be listed.</td>
              <td>Inbuilt</td>
              <td><a href="<?php echo admin_url("widgets.php"); ?>" class="install-now button">Widgets Installed</a></td>
            </tr>



            <tr>
              <td>Captcha security</td>
              <td> Captcha: <b>Google reCaptcha V2 </b> so that spammers need to pass security check before form submission.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/captcha.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>Email notification</td>
              <td>Email notification when new upg post is submitted by visitors.</td>
              <td>UPG-PRO</td>
              <td><a href="http://odude.com/product/wp-upg-pro/"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/email_notify.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>

            <tr>
              <td>BuddyPress</td>
              <td>Displays tab on user profile page of BuddyPress plugin.<br>
                User avatar displayed on preview layout.<br>
                Link to login & profile page.</td>
              <td>Plugin</td>
              <td><a href="https://wordpress.org/plugins/buddypress/" class="install-now button">Check Details</a></td>
            </tr>
            <tr>
              <td>Ultimate-Member</td>
              <td>Displays tab on user profile page of BuddyPress plugin.<br>
                Restrict form & galleries for specified members.<br>
                User avatar displayed on preview layout.<br>
                Link to login & profile page.</td>
              <td>Plugin</td>
              <td><a href="https://wordpress.org/plugins/ultimate-member/" class="install-now button">Check Details</a></td>
            </tr>
            <tr>
              <td>Page Navigation</td>
              <td>Page navigation for [upg-list]. It is displayed, if the number of images per-page is exceeded.</td>
              <td>WP-PageNavi Plugin</td>
              <td><a href="https://wordpress.org/plugins/wp-pagenavi/" class="install-now button"><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/pagenavi.png" width="100px" class="upg_hover-zoom"> '; ?></a></td>
            </tr>
            <tr>
              <td>Contact Button</td>
              <td>Dynamically place popup form button at preview page. <br> Eg. Report Spam, Make Inquiry, Send Feedback buttons.<br>
                It also has option to send message to post's author.</td>
              <td>ListPress Plugin</td>
              <td><a href="https://wordpress.org/plugins/listpress/" class="install-now button">Check Details</a></td>
            </tr>
            <tr>
              <td>Regenerate Thumbnails</td>
              <td>allows you to regenerate all thumbnail sizes for one or more images that have been uploaded.<br>Specially required if you change media sizes.</td>
              <td>Plugin</td>
              <td><a href="https://wordpress.org/plugins/regenerate-thumbnails/" class="install-now button">Check Details</a></td>
            </tr>
          </tbody>
        </table>
        <hr>
        If you have designed your own UPG layout, functions, plugins which supports UPG. Mail me at navneet@odude.com. After review it will be listed here.

      </div>
      <div id="tab-2">
        <?php
          include(dirname(__FILE__) . "/help.php");
          ?>
      </div>
    </div>



  </div>

<?php
}
?>