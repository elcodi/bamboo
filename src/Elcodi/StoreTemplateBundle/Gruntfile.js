/*global module:false*/
module.exports = function (grunt) {
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		compass: {
            dist: {
				options: {
                    require: 'susy',
					config: 'config.rb'
				}
			}
		},
		jshint: {
			options: {
				globals: {
					console: true
				}
			},
			dist: ['Gruntfile.js', 'Resources/public/js/**/*.js']

		},
		jasmine: {
			main:{
				src: [
                    'build/static/js/ui/*.js'
                ],
				options: {
					specs: 'tests/*.js',
                    vendor :  [
                        'js/base/_oGlobalSettings.js',
                        'build/static/js/core.js',
                        'build/static/js/devices/desktop.js',
                        'build/static/js/ui/*.js'
                    ],
                    outfile: 'build/data/tests.html',
                    keepRunner: true
				}
			}
		},
        clean: {
            build: {
                src: ['build/']
            },
            temp: {
                src: ['twig','temp/']
            }
        },
		copy: {
			twig: {
				files: [
					{expand: true, flatten: true, src: ['Resources/views/**'], dest: 'temp/', filter: 'isFile'}
				]
			},
		},
		replace: {
			example: {
				src: ['temp/*.twig'],             // source files array (supports minimatch)
				dest: 'twig/',             // destination directory or file
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
		},
		twigRender: {
			options:
			{
				extensions:
					[

						// Usage: {{ [1, 2, 3]|fooJoin(' | ') }}
						// Output: 1 | 2 | 3

						function(Twig)
						{
							Twig.exports.extendFilter( "trans", function(value)
							{
								if (value === undefined || value === null)
								{
									return;
								}

								return value;
							});

							Twig.exports.extendFilter( "print_convert_money", function(value)
							{
								if (value === undefined || value === null)
								{
									return;
								}

								return value;
							});

							Twig.exports.extendFunction( "asset", function( path )
							{
								return path.replace('bundles/storetemplate/','../Resources/public/');
							});

							Twig.exports.extendFunction( "url", function( path )
							{
								return '#';
							});

							Twig.exports.extendFunction( "getConfiguration", function( path )
							{
								return '#';
							});
						}

					]
			},
			dist: {
				files: [
					{
						data: 'database.json',
						expand: true,
						cwd: 'twig/',
						src: 'cart-checkout.html.twig',
						//src: ['**/*.html.twig', '!**/_*.html.twig'],
						dest: 'build/',
						ext: '.html'
					}
				]
			}
		},
		watch: {
			scripts: {
				files: ['js/core/**/*.js', 'js/ui/**/*.js', 'js/libs/**/*.js', 'Gruntfile.js'],
				tasks: ['js']
			},
			tests: {
				files: ['tests/**/*.js'],
				tasks: ['tests']
			},
			scss: {
				files: ['css/**/*.scss'],
				tasks: ['scss']
			},
			twig: {
				files: ['twig/**/*.twig','database.json','twig/**/*.html'],
				tasks: ['twig']
			}
		}

	});

	grunt.loadNpmTasks('grunt-contrib-jshint');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-compass');
	grunt.loadNpmTasks('grunt-contrib-requirejs');
	grunt.loadNpmTasks('grunt-contrib-cssmin');
	grunt.loadNpmTasks('grunt-contrib-jasmine');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-text-replace');
    grunt.loadNpmTasks('grunt-sassdoc');
    grunt.loadNpmTasks('grunt-contrib-clean');
	grunt.loadNpmTasks('grunt-twig-render');
    grunt.loadNpmTasks('grunt-conventional-changelog');
    grunt.registerTask('js', ['uglify:core', 'jshint','jasmine']);
	grunt.registerTask('tests', ['uglify:tests','jasmine']);
	grunt.registerTask('twig', ['twigRender']);
	grunt.registerTask('scss', ['compass']);
	grunt.registerTask('log', ['clean:changelog','changelog','stencil']);

	grunt.registerTask('default', ['clean','copy','replace','twig','clean:temp','scss']);

	grunt.event.on('watch', function (action, filepath) {
		grunt.config(['default'], filepath);
	});
};