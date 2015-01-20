/*global module:false*/
module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		compass: {
			dist: {
				options: {
					config: 'src/Elcodi/Admin/AdminCoreBundle/Resources/public/css/config.rb'
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
			dist: ['Gruntfile.js', 'src/Elcodi/Admin/AdminCoreBundle/Resources/public/js/modules/**/*.js']

		},
        jasmine: {
            main:{
                src: [
                    'src/Elcodi/Admin/AdminCoreBundle/Resources/public/js/modules/*.js'
                ],
                options: {
                    specs: 'src/Elcodi/Admin/AdminCoreBundle/Resources/public/js/test/*.js',
                    vendor :  [
                        'src/Elcodi/Admin/AdminCoreBundle/Resources/public/components/frontendcore-js/core.js',
                        'src/Elcodi/Admin/AdminCoreBundle/Resources/public/components/frontendcore-js/devices/desktop.js',
                        'src/Elcodi/Admin/AdminCoreBundle/Resources/public/components/frontendcore-js/ui/*.js'
                    ],
                    outfile: 'js-specrunner.html',
                    keepRunner: false
                }
            }
        },
		sync: {
			main: {
				files: [{
					cwd: 'public/',
					src: [
						'**', /* Include everything */
						'!**/*.scss' /* but exclude scss files */
					],
					dest: 'web/bundles/admincore'
				}],
				updateAndDelete: true,
				pretend: false, // Don't do any IO. Before you run the task with `updateAndDelete` PLEASE MAKE SURE it doesn't remove too much.
				verbose: true // Display log messages when copying files
			}
		},
		watch: {
			scripts: {
				files: ['src/Elcodi/Admin/AdminCoreBundle/Resources/public/js/**/*.js', 'Gruntfile.js'],
				tasks: ['javascript']
			},
			scss: {
				files: ['src/Elcodi/Admin/AdminCoreBundle/Resources/public/css/**/*.scss'],
				tasks: ['scss']
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jasmine');
    grunt.registerTask('javascript', ['uglify:core', 'jshint','jasmine']);
	grunt.registerTask('scss', ['compass']);

	grunt.registerTask('default', ['scss','javascript']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};
