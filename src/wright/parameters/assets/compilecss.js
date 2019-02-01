jQuery(function ($) {
    $('#wCompileCssBtn').on('click', function (event) {
        event.preventDefault();

        $.ajax(this.href, {
            success: function(data) {
                console.log('success');
                $('#wCompileCssStatus').html('<div class="alert alert-info">' + data + ' - Success!</div>');
            },
            error: function(data) {
                console.log('error');
                $('#wCompileCssStatus').html('<div class="alert alert-warning">' + data + ' - Error!</div>');
            }
        });
    });
});