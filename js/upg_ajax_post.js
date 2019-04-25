jQuery(document).ready(function () {

    jQuery('.upg_ajax_post').on('submit', function (e) {
        e.preventDefault();
        //post_id = jQuery(this).attr("data-post_id")
        //nonce = jQuery(this).attr("data-nonce")
        var form = jQuery('#upg-request-form')[0];
        var formData = new FormData(form);
        //alert("start");

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function () {
                //alert("about to send");
                jQuery("#upg_form").slideUp();
                jQuery("#upg_loader").show();
            },
            success: function (response) {
                if (response.type == "success") {

                    jQuery('.upg_response').empty();
                    jQuery('.upg_response').append(response.msg);
                    jQuery('#load_more_reset').click();
                    //jQuery('.upg_response').append(response);
                    console.log(response);

                }
                else {
                    jQuery('.upg_response').append(response.msg);
                }
            },
            complete: function (data) {
                // Hide image container
                jQuery("#upg_loader").hide();
            }
        })

    })

})