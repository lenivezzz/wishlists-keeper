(function ($) {
    $.ajaxSetup({
        beforeSend: function (jqXHR, settings) {
            $('#ajax-loader').toast('show');
        },
        complete: function (jqXHR, textStatus) {
            $('#ajax-loader').toast('hide');
        },
        error: function (error) {
            if (error.status > 500) {
                $('#ajax-failure').clone().on('hide.bs.modal', function (e) {
                    $(e).remove();
                });
            }
        }
    });
}) (jQuery);
