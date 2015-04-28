
TinyCore.AMD.define('skin-selector', [], function () {
	return {
		onStart: function () {
			var oSelect = document.getElementById('skin-selector'),
				oCSS = document.getElementById('skin-css'),
				sCSSPath = oCSS.href,
				sHash = window.location.hash.replace('#','');

			$(oSelect).change( function(){

				if (this.value.indexOf('...') === -1 ) {
					oCSS.href = sCSSPath.replace('main','skins/' + this.value);
					window.location.hash = '#' + this.value;
				} else {
					oCSS.href = sCSSPath;
					window.location.hash = '';
				}


			});

			if ( sHash !== '') {
				oSelect.value = sHash;
				$(oSelect).change();
			};

		}
	};
});