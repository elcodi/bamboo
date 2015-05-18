/*global module:false*/

module.exports = function (grunt) {

	require('load-grunt-config')(grunt);

	require('jit-grunt')(grunt);

    grunt.registerTask('js', ['jshint','jasmine']);
	grunt.registerTask('twig', ['yaml','twigRender']);
	grunt.registerTask('scss', ['compass']);

	grunt.registerTask('default', ['clean','copy','replace','twig','clean:temp','scss']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};