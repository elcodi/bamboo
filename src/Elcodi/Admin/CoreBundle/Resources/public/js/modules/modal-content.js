TinyCore.AMD.define('modal-content', ['devicePackage','modal' ], function () {
	return {
		oModal:  TinyCore.Module.instantiate( 'modal' ),
		mediator : TinyCore.Toolbox.request( 'mediator' ),
		onStart: function () {

			var aTargets = FC.getDataModules('modal-content'),
				self = this;

			FC.trackEvent('JS_Libraries', 'call', 'modal-content');

			$(aTargets).each(function () {
				self.autobind(this);
			});

			this.mediator.subscribe( ['new:category'], this.updateCategory, this );
			this.mediator.subscribe( ['new:manufacturer'], this.updateManufacturer, this );

		},
		updateSelect: function( id, value, innerHTML ) {

			var oOption = document.createElement('option'),
				oSelect = document.getElementById(id);

			$('option:selected', oSelect).removeAttr('selected');

			oOption.value = value;
			oOption.innerHTML = innerHTML;
			oOption.setAttribute('selected','selected');

			oSelect.appendChild(oOption);
		},
		updateCategory: function( oResponse ) {

			this.updateSelect( 'elcodi_admin_product_form_type_product_principalCategory', oResponse.data.id, oResponse.data.name );

		},
		updateManufacturer: function( oResponse ) {

			this.updateSelect( 'elcodi_admin_product_form_type_product_manufacturer', oResponse.data.id, oResponse.data.name );

		},
		autobind: function( oTarget ){

			var self = this;

			$(oTarget).on('click',function(event) {
				event.preventDefault();


				var $modal = $("#cboxContent");

				// 4.Open in a modal this href
				self.oModal.open({
					href: this.href,
					iframe: true,
					fastIframe : false,
					width: '95%',
					height: '95%',
					onOpen: function() {
						$modal.hide();
					},
					onComplete: function() {

						var $iframe = $("iframe").contents();

						$iframe.find("#cancel-button").on('click', function(event){
							event.preventDefault();
							self.oModal.close();
						});

						$iframe.find(".sidebar").remove();
						$iframe.find(".col-4-5.pull-right").attr('class','col-1-1');

						$modal.fadeIn();
					}
				});
			});
		}
	};
});

