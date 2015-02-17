TinyCore.AMD.define('scss-group', ['devicePackage'], function () {
	return {
		oDefault: {
			limit: 12
		},
		onStart: function () {

			var aTargets = oTools.getDataModules('scss-group'),
				self = this;

			oTools.trackEvent('JS_Libraries', 'call', 'scss-group' );

			$(aTargets).each(function () {
				self.autobind(this);
			});
		},
		autobind: function (oTarget) {

			var sHtml = oTarget.innerHTML.replace('-default', '-custom').replace('<span class="hljs-keyword">default</span>','<span class="hljs-keyword">custom</span>'),
				sGroup = oTarget.getAttribute('data-tc-group'),
				cleanHtml = sHtml.split('<span class="hljs-comment">/*<span class="hljs-phpdoc"> @group</span> '+ sGroup + ' */</span>').pop();

			cleanHtml = cleanHtml.substring(0, cleanHtml.indexOf('<span class="hljs-comment">/*<span class="hljs-phpdoc"> @endgroup</span> '+ sGroup + ' */</span>'));


			if (sGroup === '') {
				sReturn = sHtml;
			} else {
				sReturn = cleanHtml;
			}

			oTarget.innerHTML = sReturn;

		},
		onStop: function () {
			this.sPathCss = null;
			this.oDefault = null;
		},
		onDestroy: function () {
			delete this.sPathCss;
			delete this.oDefault;
		}
	};
});