module.exports = {
	example: {
		src: ['./temp/*.twig'],          // source files array (supports minimatch)
		overwrite : true,
		replacements: [{
				from: 'StoreTemplateBundle::Layout/',                   // string replacement
				to: ''
			},
			{
				from: 'StoreTemplateBundle::Modules/',                   // string replacement
				to: ''
			},
			{
				from: 'StoreTemplateBundle::Pages/',                   // string replacement
				to: ''
			},
			{
				from: 'StoreTemplateBundle::',                   // string replacement
				to: ''
			},
			{
				from: '@StoreTemplate/Layout/',                   // string replacement
				to: ''
			},
			{
				from: '@StoreTemplate/Modules/',                   // string replacement
				to: ''
			},
			{
				from: '@StoreTemplate/Pages/',                   // string replacement
				to: ''
			},
			{
				from: '@StoreTemplate/',                   // string replacement
				to: ''
			},
			{
				from: "'::",                   // string replacement
				to: "'"
			},
			{
				from: "render url('store_currency_nav')",                   // string replacement
				to: "include ('currency-nav.html.twig')"
			},
			{
				from: "render url('store_language_nav')",                   // string replacement
				to: "include ('language-nav.html.twig')"
			},
			{
				from: "render url('store_user_nav')",                   // string replacement
				to: "include ('user-nav.html.twig')"
			},
			{
				from: "render url('store_user_top')",                   // string replacement
				to: "include ('topbar.html.twig')"
			},
			{
				from: "render url('store_cart_nav')",                   // string replacement
				to: "include ('cart-nav.html.twig')"
			},
			{
				from: "render url('store_categories_nav')",                   // string replacement
				to: "include ('category-nav.html.twig')"
			},
			{
				from: "render url('store_coupon_view')",                   // string replacement
				to: "include ('coupon-add.html.twig')  with { 'form': form } "
			},
			{
				from: "{% render url('hwi_oauth_connect') %}",                   // string replacement
				to: ""
			},
			{
				from: "{% form_theme form 'fields.html.twig' %}",                   // string replacement
				to: ""
			},
			{
				from: "{% javascripts '@StoreGeoBundle/Resources/public/js/LocationSelectors.js' %}",                   // string replacement
				to: ""
			},
			{
				from: "{% endjavascripts %}",                   // string replacement
				to: ""
			},
			{
				from: "{% endjavascripts %}",                   // string replacement
				to: ""
			},
			{
				from: "{% render url('location_selectors',{locationId:address.city}) %}",                   // string replacement
				to: ""
			},
			{
				from: 'src="//',                   // string replacement
				to: 'src="http://'
			}]
	}
}