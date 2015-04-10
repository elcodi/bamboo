FrontendCore.define('form-save-on-edit', [], function () {
	return {
		mediator : FrontendMediator,
		onStart: function () {

			var oContainer = $('[data-fc-modules^="form-save-on-edit"]')[0],
				$li = $('li', oContainer),
				$Articles = $('article', oContainer),
				self = this;

			FrontendTools.trackEvent('JS_Libraries', 'call', 'form-save-on-edit');

			$li.each(function () {
				self.autobind(this);
			});

			$Articles.each(function () {
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
		inputChange : function(oInput, sName) {

			var self = this;

			$(oInput).change(function (e) {

				var oData = {};

				oData.value = $(oInput).is(':checked') || $(oInput).is(':selected') ? oInput.value : '';

				$.ajax({
					url: document.getElementById('url-' + sName).value,
					type: 'post',
					data: oData,
					error: function (response) {

						FrontendCore.requireAndStart(['notification'], function () {

							var sMessage = JSON.parse(response.responseText).response;
							self.mediator.publish('notification', {type: 'ko', message: sMessage});

							$(oInput).unbind();
							$(oInput).click();
							self.inputChange(oInput, sName);

						});
					}
				});
			});
		},
		inputSave: function(oInput, oTarget, sId, sName) {

			var oData = {},
				self = this;

			oData.value = document.getElementById(sName).value;

			$('.js-loading', oTarget).show();

			$(oInput).blur();

			$.ajax({
				url: document.getElementById('url-' + sName).value,
				type:  'post',
				data: oData,
				success: function(response) {

					if (oInput.nodeName == 'SELECT') {
						document.getElementById('preview-'+ sId).value = oInput.options[oInput.selectedIndex].innerHTML;
					}

					self.toggleField(oInput, true);
					$('.js-save', oTarget).hide();
					$('.js-loading', oTarget).hide();
					$('.js-ok', oTarget).fadeIn('slow').fadeOut('slow').fadeIn('slow').fadeOut('slow').fadeIn('slow');
					self.mediator.publish('save:item', {
						type: 'ok',
						message: sId
					});

					setTimeout( function() {
						$('.js-ok', oTarget).fadeOut();
					}, 3000);
					$('.js-edit-link', oTarget).show();
				}
			});
		},
		autobind: function (oTarget) {

			var self = this,
				$label = $('label', oTarget),
				sName = $label.attr('for'),
				oInput = document.getElementById(sName),
				sId = oInput.id.replace('.', '_');

			if (oInput.type === 'checkbox' || oInput.type === 'radio') {

				self.inputChange(oInput, sName);

			} else {
				$(oTarget).append('<a href="#" class="js-save button-primary fz-l pv-s mb-n" style="vertical-align: top; display: none;"><i class="icon-save"></i> </a>');
				$(oTarget).find('label').append('<i class="icon-check c-ok js-ok ml-s" style="display: none"></i>');
				$(oTarget).find('label').append('<i class="icon-spin icon-spinner js-loading ml-s" style="display: none"></i>');

				if (oInput.nodeName == 'SELECT') {
					$(oInput).before('<input type="text" id="preview-'+ sId +'" readonly="readonly" value="'+ $('option[value=' + oInput.value +  ']', oInput).html() +'" data-rel="' + oInput.id + '" />');
				}

				self.toggleField(oInput, true);

				$(oInput).on('click', function (e) {
					self.setEditable(oTarget, oInput);
				});

				$('#preview-'+ sId).on('click', function (e) {
					self.setEditable(oTarget, oInput);
				});

				$(oInput).keypress( function(e){
					if(e.keyCode==13){
						self.inputSave(oInput, oTarget, sId, sName);
					}
				});

				$('.js-save', oTarget).on('click', function (e) {
					e.preventDefault();
					self.inputSave(oInput, oTarget, sId, sName);
				});
			}
		}
	};
});

