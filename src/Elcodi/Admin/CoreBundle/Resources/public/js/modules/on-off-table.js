FrontendCore.define('on-off-table', ['devicePackage' ], function () {
    return {
        onStart: function () {

            setTimeout( function() {

                $('.switch input').change( function() {

                    var sUrl = this.checked === true ? document.getElementById('enable-' + this.id).value : document.getElementById('disable-' + this.id).value ;

                    $.ajax({
                        url: sUrl,
                        type:  'post'
                    }).done( function( response ) {
	                    FrontendCore.requireAndStart('notification');

	                    setTimeout( function(){
		                    FrontendMediator.publish( 'notification', { type : 'ok', message: response.message } );
	                    }, 500);
                    }).fail( function( response ) {
	                    FrontendCore.requireAndStart('notification');

	                    setTimeout( function(){
		                    FrontendMediator.publish( 'notification', { type : 'ko', message: response.message } );
	                    }, 500);
                    });
                });

            } , 1500);

        }
    };
});

