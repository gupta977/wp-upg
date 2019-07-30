/* Initialize jQuery Colorbox*/
jQuery(function ($) {

  jQuery('a.wp-upg').colorbox({ scalePhotos: true, innerWidth: "80%", innerHeight: "80%", rel: 'wp-upg' });
  jQuery(".inline").colorbox({ inline: true, width: "50%", rel: 'wp-upg' });
  jQuery(".youtube").colorbox({ iframe: true, innerWidth: "80%", innerHeight: "80%", rel: 'wp-upg' });
  jQuery(".vimeo").colorbox({ iframe: true, innerWidth: "80%", innerHeight: "80%", rel: 'wp-upg' });
  jQuery(".ajax").colorbox({ scalePhotos: true, innerWidth: "50%", innerHeight: "50%", rel: 'wp-upg' });
});

