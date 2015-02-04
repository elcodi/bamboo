module.exports = {
	scripts: {
		files: ['Resources/public/js/**/*.js','Gruntfile.js'],
		tasks: ['js']
	},
	scss: {
		files: ['Scss/**/*.scss'],
		tasks: ['scss']
	},
	markdown: {
		files: ['README.md'],
		tasks: ['markdown']
	},
	default: {
		files: ['Resources/views/**/*.twig','grunt/*.js','fixtures/store.json','fixtures/**/*.*'],
		tasks: ['default']
	}
}