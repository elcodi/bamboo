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

					Twig.exports.extendFilter("print_convert_money", function (value) {
						if (value === undefined || value === null) {
							return;
						}

						return value;
					});

					Twig.exports.extendFunction("asset", function (path) {
						return path.replace('bundles/storetemplate/', '../Resources/public/');
					});

					Twig.exports.extendFunction("url", function (path) {
						return '#';
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
					src: 'home-view.html.twig',
					//src: ['**/*.html.twig', '!**/_*.html.twig'],
					dest: 'build/',
					ext: '.html'
				}
			]
		}
	}
}