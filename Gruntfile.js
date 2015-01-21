/*global module:false*/

function mergeJSON(source1, source2) {
	/*
	 * Properties from the Souce1 object will be copied to Source2 Object.
	 * Note: This method will return a new merged object, Source1 and Source2 original values will not be replaced.
	 * */
	var mergedJSON = Object.create(source2);// Copying Source2 to a new Object

	for (var attrname in source1) {
		if (mergedJSON.hasOwnProperty(attrname)) {
			if (source1[attrname] !== null && source1[attrname].constructor === Object) {
				/*
				 * Recursive call if the property is an object,
				 * Iterate the object and set all properties of the inner object.
				 */
				mergedJSON[attrname] = mergeJSON(source1[attrname], mergedJSON[attrname]);
			}

		} else {//else copy the property from source1
			mergedJSON[attrname] = source1[attrname];

		}
	}

	return mergedJSON;
}

module.exports = function (grunt) {

	var pkg = require('./package.json'),
		bbdd = require('./database.json'),
		fixtures = mergeJSON(pkg, bbdd);

	require('load-grunt-config')(grunt, fixtures);

	require('load-grunt-tasks')(grunt, {pattern: ['*', '!grunt-template-jasmine-requirejs', '!grunt-lib-phantomjs', '!bower', '!load-grunt-tasks', '!load-grunt-config']});

    grunt.registerTask('js', ['uglify:core', 'jshint','jasmine']);
	grunt.registerTask('tests', ['uglify:tests','jasmine']);
	grunt.registerTask('twig', ['twigRender']);
	grunt.registerTask('scss', ['compass']);

	grunt.registerTask('default', ['clean','copy','replace','twigRender','clean:temp','scss']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};