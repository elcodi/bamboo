/*global module:false*/
module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		compass: {
			dist: {
				options: {
					config: 'public/css/config.rb'
				}
			}
		},
        sassdoc: {
            dist: {
                src: 'public/css/',
                dest: 'sassdoc/',
                options: {
                    verbose: false,
                    display: {
                        access: ['public'],
                        alias: false,
                        watermark: true
                    },
                    package: './package.json'
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
			dist: ['Gruntfile.js', 'public/js/modules/**/*.js']

		},
        clean: {
            sassdoc: {
                src: ['sassdoc']
            }
        },
        jasmine: {
            main:{
                src: [
                    'public/js/modules/*.js'
                ],
                options: {
                    specs: 'public/js/test/*.js',
                    vendor :  [
                        'js/base/_oGlobalSettings.js',
                        'public/components/frontendcore-js/core.js',
                        'public/components/frontendcore-js/devices/desktop.js',
                        'public/components/frontendcore-js/ui/*.js'
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
					dest: '../../../../../../../web/bundles/admincore'
				}],
				updateAndDelete: true,
				pretend: false, // Don't do any IO. Before you run the task with `updateAndDelete` PLEASE MAKE SURE it doesn't remove too much.
				verbose: true // Display log messages when copying files
			}
		},
		shell: {
			multiple: {
				command: [
					'cd /Users/tonipinel/Sites/bamboo-distribution/vagrant',
					'vagrant rsync'
				].join('&&')
			}
		},
		watch: {
			scripts: {
				files: ['public/js/**/*.js', 'Gruntfile.js'],
				tasks: ['javascript','shell']
			},
			scss: {
				files: ['public/css/**/*.scss'],
				tasks: ['scss','shell']
			},
			twig: {
				files: ['../../**/*.html.twig'],
				tasks: ['shell']
			},
			php: {
				files: ['../../../**/*.php'],
				tasks: ['shell']
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compass');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-jasmine');
    grunt.loadNpmTasks('grunt-sassdoc');
	grunt.loadNpmTasks('grunt-shell');
    grunt.registerTask('javascript', ['uglify:core', 'jshint','jasmine']);
	grunt.registerTask('scss', ['compass','clean:sassdoc','sassdoc']);

	grunt.registerTask('default', ['scss','javascript','shell']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};