	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.demo-pages.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.core.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.pagination-bundle.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.history-bundle.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.textbox-filter.min.css'; ?>" rel="stylesheet" type="text/css">
	<link href="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.list-grid-view.min.css'; ?>" rel="stylesheet" type="text/css">

	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.core.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.history-bundle.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.jquery-ui-bundle.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.pagination-bundle.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.sort-bundle.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.textbox-filter.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jplist.list-grid-view.min.js'; ?>"></script>
	<script src="<?php echo plugins_url() . '/' . upg_FOLDER . '/layout/grid/filter/res/jquery.lazyload.min.js'; ?>"></script>
	<script>
		jQuery('document').ready(function() {

			jQuery('#demo').jplist({

				//main options
				itemsBox: '.list',
				itemPath: '.list-item',
				panelPath: '.jplist-panel'

					//save plugin state
					,
				storage: 'localstorage' //'', 'cookies', 'localstorage'			
					,
				storageName: 'views'

					//this code occurs on every jplist action
					,
				redrawCallback: function(collection, $dataview, statuses) {

					//init lazy load on a filtered set of elements
					jQuery('.list-item img').lazyload();
				}
			});
		});
	</script>




	<div class="box">
		<div class="center">



			<div class="box text-shadow">


				<!-- demo -->
				<div id="demo" class="box jplist jplist-list-view">

					<!-- ios button: show/hide panel -->
					<div class="jplist-ios-button">
						<i class="fa fa-sort"></i>
						<?php echo __('Controls', 'wp-upg'); ?>
					</div>

					<!-- panel -->
					<div class="jplist-panel box panel-top">

						<!-- reset button -->
						<button type="button" class="jplist-reset-btn" data-control-type="reset" data-control-name="reset" data-control-action="reset">
							&nbsp;<i class="fa fa-share"></i>
						</button>

						<div class="jplist-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging">
							<div class="jplist-dd-panel"> 10 <?php echo __('per page', 'wp-upg'); ?></div>
							<ul style="display: none;">
								<li class=""><span data-number="5"> 5 <?php echo __('per page', 'wp-upg'); ?> </span></li>
								<li class="active"><span data-number="10" data-default="true"> 10 <?php echo __('per page', 'wp-upg'); ?> </span></li>
								<li><span data-number="15"> 15 <?php echo __('per page', 'wp-upg'); ?> </span></li>
								<li><span data-number="all"> <?php echo __('View All', 'wp-upg'); ?> </span></li>
							</ul>
						</div>

						<div class="jplist-drop-down" data-control-type="sort-drop-down" data-control-name="sort" data-control-action="sort">
							<div class="jplist-dd-panel"><?php echo __('Date asc', 'wp-upg'); ?></div>
							<ul style="display: none;">
								<li class="active"><span data-path="default"><?php echo __('Sort by', 'wp-upg'); ?></span></li>
								<li><span data-path=".title" data-order="asc" data-type="text"><?php echo __('Title A-Z', 'wp-upg'); ?></span></li>
								<li><span data-path=".title" data-order="desc" data-type="text"><?php echo __('Title Z-A', 'wp-upg'); ?></span></li>
								<li><span data-path=".date" data-order="asc" data-type="datetime"><?php echo __('Date asc', 'wp-upg'); ?></span></li>
								<li><span data-path=".date" data-order="desc" data-type="datetime"><?php echo __('Date desc', 'wp-upg'); ?></span></li>
							</ul>
						</div>

						<!-- filter by title -->
						<div class="text-filter-box">

							<i class="fa fa-search  jplist-icon"></i>

							<!--[if lt IE 10]>
			<div class="jplist-label"><?php echo __('Filter by Title', 'wp-upg'); ?>:</div>
			<![endif]-->

							<input data-path=".title" type="text" value="" placeholder="<?php echo __('Filter by Title', 'wp-upg'); ?>" data-control-type="textbox" data-control-name="title-filter" data-control-action="filter">
						</div>

						<!-- filter by description -->
						<div class="text-filter-box">

							<i class="fa fa-search  jplist-icon"></i>

							<!--[if lt IE 10]>
			<div class="jplist-label"><?php echo __('Filter by Description', 'wp-upg'); ?></div>
			<![endif]-->

							<input data-path=".desc" type="text" value="" placeholder="<?php echo __('Filter by Description', 'wp-upg'); ?>" data-control-type="textbox" data-control-name="desc-filter" data-control-action="filter">
						</div>

						<!-- views -->
						<div class="jplist-views" data-control-type="views" data-control-name="views" data-control-action="views" data-default="jplist-grid-view">

							<button type="button" class="jplist-view jplist-list-view" data-type="jplist-list-view"></button>
							<button type="button" class="jplist-view jplist-grid-view" data-type="jplist-grid-view"></button>
							<button type="button" class="jplist-view jplist-thumbs-view" data-type="jplist-thumbs-view"></button>
						</div>

						<!-- pagination results -->
						<div class="jplist-label" data-type="Page {current} of {pages}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">Page 1 of 4</div>

						<!-- pagination -->
						<div class="jplist-pagination" data-control-type="pagination" data-control-name="paging" data-control-action="paging">
							<div class="jplist-pagingprev jplist-hidden" data-type="pagingprev"><button type="button" class="jplist-first" data-number="0" data-type="first" data-active="true">«</button><button type="button" class="jplist-prev" data-type="prev" data-number="0" data-active="true">‹</button></div>
							<div class="jplist-pagingmid" data-type="pagingmid">
								<div class="jplist-pagesbox" data-type="pagesbox"><button type="button" data-type="page" class="jplist-current" data-active="true" data-number="0">1</button> <button type="button" data-type="page" data-number="1">2</button> <button type="button" data-type="page" data-number="2">3</button> <button type="button" data-type="page" data-number="3">4</button> </div>
							</div>
							<div class="jplist-pagingnext" data-type="pagingnext"><button type="button" class="jplist-next" data-type="next" data-number="1">›</button><button type="button" class="jplist-last" data-type="last" data-number="3">»</button></div>
						</div>

					</div>

					<!-- data -->
					<div class="list box text-shadow">