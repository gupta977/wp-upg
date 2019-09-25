jQuery(document).ready(function() {
  jQuery(".upg_delete").click(function(e) {
    e.preventDefault();
    post_id = jQuery(this).attr("data-post_id");
    nonce = jQuery(this).attr("data-nonce");

    var x = confirm(myAjax.delete_string);
    if (x) {
      jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "upg_delete", post_id: post_id, nonce: nonce },
        success: function(response) {
          if (response.type == "success") {
            //jQuery("#upg_"+post_id).html(response.data_count)
            jQuery("#upg_" + post_id).slideUp();
          } else {
            alert("Deleted: " + post_id);
          }
        }
      });
    }
  });
});
