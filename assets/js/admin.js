jQuery(document).ready(function ($) {
    $('.ee-input-date').each(function (i) {
        var this_ = $(this);
        this_.datetimepicker({
            timepicker: false,
            format: this_.data('format')
        });
    });

    $('.ee-input-time').each(function (i) {
        var this_ = $(this);
        this_.datetimepicker({
            datepicker: false,
            format: this_.data('format')
        });
    });
});