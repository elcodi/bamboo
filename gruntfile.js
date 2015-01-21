/*global module:false*/
module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		compass: {
			dist: {
				options: {
					config: 'src/Elcodi/Admin/CoreBundle/Resources/public/css/config.rb'
				}
			}
		},
		uglify: {
			options: {
				beautify: false
			},
			core: {
				files: {

				}
			}
		},
		jshint: {
			options: {
				globals: {
					console: true
				}
			},
			dist: ['Gruntfile.js', 'src/Elcodi/Admin/CoreBundle/Resources/public/js/modules/**/*.js']

		},
        jasmine: {
            main:{
                src: [
                    'src/Elcodi/Admin/CoreBundle/Resources/public/js/modules/*.js'
                ],
                options: {
                    specs: 'src/Elcodi/Admin/CoreBundle/Resources/public/js/test/*.js',
                    vendor :  [
                        'src/Elcodi/Admin/CoreBundle/Resources/public/components/frontendcore-js/_oGlobalSettings.js',
                        'src/Elcodi/Admin/CoreBundle/Resources/public/components/frontendcore-js/core.js',
                        'src/Elcodi/Admin/CoreBundle/Resources/public/components/frontendcore-js/devices/desktop.js',
                        'src/Elcodi/Admin/CoreBundle/Resources/public/components/frontendcore-js/ui/*.js'
                    ],
                    outfile: 'js-specrunner.html',
                    keepRunner: false
                }
            }
        },
		watch: {
			scripts: {
				files: ['src/Elcodi/Admin/CoreBundle/Resources/public/js/**/*.js', 'Gruntfile.js'],
				tasks: ['javascript']
			},
			scss: {
				files: ['src/Elcodi/Admin/CoreBundle/Resources/public/css/**/*.scss'],
				tasks: ['scss']
			}
		}

	});

	require('load-grunt-tasks')(grunt, {pattern: ['*', '!grunt-template-jasmine-requirejs', '!grunt-lib-phantomjs', '!bower', '!load-grunt-tasks']});

    grunt.registerTask('javascript', ['uglify', 'jshint','jasmine']);
	grunt.registerTask('scss', ['compass']);

	grunt.registerTask('default', ['scss','javascript']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};
