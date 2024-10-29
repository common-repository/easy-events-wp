/**
 * Created by tutv95 on 16/10/2015.
 */

jQuery(document).ready(function ($) {
	var ul_list_events = $('.easy-event .list-events');
	if (ul_list_events.length > 0) {
		var show_per_page = ul_list_events.attr('data-number');
		var list_events = ul_list_events.find('li');
		var count_events = list_events.length;
		if (show_per_page > count_events) {
			show_per_page = count_events;
		}

		$('.easy-event.vticker').vTicker('init', {
			speed    : 1000,
			pause    : 4000,
			showItems: show_per_page,
			padding  : 0
		});
	}


	var $ee_count_down = $('.ee-count-down');
	if ($ee_count_down.length) {
		var ee_time_event = $ee_count_down.attr('data-time');

		$ee_count_down.countdown(ee_time_event, function (event) {
			$('.days .number').text(event.strftime('%D'));
			$('.hours .number').text(event.strftime('%H'));
			$('.minutes .number').text(event.strftime('%M'));
			$('.seconds .number').text(event.strftime('%S'));
		});
	}
});