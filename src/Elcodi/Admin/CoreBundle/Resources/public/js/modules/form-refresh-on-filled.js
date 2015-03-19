FrontendCore.define('form-refresh-on-filled', ['devicePackage'], function () {
	return {
		oFields : ['store.paymill_private_key','store.paymill_public_key','store.paypal_web_checkout_recipient'],
		mediator : FrontendMediator,
		onStart: function () {

			FrontendTools.trackEvent('JS_Libraries', 'call', 'form-refresh-on-filled');

			this.mediator.subscribe( ['save:item'], this.addAndCheck, this );
		},
		addAndCheck: function( oResponse ) {

			var bReload = true;

			if (this.oFields.indexOf(oResponse.data.message) === -1) {
				this.oFields.push(oResponse.data.message);
			}

			for (var nKey = 0; this.oFields.length > nKey; nKey++) {

				if (document.getElementById(this.oFields[nKey].replace('store_','store.')).value === '') {
					bReload = false;
				}
			}

			if (bReload) {
				location.reload();
			}

		}
	};
});

