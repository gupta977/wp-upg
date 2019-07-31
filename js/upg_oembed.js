jQuery(document).ready(function () {



    oembed_url = jQuery(this).attr("data-oembed_url")
    nonce = jQuery(this).attr("data-nonce")

    jQuery.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajaxurl,
        data: { action: "upg_oembed", oembed_url: oembed_url, nonce: nonce },
        success: function (response) {
            if (response.type == "success") {
                console.log(response);

            }
            else {
                alert("This post is invalid");
            }
        }
    })



})