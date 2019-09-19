<?php
//DATA UPG post.
//WP-Query is at wp-upg upg_datatable()
if (is_single() || is_page()) {

    ob_start();
    ?>

    <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js'; ?>"></script>
    <script>
        jQuery(document).ready(function() {
            jQuery('#table_id').DataTable({
                "processing": true,
                "serverSide": true,
                rowId: 'id',
                "ajax": myAjax_datatable.ajaxurl,
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }],
            });
        });
    </script>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th class="no-sort">Picture</th>
                <th>Title</th>
                <th>Date</th>
                <th class="no-sort">Action</th>
            </tr>
        </thead>

    </table>
<?php

    return ob_get_clean();
}
