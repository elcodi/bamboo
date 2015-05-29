FrontendCore.define('on-off-table', ['devicePackage' ], function () {
    return {
        oMasterLanguage : '',
        oMasterCurrency : '',
        setMasterLanguage: function() {
            this.oMasterLanguage = $('[name=language-master]:checked')[0];
        },
        setMasterCurrency: function() {
            this.oMasterCurrency = $('[name=currency-master]:checked')[0];
        },
        onStart: function () {

            FrontendCore.requireAndStart('notification');

            var self = this;

            self.setMasterLanguage();
            self.setMasterCurrency();

            $('.switch input').each( function(){

                var oTarget = this;

                $(oTarget).change( function() {

                    var oInput = this,
                        sValue = oInput.checked,
                        sUrl = this.checked === true ? document.getElementById('enable-' + this.id).value : document.getElementById('disable-' + this.id).value;

                    $.ajax({
                        url: sUrl,
                        type: 'post'
                    }).done( function() {
                        self.setMasterLanguage();
                        self.setMasterCurrency();
                    }).fail( function( response ) {

                        if ( sValue === true ) {
                            oInput.checked = false;
                        } else {
                            oInput.checked = true;
                        }

                        if ( oInput.name === 'language-master' ) {
                            self.oMasterLanguage.checked = true;
                        }

                        if ( oInput.name === 'currency-master' ) {
                            self.oMasterCurrency.checked = true;
                        }

                        var sMessage = response.responseJSON.message !== undefined ? response.responseJSON.message : 'Sorry, something was wrong.';
                        FrontendMediator.publish( 'notification', { type : 'ko', message: sMessage } );

                    });
                });
            });

        }
    };
});

