<?php
if ($count == 0)
  echo '<div id="upg_no_record">' . __('No records', 'wp-upg') . '</div>';
?>
</div>

<script type="text/javascript" src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/slide/slick/slick.min.js'; ?>"></script>

<script type="text/javascript">
  jQuery(document).ready(function() {

    //alert("hello");
    jQuery('.upg_slide_<?php echo $list_name; ?>').slick({
      slidesToShow: <?php echo $perrow; ?>,
      <?php echo $slide_param; ?>

    });
  });
</script>