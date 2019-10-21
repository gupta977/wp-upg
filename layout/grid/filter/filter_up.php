    <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css?' . UPG_PLUGIN_VERSION; ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js?' . UPG_PLUGIN_VERSION; ?>"></script>
    <style>
        .upg_hover-zoom {
            -moz-transition: all 0.5s;
            -webkit-transition: all 0.5s;
            transition: all 0.5s;
        }

        .upg_hover-zoom:hover {
            -moz-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.5);
            border: 0;
        }
    </style>
    <script>
        jQuery(document).ready(function() {
            jQuery('#table_id').DataTable({
                "columnDefs": [{
                    "targets": 'no-sort',
                    "orderable": false,
                }]
            });
        });
    </script>
    <table id="table_id" class="display">
        <thead>
            <tr>
                <th class="no-sort" width="150px">&nbsp;</th>
                <th><?php echo __('Title', 'wp-upg'); ?></th>
                <?php
                for ($x = 1; $x <= 5; $x++) {
                    if ($options['upg_custom_field_' . $x . '_show_front'] == 'on') {

                        ?>
                        <th><?php echo upg_get_filed_label('upg_custom_field_' . $x); ?></th>

                <?php
                    }
                }
                ?>
                <th><?php echo __('Date', 'wp-upg'); ?></th>


            </tr>
        </thead>
        <tbody>