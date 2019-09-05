jQuery(document).ready(function () {

    jQuery('.upg_ajax_post').on('submit', function (e) {
        e.preventDefault();
        //post_id = jQuery(this).attr("data-post_id")
        //nonce = jQuery(this).attr("data-nonce")
        var form = jQuery('#upg-request-form')[0];
        var formData = new FormData(form);
        var i = 0;
        var progress = true;
        //alert("start");

        jQuery.ajax({
            type: "post",
            dataType: "json",
            url: myAjax.ajaxurl,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            data: formData,
            xhr: function () {
                var jqXHR = null;
                if (window.ActiveXObject) {
                    jqXHR = new window.ActiveXObject("Microsoft.XMLHTTP");
                }
                else {
                    jqXHR = new window.XMLHttpRequest();
                }

                //Upload progress
                jqXHR.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                        //Do something with upload progress
                        //console.log('Uploaded percent', percentComplete);
                        document.getElementById("upg_progress").style.width = percentComplete + "%"; // width
                        document.getElementById("upg_progress").innerHTML = percentComplete + "%";

                        if (percentComplete > 90) {
                            setInterval(function () {
                                if (i < 100 && progress) {
                                    document.getElementById("upg_progress_process").style.width = i + "%";
                                    document.getElementById("upg_progress_process").innerHTML = i + "%";
                                    i++;
                                }
                                else {
                                    clearInterval(this);
                                }
                            }, 1000);
                        }

                    }
                }, false);
                //Download progress
                jqXHR.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = Math.round((evt.loaded * 100) / evt.total);
                        //Do something with download progress
                        //console.log('Downloaded percent', percentComplete);
                    }
                }, false);
                return jqXHR;
            },
            beforeSend: function () {
                //console.log("Send to UPG");
                jQuery("#upg_form").slideUp();
                jQuery("#upg_loader").show();
                i = 0;
                progress = true;
            },


            success: function (response) {

                if (response.type == "success") {
                    jQuery('.upg_response').show();
                    jQuery('.upg_response').empty();
                    jQuery('.upg_response').append(response.msg);
                    jQuery('#load_more_reset').click();
                    //jQuery('.upg_response').append(response);

                    console.log(response);


                }
                else {
                    //console.log("Blank Response");
                    jQuery('.upg_response').append(response.msg);
                }
            },
            complete: function (data) {
                // Hide image container
                //console.log("Submission completed");
                jQuery("#upg_loader").hide();
                jQuery('#upg_after_response').show();
                i = 0;
                progress = false;

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log("Error occurred");
                jQuery('.upg_response').show();
                jQuery('.upg_response').empty();
                jQuery('.upg_response').append("<div class='upg_error'>Error: " + errorThrown + "</div>");

            }
        })

    })

    jQuery(".upg_send_again").click(function (e) {
        e.preventDefault();
        //alert("hello");
        jQuery('#upg_after_response').hide();
        jQuery("#upg_form").slideDown();
        jQuery('.upg_response').empty();
        //jQuery('.upg_response').hide();

        document.getElementById("upg_progress").style.width = "0%"; // width
        document.getElementById("upg_progress_process").style.width = "0%";
        document.getElementById("upg_progress").innerHTML = "0%";
        document.getElementById("upg_progress_process").innerHTML = "0%";

    })

})