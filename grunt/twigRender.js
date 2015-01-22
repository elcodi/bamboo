module.exports = function(grunt, fixtures) {
	return {
		options: {
			extensions: [

				// Usage: {{ [1, 2, 3]|fooJoin(' | ') }}
				// Output: 1 | 2 | 3

				function (Twig) {
					Twig.exports.extendFilter("trans", function (value) {
						if (value === undefined || value === null) {
							return;
						}

						return value;
					});

					Twig.exports.extendFilter("resize", function (value) {
						if (value === undefined || value === null) {
							return;
						}

						return value;
					});
					Twig.exports.extendFilter("purchasable_name", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						return value;
					});

					Twig.exports.extendFilter("print_convert_money", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						return '$' + value;
					});

					Twig.exports.extendFunction("asset", function (path) {
						return path.replace('bundles/storetemplate/', '../Resources/public/');
					});

					Twig.exports.extendFunction("url", function (path) {
						return '#';
					});

					Twig.exports.extendFunction("available_options", function (product, attribute) {

						var oOptions = {
							"1" : {
								"id" : "111",
								"name" : "Large"
							}
						}

						return product.attributes[attribute.id].available_options;
					});

					Twig.exports.extendFunction("form_start", function (product, attribute) {

						return '<form>';
					});

					Twig.exports.extendFunction("form_row", function (form) {

						return '<input type="text">';
					});

					Twig.exports.extendFunction("form_widget", function (form) {

						return '<input type="text">';
					});

					Twig.exports.extendFunction("form_end", function (product, attribute) {

						return '</form>';
					});

					Twig.exports.extendFunction("getConfiguration", function ( sVar ) {

						var sValue = sVar.replace('.', ' ')

						return sValue;
					});

				}

			]
		},
		dist: {
			files: [
				{
					data: require('../fixtures/store.json'),
					expand: true,
					cwd: './temp/',
					src: ['*.html.twig','!_*.html.twig','index.html.twig'],
					//src: ['**/*.html.twig', '!**/_*.html.twig'],
					dest: 'build/',
					ext: '.html'
				}
			]
		}
	}
}