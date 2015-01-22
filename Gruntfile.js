/*global module:false*/

module.exports = function (grunt) {

	require('load-grunt-config')(grunt);

	require('load-grunt-tasks')(grunt, {pattern: ['*', '!grunt-template-jasmine-requirejs', '!grunt-lib-phantomjs', '!bower', '!load-grunt-tasks', '!load-grunt-config']});

    grunt.registerTask('js', ['jshint','jasmine']);
	grunt.registerTask('tests', ['jasmine']);
	grunt.registerTask('twig', ['twigRender']);
	grunt.registerTask('scss', ['compass']);

	grunt.registerTask('default', ['clean','copy','replace','twigRender','clean:temp','scss']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};