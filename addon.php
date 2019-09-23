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



        <li><a href="#tab-1"><?php echo __("UPG Plugins", "wp-upg"); ?></a></li>
        <li><a href="#tab-2"><?php echo __("UPG Help", "wp-upg"); ?></a></li>
      </ul>
      <div id="tab-1">

        <div class="upg_module upg_red">
          <h2> <?php _e('Breadcrumb', 'wp-upg'); ?> <a href="http://odude.com/product/wp-upg-pro/">UPG PRO </a></h2>
          <div class="cnt">
            <p>You can include breadcrumb navigation bar above gallery using shortcode. <br>Use shortcode as [upg-bread-crumb] just above [upg-list] of main upg page.<br>It will will automatically appear above gallery.<br>
              <br><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/breadcrumb.png"> '; ?>

            </p>
          </div>
        </div>
        <div class="upg_module upg_red">
          <h2> <?php _e('Search', 'wp-upg'); ?> <a href="http://odude.com/product/wp-upg-pro/">UPG PRO </a></h2>
          <div class="cnt">
            <p>You can include search bar above gallery using shortcode. <br>Use shortcode as [upg-search] at widgets or anywhere.<br>It will serach and search bar will automatically appear above gallery.<br>
              <br><?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/search.png"> '; ?>
            </p>
          </div>
        </div>

        <div class="upg_module upg_green">
          <h2>Popup Form Button <a href="<?php echo admin_url("plugin-install.php?tab=plugin-information&plugin=listpress"); ?>">ListPress</a></h2>
          <div class="cnt">
            <p>Dynamically place popup form button at preview page. <br>It can be used for several proposes. Eg. Report Spam, Make Inquiry, Send Feedback buttons.<br>
              It also has option to send message to post's author.
              <br>
              <br>
              <a href="https://wordpress.org/plugins/listpress/" target="_blank" class="install-now button">View Details</a>
            </p>
          </div>
        </div>


        <div class="upg_module upg_red">
          <h2>Page Redirect <a href="http://odude.com/product/wp-upg-pro/">UPG PRO </a></h2>
          <div class="cnt">
            <p>Page can be redirect to the desired page after the form is submitted by user.
              <br> <br>
              <?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/redirect.png" width="500"> '; ?>

            </p>
          </div>
        </div>

        <div class="upg_module upg_red">
          <h2> Bulk Image Post <a href="http://odude.com/product/wp-upg-pro/">UPG PRO </a></h2>
          <div class="cnt">
            <p>Multiple images can be submitted at same time from the front end. <br> It can also restrict number of images to be uploaded at once.
              <br> <br>
              <br>
              <a href="http://odude.com/product/wp-upg-pro/" target="_blank" class="install-now button">View Details</a>
            </p>
          </div>
        </div>

        <div class="upg_module upg_blue">
          <h2>UPG Album List <a href="<?php echo admin_url("widgets.php"); ?>">Widgets Installed </a></h2>
          <div class="cnt">
            <p>This will list Album/categories of UPG (User Post Gallery).<br>
              The album marked hidden will not be listed.
              <br> <br>
            </p>
          </div>
        </div>

        <div class="upg_module upg_green">
          <h2>Page Navigation <a href="<?php echo admin_url("plugin-install.php?tab=plugin-information&plugin=wp-pagenavi"); ?>">WP-PageNavi</a></h2>
          <div class="cnt">
            <p>Page navigation for Image, Youtube, Vimeo, Post Gallery. It is displayed if the number of images per-page is exceeded.
              <br> <br>
              <?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/pagenavi.png" width="500"> '; ?>
              <br>
              <a href="<?php echo "https://wordpress.org/plugins/wp-pagenavi/"; ?>" target="_blank" class="install-now button">View Details</a></p>
          </div>
        </div>
        <hr>
        <div class="upg_module upg_red">
          <h2>Captcha security <a href="http://odude.com/product/wp-upg-pro/">UPG PRO</a></h2>
          <div class="cnt">
            <p>

              Captcha: <b>Google reCaptcha V2 </b> so that spammers need to pass security check before posting images & Videos to wp-upg plugins.
              <br> <br>
              <?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/captcha.png" > '; ?>
              <br><br>
              <a href="http://odude.com/product/wp-upg-pro/" target="_blank" class="install-now button">View Details</a></p>
          </div>
        </div>
        <hr>
        <div class="upg_module upg_red">
          <h2>Email notification <a href="http://odude.com/product/wp-upg-pro/">UPG PRO</a></h2>
          <div class="cnt">
            <p>
              Enables Email notification when content,image,youtube,vimeo video is uploaded

              <br>
              <?php echo '<img src="' . upg_PLUGIN_URL . '/images/extra/email_notify.png" > '; ?>
          </div>
        </div>


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