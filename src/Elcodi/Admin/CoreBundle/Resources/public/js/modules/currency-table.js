TinyCore.AMD.define('currency-table', ['devicePackage' ], function () {
    return {
        onStart: function () {

            setTimeout( function() {

                $('#currency-loading').fadeOut('fast', function() {
                    $('#currency-table').fadeIn();
                });

                $('.switch input').change( function() {

                    var sUrl = this.checked === true ? document.getElementById('enable-' + this.id).value : document.getElementById('disable-' + this.id).value ;

                    $.ajax({
                        url: sUrl,
                        type:  'post'
                    });
                });

            } , 1500);

        }
    };
});

