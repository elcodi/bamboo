module.exports = {
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
}