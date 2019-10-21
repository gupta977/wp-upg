<?php
//DATA UPG post.
//WP-Query is at wp-upg upg_datatable()
if (is_single() || is_page()) {

    //Thumbnail image to show="on" or hide="off"
    if (isset($params['image']))
        $upg_image = $params['image'];
    else
        $upg_image = "on";

    //Display export buttons
    if (isset($params['export']))
        $upg_export = $params['export'];
    else
        $upg_export = "on";

    //Table ID
    if (isset($params['name']))
        $upg_table = $params['name'];
    else
        $upg_table = "upg_table_id";

    ob_start();
    ?>

    <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css?' . UPG_PLUGIN_VERSION; ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/pdfmake.min.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/vfs_fonts.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <script>
        jQuery(document).ready(function() {
            var datatable_url = myAjax_datatable.ajaxurl + "&upg_image=<?php echo $upg_image; ?>";
            jQuery('#<?php echo $upg_table; ?>').DataTable({
                "processing": true,
                "serverSide": true,
                "responsive": true,
                "rowId": 'id',
                "ajax": datatable_url,
                dom: 'Bflrtip',
                <?php

                    if ($upg_export == "on") {
                        echo '"buttons": ["copy", "csv", "pdf", "excel", "print"],';
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
                    if ($upg_image == "on") {
                        echo '<th class="no-sort">Picture</th>';
                    }

                    ?>
                <th>Title</th>
                <?php
                    for ($x = 1; $x <= 5; $x++) {
                        if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {

                            ?>
                        <th><?php echo upg_get_filed_label('upg_custom_field_' . $x); ?></th>

                <?php
                        }
                    }
                    ?>
            </tr>
        </thead>

    </table>
<?php

    return ob_get_clean();
}
