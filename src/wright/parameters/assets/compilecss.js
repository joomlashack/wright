jQuery(function ($) {
    $('#wCompileCssBtn').on('click', function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).data('compiler'),
            success: function(data) {
                console.log('success');
                $('#wCompileCssStatus').html('<div class="alert alert-info">' + data + ' - Success!</div>');
            },
            error: function(data) {
                console.log('error');
                $('#wCompileCssStatus').html('<div class="alert alert-warning">' + data + ' - Error!</div>');
            },
            statusCode: {
                404: function(data) {
                    console.log(data + ' - 404');
                },
                200: function(data) {
                    console.log(data + ' - 200');
                }
            }
        });
    });
});