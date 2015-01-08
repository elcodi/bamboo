TinyCore.AMD.define('form-configuration', ['devicePackage'], function () {
	return {
		onStart: function () {

			var $Targets = $('li','.form-configuration'),
				self = this;

			FC.trackEvent('JS_Libraries', 'call', 'form-configuration');

			$Targets.each(function () {
				self.autobind(this);
			});
		},
		toggleField: function(oInput, bValue) {

			if (oInput.getAttribute("data-rel")) {
				oInput = document.getElementById(oInput.getAttribute("data-rel"));
			}

			var sId = oInput.id.replace('.', '_');

			if (oInput.nodeName == 'INPUT') {
				oInput.readOnly = bValue;
			} else if (oInput.nodeName == 'SELECT') {

				if (bValue) {
					oInput.style.display = 'none';
					$('#preview-'+ sId).show();
				} else {
					oInput.style.display = 'inline-block';
					$('#preview-'+ sId).hide();
				}
			}
		},
		setEditable : function(oTarget, oInput) {

			this.toggleField(oInput, false);

			if (oInput.nodeName === 'SELECT') {
				oInput.className = 'w-80';
			} else {
				oInput.className = 'd-ib w-80';
			}

				$('.js-edit-link', oTarget).fadeOut();
			$('.js-save', oTarget).fadeIn();
		},
		autobind: function (oTarget) {

			var self = this,
				$label = $('label', oTarget),
				sName = $label.attr('for'),
				oInput = document.getElementById(sName),
				sId = oInput.id.replace('.', '_');


			if (oInput.type !== 'checkbox') {
				$label.append('<a href="#" class="js-edit-link ml-m c-foreground"><i class="icon-pencil"></i> </a>');
				$(oTarget).append('<a href="#" class="js-save button-primary fz-l pv-s mb-n" style="vertical-align: top; display: none;"><i class="icon-save"></i> </a>');

				if (oInput.nodeName == 'SELECT') {
					$(oInput).before('<input type="text" id="preview-'+ sId +'" readonly="readonly" value="'+ oInput.value +'" data-rel="' + oInput.id + '" />');
				}


				self.toggleField(oInput, true);


				$('.js-edit-link', oTarget).on('click', function () {
					self.setEditable(oTarget, oInput);
				});

				$(oInput).on('click', function (e) {
					self.setEditable(oTarget, oInput);
				});

				$('#preview-'+ sId).on('click', function (e) {
					self.setEditable(oTarget, oInput);
				});

				$('.js-save', oTarget).on('click', function () {

					var oData = {};

					oData[sName] = document.getElementById(sName).value;

					$.ajax({
						url: document.getElementById('url-' + sName).value,
						type:  'post',
						data: oData,
						success: function(response) {
							self.toggleField(oInput, true);
							$('.js-save', oTarget).hide();
							$('.js-edit-link', oTarget).show();
						}
					});
				});
			} else {

				$(oInput).change( function (e) {

					var oData = {};
					oData[sName] = oInput.value;

					$.ajax({
						url: document.getElementById('url-' + sName).value,
						type:  'post',
						data: oData
					});
				});
			}
		}
	};
});

