    <link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/css/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
    <script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/js/datatables.min.js'; ?>"></script>
	<script>
		jQuery(document).ready(function() {
            jQuery('#table_id').DataTable({
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
                <th class="no-sort" width="150px">Picture</th>
                <th>Title</th>
                <th>Date</th>
                <th class="no-sort">Action</th>
            </tr>
		</thead>
		<tbody>