FrontendCore.define('form-shipping-rates', [], function () {
	return {
		onStart: function () {

			var self = this,
				sTypeValue = document.getElementById('elcodi_admin_shipping_form_type_shipping_range_type').value;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'shipping-rates');

			self.TypeVisibility(sTypeValue);

			$('#elcodi_admin_shipping_form_type_shipping_range_type').change( function(){
				self.TypeVisibility( this.value );
			});

		},
		TypeVisibility: function (sValue) {

			var ShowElement,
				hideElement,
				sNamePrice = 'apply-price',
				sNameWeight = 'apply-weight';

			if (sValue === '1') {
				ShowElement = sNamePrice;
				hideElement = sNameWeight;
			} else {
				hideElement = sNamePrice;
				ShowElement = sNameWeight;
			}

			$('#' + ShowElement).slideDown();
			$('#' + hideElement).slideUp();

		}
	};
});

