window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;

require('bootstrap');

let token = $('meta[name="csrf-token"]').attr('content');
if (token) {
    $.ajaxSetup({
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': token
        }
    });
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
