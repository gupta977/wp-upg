jQuery(function ($) {

  jQuery(".filter_tag").click(function () {


    var $imgs = $('#upg_gallery .upg_gallery_child');   // Store all images
    var tagged = {};                                // Create tagged object

    $imgs.each(function () {                         // Loop through images and
      var img = this;                               // Store img in variable
      var tags = $(this).data('tags');              // Get this element's tags

      if (tags) {                                   // If the element had tags
        tags.split(',').forEach(function (tagName) { // Split at comma and

          if (tagged[tagName] == null) {            // If object doesn't have tag
            tagged[tagName] = [];                   // Add empty array to object
          }
          tagged[tagName].push(img);                // Add the image to the array
        });
      }
    });

    var pos = $(this).attr("id");

    //alert("ID: " + pos);

    if (pos == 'show_all') {
      //alert("show all");
      $(".active").removeClass("active");
      $(this).addClass('active');
      $imgs.hide().fadeIn(500);
    }
    else {

      $(".active").removeClass("active");
      $(this).addClass('active');                      // Make clicked item active



      $imgs                                      // With all of the images
        .hide()                                  // Hide them
        .filter(tagged[pos])                 // Find ones with this tag
        .fadeIn(500);

    }

  });

});