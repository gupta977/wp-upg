jQuery(function ($) {

  jQuery(".filter_tag").click(function () {


    var $imgs = $('#upg_gallery section');   // Store all images
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
      $(this)                                      // Get the clicked on button
        .addClass('active')                        // Add the class of active
        .siblings()                                // Get its siblings
        .removeClass('active');                    // Remove active from siblings
      $imgs.hide().fadeIn(500);
    }
    else {


      $(this)                                    // The button clicked on
        .addClass('active')                      // Make clicked item active
        .siblings()                              // Get its siblings
        .removeClass('active');                  // Remove active from siblings
      $imgs                                      // With all of the images
        .hide()                                  // Hide them
        .filter(tagged[pos])                 // Find ones with this tag
        .fadeIn(500);

    }

  });

});