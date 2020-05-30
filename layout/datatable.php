<?php
//DATA UPG post.
//WP-Query is at wp-upg upg_datatable()
if (is_single() || is_page()) {

 //Pass table heading with php function name
 if (isset($params['field'])) {
  $field = $params['field'];
 } else {
  $field = "Image:upg_get_thumbnail, Title:upg_get_title, Author:upg_author, Date:get_the_date";
 }

 //Add label as function into array
 $label = array();

 $values = explode(',', $field);
 foreach ($values as $option) {
  $cap = explode(":", $option);

  array_push($label, trim($cap[0]));
 }

 //print_r($label);

 //Display export buttons
 if (isset($params['export'])) {
  $upg_export = $params['export'];
 } else {
  $upg_export = "on";
 }

 //Default post_type

 if (isset($params['post_type'])) {
  $post_type = $params['post_type'];
 } else {
  $post_type = "upg";
 }

 //For wordpress posts
 if ('wp_post' == $post_type) {
  $post_type = '';
 }

 //Table ID
 if (isset($params['name'])) {
  $upg_table = $params['name'];
 } else {
  $upg_table = "upg_table_id";
 }

 ob_start();
 ?>

    <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css?' . UPG_PLUGIN_VERSION; ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/pdfmake.min.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/vfs_fonts.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script>
        jQuery(document).ready(function() {
            var datatable_url = myAjax_datatable.ajaxurl + "&field=<?php echo $field; ?>&post_type=<?php echo $post_type; ?>";
            jQuery('#<?php echo $upg_table; ?>').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "rowId": 'id',
                "ajax": datatable_url,

                <?php

 if ("on" == $upg_export) {
  echo ' "dom": \'Bflrtip\',';
  echo '"buttons":
                        ["copy", "csv", "pdf", "excel",
                            {
                            extend: "print",
                                exportOptions:
                                {
                                    stripHtml: true
                                }
                            }
                        ],';
 }

 ?>

                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
            });
        });
    </script>
    <table id="<?php echo $upg_table; ?>" class="display">
        <thead>
            <tr>

                <?php
for ($x = 0; $x < count($label); $x++) {

  ?>
                    <th><?php echo $label[$x]; ?></th>
                <?php

 }
 ?>

                <?php
if ('upg' == $post_type) {
  for ($x = 1; $x <= 5; $x++) {
   if ('on' == $options['upg_custom_field_' . $x . '_show_front']) {

    ?>
                            <th><?php echo upg_get_filed_label('upg_custom_field_' . $x); ?></th>

                <?php
}
  }
 }
 ?>
            </tr>
        </thead>

    </table>
<?php

 return ob_get_clean();
}
