FrontendCore.define('variants', ['devicePackage', 'modal'], function () {
	return {
		modal: TinyCore.Module.instantiate('modal'),
		mediator: TinyCore.Toolbox.request('mediator'),
		onStart: function () {

			var self = this,
				nWindowWidth,
				nModalWidth = '95%',
				nModalHeight = '95%';

			if (TinyCore !== undefined) {
				FrontendCore.requireAndStart('notification');
			}

			this.mediator.subscribe(['response:success'], this.updateVariants, this);

			$('.button-primary', '#variants-list').on('click', function (event) {

				event.preventDefault();

				nWindowWidth = $(window).width();

				if (nWindowWidth < 799) {
					nModalWidth = '100%';
					nModalHeight = '100%';
				}

				self.modal.open({
					iframe: true,
					href: this.href,
					width: nModalWidth,
					height: nModalHeight
				});

			});

		},
		bindLinks: function () {

			var self = this;

			$('a', '#variants-list').on('click', function (event) {

				if (this.className.indexOf('icon-trash-o') == -1) {

					event.preventDefault();

					self.modal.open({
						iframe: true,
						href: this.href + '?modal=true',
						width: '90%',
						height: '90%'
					});
				} else {

					var sText = this.getAttribute("data-fc-text") ? this.getAttribute("data-fc-text") : 'Are you sure?',
						sName = this.getAttribute("data-fc-name") ? this.getAttribute("data-fc-name") : 'Delete this item.';

					if (!confirm("\n" + sName + ":\n" + sText + "\n")) {
						return false;
					}
				}
			});
		},
		updateVariants: function (oResponse) {

			var self = this;

			if (document.getElementById('variants-message-ok') !== null) {
				self.mediator.publish('notification', {
					type: 'ok',
					message: document.getElementById('variants-message-ok').value
				});

				document.getElementById('variants-list').innerHTML = '<p class="ta-c pa-xl"><i class="icon-spin icon-spinner fz-xl"></i></p>';

				$.get(oResponse.data.url, function (sHtml) {

					document.getElementById('variants-list').innerHTML = sHtml;

					self.bindLinks();

				});

			}

			this.modal.close();

		}
	};
});

