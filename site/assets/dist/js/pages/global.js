$(function () {
	'use strict'

	$('.connectedSortable').sortable({
		placeholder         : 'sort-highlight',
		connectWith         : '.connectedSortable',
		handle              : '.card-header, .nav-tabs',
		forcePlaceholderSize: true,
		zIndex              : 999999
	})
	$('.connectedSortable .card-header, .connectedSortable .nav-tabs-custom').css('cursor', 'move')

	$(function() {
		let $sortable = $('.connectedSortable');

		let dashboard = JSON.parse(localStorage.getItem('remember.dashboard.layout'));
		if (dashboard) {
			$.each(dashboard, function(i, column) {
				$.each(column[1], function(i, item) {
					$('#' + item).appendTo($('#' + column[0])); // or prependTo for reverse
				});
			});
		}

		$sortable.sortable({ update: saveNewOrder });
		function saveNewOrder() {
			let dat = [];
			let i = 0;
			$.each($sortable, function() {
				dat[i++] = [this.id, $(this).sortable('toArray')]; // this.id is the column id, the 2nd element are the job id's in that column
			});
			localStorage.setItem('remember.dashboard.layout', JSON.stringify(dat));
		}
	});
})
