FrontendCore.define('category-parent', ['devicePackage' ], function () {
    return {
        onStart: function () {

            var $switch = $('input[name="elcodi_admin_product_form_type_category[root]"]' );

            if ($switch.is(':not(:checked)')) {
                $('#parent-categories').fadeToggle();
            }

            $switch.change( function(){
                $('#parent-categories').fadeToggle();
            });
        }
    };
});

