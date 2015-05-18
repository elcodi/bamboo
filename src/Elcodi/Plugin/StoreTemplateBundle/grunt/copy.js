module.exports = {
	twig: {
		files: [
			{expand: true, flatten: true, src: ['./fixtures/views/**'], dest: './temp/', filter: 'isFile'},
			{expand: true, flatten: true, src: ['./Resources/views/**'], dest: './temp/', filter: 'isFile'},
			{expand: true, flatten: true, src: ['./fixtures/index.html.twig'], dest: './temp/', filter: 'isFile'}
		]
	}
}