(function($) {
    $.fn.addProductToWishlist = function (url, success, fail) {
        $(this).each(function (i, el) {
            $(el).on('click', function () {
                let t = $(this);
                t.addClass('disabled').prop('disabled', 'disabled');
                $.ajax({
                        url: url,
                        data: {
                            productId: t.data('productId'),
                            wishlistId: t.data('wishlistId')
                        },
                        method: 'post',
                        context: el
                    })
                    .done(success)
                    .fail(function (error) {
                        fail(error);
                        t.removeClass('disabled').removeAttr('disabled');
                    });
            });
        });
    };
})(jQuery);
