FrontendCore.define('form-coupons', [], function () {
	return {
		onStart: function () {

			var self = this,
				sTypeValue = document.getElementById('elcodi_admin_coupon_form_type_coupon_type').value;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'form-coupons');

			self.TypeVisibility(sTypeValue);

			$('#elcodi_admin_coupon_form_type_coupon_type').change( function(){
				self.TypeVisibility( this.value );
			});

		},
		TypeVisibility: function (sValue) {

			var ShowElement,
				hideElement,
				sNameFixed = 'fixed-amount',
				sNamePercent = 'percent-amount';

			if (sValue === '1') {
				ShowElement = sNameFixed;
				hideElement = sNamePercent;
			} else {
				hideElement = sNameFixed;
				ShowElement = sNamePercent;
			}

			$('#' + ShowElement).slideDown();
			$('#' + hideElement).slideUp();

		}
	};
});

