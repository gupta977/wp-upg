//Toggle submission form
jQuery(document).ready(function() {
  jQuery("#upg_submit_form").click(function(e) {
    jQuery("#upg_toggle_form").slideToggle("slow");
  });
});

//Load more button
jQuery(document).ready(function() {
  var paged = 1;

  jQuery(".upg_load_more").click(function(e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    gallery_layout = jQuery(this).attr("gallery_layout");
    popup = jQuery(this).attr("popup");
    max_paged = jQuery(this).attr("data-paged");
    reset = jQuery(this).attr("data-reset");

    if (reset == "true") {
      paged = 1;
      jQuery("#upg_main_loop").empty();
    }

    jQuery.ajax({
      type: "post",
      dataType: "json",
      url: myAjax.ajaxurl,
      data: {
        action: "upg_load_more",
        post_id: post_id,
        paged: paged,
        gallery_layout: gallery_layout,
        popup: popup
      },
      beforeSend: function() {
        //alert("about to send");
        jQuery("#upg_load_more").slideUp();
        jQuery("#upg_loader").show();
      },
      success: function(response) {
        jQuery("#upg_main_loop").append(response.msg);
        paged++;

        //alert(max_paged + "--" + paged);
      },
      complete: function(data) {
        // Hide image container
        jQuery("#upg_loader").hide();
        jQuery("#upg_load_more").slideDown();
        jQuery("#upg_no_record").hide();
        // alert("response complete");
        if (paged > max_paged) jQuery("#upg_load_more").slideUp();
      }
    });
  });
});
