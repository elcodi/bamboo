module.exports = {
	example: {
		src: ['./temp/*.twig'],          // source files array (supports minimatch)
		dest: './twig/',             // destination directory or file
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
				from: "render url('store_currency_nav')",                   // string replacement
				to: "include ('_currencies.html.twig')"
			},
			{
				from: "render url('store_user_top')",                   // string replacement
				to: "include ('_topbar.html.twig')"
			},
			{
				from: "render url('store_cart_nav')",                   // string replacement
				to: "include ('_cart-nav.html.twig')"
			},
			{
				from: "render url('store_categories_nav')",                   // string replacement
				to: "include ('_categories-list.html.twig')"
			},
			{
				from: 'src="//',                   // string replacement
				to: 'src="http://'
			}]
	}
}