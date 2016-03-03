$(function() {
	// Initalise Core
	core.init();					
});

var core = {

	init: function() {
		
		core.dataTables();
		
		core.slideOrder();
				
	},
	
	dataTables: function() {
		
		$('#courses tr').click(function(){
			if ($(this).attr("url") !== undefined) {
				window.location = $(this).attr("url");
			}
		});
	
		if ($('#courses').length) {
			$('#courses').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"aLengthMenu": [[20, 40, 80, -1], [20, 40, 80, "All"]],
				"iDisplayLength": 20,
				"aaSorting": [[1,'asc']]
			});
		}
		
		$('#categories tr').click(function(){
			if ($(this).attr("url") !== undefined) {
				window.location = $(this).attr("url");
			}
		});
		
		if ($('#categories').length) {
			$('#categories').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"aLengthMenu": [[20, 40, 80, -1], [20, 40, 80, "All"]],
				"iDisplayLength": 20,
				"aaSorting": [[1,'asc']]
			});
		}

	},
	
	slideOrder: function() {
		if($('ul.slides').length) {
			$('ul.slides').sortable({
				placeholder: 'ui-state-highlight',
				stop: function(i) {
					// alert($('ul.slides').sortable('serialize'));
					$.post("/admin/slideshow/sort/id/" + $('ul.slides').attr('id'), { 'slide[]': $('ul.slides').sortable('toArray') });
					// $.get('/admin/slideshow/sort/id/' + $('ul.slides').attr('id') + '/?&' + $('ul.slides').sortable('serialize'));
				}
			});
			
			$('ul.slides').disableSelection();
		}
	}

};
