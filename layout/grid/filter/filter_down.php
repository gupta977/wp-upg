</div>

<div class="box jplist-no-results text-shadow align-center jplist-hidden">
	<p><?php echo __('No records', 'wp-upg'); ?></p>
</div>

<!-- ios button: show/hide panel -->
<div class="jplist-ios-button">
	<i class="fa fa-sort"></i>
	<?php echo __('Controls', 'wp-upg'); ?>
</div>

<!-- panel -->
<div class="jplist-panel box panel-bottom">

	<div class="jplist-drop-down" data-control-type="items-per-page-drop-down" data-control-name="paging" data-control-action="paging" data-control-animate-to-top="true">
		<div class="jplist-dd-panel"> 10 <?php echo __('per page', 'wp-upg'); ?> </div>
		<ul style="display: none;">
			<li class=""><span data-number="5"> 5 <?php echo __('per page', 'wp-upg'); ?> </span></li>
			<li class="active"><span data-number="10" data-default="true"> 10 <?php echo __('per page', 'wp-upg'); ?> </span></li>
			<li><span data-number="15"> 15 <?php echo __('per page', 'wp-upg'); ?> </span></li>
			<li><span data-number="all"> <?php echo __('View All', 'wp-upg'); ?> </span></li>
		</ul>
	</div>
	<div class="jplist-drop-down" data-control-type="sort-drop-down" data-control-name="sort" data-control-action="sort" data-control-animate-to-top="true">
		<div class="jplist-dd-panel"><?php echo __('Date asc', 'wp-upg'); ?></div>
		<ul style="display: none;">
			<li class="active"><span data-path="default"><?php echo __('Sort by', 'wp-upg'); ?></span></li>
			<li><span data-path=".title" data-order="asc" data-type="text"><?php echo __('Title A-Z', 'wp-upg'); ?></span></li>
			<li><span data-path=".title" data-order="desc" data-type="text"><?php echo __('Title Z-A', 'wp-upg'); ?></span></li>
			<li><span data-path=".date" data-order="asc" data-type="datetime"><?php echo __('Date asc', 'wp-upg'); ?></span></li>
			<li><span data-path=".date" data-order="desc" data-type="datetime"><?php echo __('Date desc', 'wp-upg'); ?></span></li>
		</ul>
	</div>

	<!-- pagination results -->
	<div class="jplist-label" data-type="{start} - {end} of {all}" data-control-type="pagination-info" data-control-name="paging" data-control-action="paging">1 - 10 of 32</div>

	<!-- pagination -->
	<div class="jplist-pagination" data-control-type="pagination" data-control-name="paging" data-control-action="paging" data-control-animate-to-top="true">
		<div class="jplist-pagingprev jplist-hidden" data-type="pagingprev"><button type="button" class="jplist-first" data-number="0" data-type="first" data-active="true">«</button><button type="button" class="jplist-prev" data-type="prev" data-number="0" data-active="true">‹</button></div>
		<div class="jplist-pagingmid" data-type="pagingmid">
			<div class="jplist-pagesbox" data-type="pagesbox"><button type="button" data-type="page" class="jplist-current" data-active="true" data-number="0">1</button> <button type="button" data-type="page" data-number="1">2</button> <button type="button" data-type="page" data-number="2">3</button> <button type="button" data-type="page" data-number="3">4</button> </div>
		</div>
		<div class="jplist-pagingnext" data-type="pagingnext"><button type="button" class="jplist-next" data-type="next" data-number="1">›</button><button type="button" class="jplist-last" data-type="last" data-number="3">»</button></div>
	</div>
</div>
</div>
<!-- end -->
</div>
</div>
</div>