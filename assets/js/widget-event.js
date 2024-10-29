/**
 * Created by tutv95 on 16/10/2015.
 */

jQuery(document).ready(function ($) {
    var ul_list_events = $('.easy-event .list-events');
    var show_per_page = ul_list_events.attr('data-number');

    var list_events = ul_list_events.find('li');
    var count_events = list_events.length;
    if (show_per_page > count_events) {
        show_per_page = count_events;
    }

    $('.easy-event.vticker').vTicker('init', {
        speed: 1000,
        pause: 4000,
        showItems: show_per_page,
        padding: 0
    });
});