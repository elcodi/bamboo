TinyCore.AMD.define('on-off-table', ['devicePackage' ], function () {
    return {
        onStart: function () {

            setTimeout( function() {

                $('#table-loading').fadeOut('fast', function() {
                    $('#current-table').fadeIn();
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

