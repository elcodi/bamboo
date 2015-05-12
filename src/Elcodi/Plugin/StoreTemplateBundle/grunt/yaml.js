module.exports = {
	translations: {
		options: {
			ignored: /^_/,
			space: 4
		},
		files: [
			{expand: true, cwd: 'Resources/translations/', src: ['**/*.yml'], dest: 'fixtures/'}
		]
	}
}