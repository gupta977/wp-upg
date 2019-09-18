<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/data/assets/datatables.min.css'; ?>" rel="stylesheet" type="text/css">
<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/data/assets/datatables.min.js'; ?>"></script>
<script>
	jQuery(document).ready(function() {
		jQuery('#table_id').DataTable();
	});
</script>
<table id="table_id" class="display">
	<thead>
		<tr>
			<th>Column 1</th>
			<th>Column 2</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>A</td>
			<td>xxx</td>
		</tr>
		<tr>
			<td>B</td>
			<td>yyy</td>
		</tr>
	</tbody>
</table>