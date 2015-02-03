TinyCore.AMD.define('confirm', ['devicePackage' ], function () {
    return {
        onStart: function () {

            var aTargets = oTools.getDataModules('confirm'),
                self = this;

            oTools.trackEvent('JS_Libraries', 'call', 'slug');

            $(aTargets).each(function () {
                self.autobind(this);
            });

        },
        autobind: function (oTarget) {

            var sText = oTarget.getAttribute("data-tc-text") ? oTarget.getAttribute("data-tc-text") : 'Are you sure?',
                sName = oTarget.getAttribute("data-tc-name") ? oTarget.getAttribute("data-tc-name") : 'Delete this item.';

            $(oTarget).on('click', function() {
                if (!confirm("\n"+ sName + ":\n" + sText + "\n")) {
                    return false;
                }
            });
        }
    };
});

