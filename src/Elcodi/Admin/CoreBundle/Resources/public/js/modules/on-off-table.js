FrontendCore.define('on-off-table', ['devicePackage' ], function () {
    return {
        onStart: function () {

            FrontendCore.requireAndStart('notification');

            $('.switch input').each( function(){

                var oTarget = this;

                $(oTarget).change( function() {

                    var oInput = this,
	                    sValue = oInput.checked,
	                    sUrl = this.checked === true ? document.getElementById('enable-' + this.id).value : document.getElementById('disable-' + this.id).value;

                    $.ajax({
                        url: sUrl,
                        type:  'post'
                    }).fail( function( response ) {

	                    if ( sValue === true ) {
		                    oInput.checked = false;
	                    } else {
		                    oInput.checked = true;
	                    }

                        var sMessage = response.responseJSON.message !== undefined ? response.responseJSON.message : 'Sorry, something was wrong.';
                        FrontendMediator.publish( 'notification', { type : 'ko', message: sMessage } );

                    });
                });
            });

        }
    };
});

