<?php
if($count==0)
echo '<div>'.__('No records were found matching your selection','wp-upg').'</div>';
?>
</div>

<script type="text/javascript" src="<?php echo plugins_url() .'/'. upg_FOLDER.'/layout/grid/slide/slick/slick.min.js'; ?>"></script>

<script type="text/javascript">
  jQuery(document).ready(function () {

      //alert("hello");
      jQuery('.upg_slide_<?php echo $list_name; ?>').slick({
        slidesToShow: <?php echo $perrow; ?>,
       <?php echo $slide_param; ?>
        
      });
  });
</script>