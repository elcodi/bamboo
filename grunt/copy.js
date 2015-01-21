module.exports = {
	twig: {
		files: [
			{expand: true, flatten: true, src: ['./Resources/views/**'], dest: './temp/', filter: 'isFile'}
		]
	}
}