function locationSelectors() {
    // Polyfill for IE8 and below
    if (!Date.now) {
        Date.now = function() { return new Date().getTime(); }
    }

    function bindSelector( container ) {
        var target = container + ' select';
        $(target).on('change', function (e) {
            var optionSelected = $("option:selected", this),
                optionSelectedValue  = optionSelected.val(),
                selectorsUrl = $(container).data('url') + '/' + optionSelectedValue;

            if(optionSelectedValue) {

                if (undefined != optionSelected.parent().data('max-type')) {
                    document.getElementsByClassName('address-city')[0].value = optionSelectedValue;
                }
                else{
                    $(container).append('<i class="icon-spin icon-refresh"></i>');

                    $.ajax(selectorsUrl, {
                        success: function (response) {
                            $(container).replaceWith(response);

                            $('select.last', container).addClass('animated pulse').focus();

                            bindSelector(container);
                        }
                    });
                }
            }
        });
    }

    bindSelector('#js-location-selectors');
}

if(typeof jQuery=='undefined') {
    var headTag = document.getElementsByTagName("head")[0];
    var jqTag = document.createElement('script');
    jqTag.type = 'text/javascript';
    jqTag.src = '//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js';
    jqTag.onload = locationSelectors;
    headTag.appendChild(jqTag);
} else {
    locationSelectors();
}
