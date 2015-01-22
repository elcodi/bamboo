module.exports = {
	scripts: {
		files: ['Resources/public/js/**/*.js','Gruntfile.js'],
		tasks: ['js']
	},
	scss: {
		files: ['Resources/public/scss/**/*.scss'],
		tasks: ['scss']
	},
	default: {
		files: ['Resources/views/**/*.twig','grunt/*.js','fixtures/store.json','fixtures/index.html.twig'],
		tasks: ['default']
	}
}