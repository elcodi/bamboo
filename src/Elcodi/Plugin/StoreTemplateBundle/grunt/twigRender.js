function extend(target) {
	var sources = [].slice.call(arguments, 1);
	sources.forEach(function (source) {

		if ( source.length > 0 ){
			for ( var nKey = 0; nKey < source.length; nKey++ ) {
				for (var prop in source[nKey]) {
					target[prop] = source[nKey][prop];
				}
			}
		} else {
			for (var prop in source) {
				target[prop] = source[prop];
			}
		}
	});
	return target;
}

function getFixtures( aFixturesNames ) {

	var aFixturesContent = [];

	for ( var nKey = 0; nKey < aFixturesNames.length; nKey ++ ) {
		aFixturesContent[nKey] = require('../fixtures/'+ aFixturesNames[nKey] + '.json')
	}

	return extend({}, aFixturesContent);
}


module.exports = function(grunt, fixtures) {


	var oLanguages = getFixtures(['messages.en']),
		oFullFixtures = getFixtures(['store','paginator','currencies','categoryTree','product','products','form','related_products','cart-empty','addresses','order','orders','currencyCategoryId-null']),
		oCategoryFullFixtures = getFixtures(['store','paginator','currencies','categoryTree','product','products','related_products','cart-empty','currencyCategoryId-1']),
		oCategoryEmptyFixtures = getFixtures(['store','paginator','currencies','categoryTree','product','related_products','cart-empty','currencyCategoryId-1']),
		oCartFullFixtures = getFixtures(['store','paginator','currencies','categoryTree','product','related_products','addresses','order','orders','cart-full','currencyCategoryId-1']),
		oUserForm = getFixtures(['store','paginator','currencies','categoryTree','product','related_products','order','orders','cart-full','form']),
		oOrderEmtpyFixtures = getFixtures(['store','paginator','currencies','categoryTree','product','related_products','cart-full','currencyCategoryId-1']);

	return {
		options: {
			extensions: [

				function (Twig) {
					Twig.exports.extendFilter("trans", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						var aKeys = value.split('.'),
							currentKey = oLanguages[aKeys[0]];

						for ( var nKey = 1; nKey < aKeys.length; nKey++ ) {

							if (currentKey[aKeys[nKey]] !== undefined){
								currentKey = currentKey[aKeys[nKey]];
							} else {
								currentKey = value;
							}

						}

						return currentKey;
					});

					Twig.exports.extendFilter("resize", function (value) {
						if (value === undefined || value === null) {
							return;
						}

						return value;
					});

					Twig.exports.extendFilter("purchasable_name", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						return value.name;
					});

					Twig.exports.extendFilter("print_convert_money", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						return '$' + value;
					});

					Twig.exports.extendFunction("asset", function (path) {

						if (path !== undefined) {
							return path.replace('bundles/storetemplate/', '../');
						}

					});

					Twig.exports.extendFunction("max", function (value) {
						return value;
					});

					Twig.exports.extendFunction("min", function (value) {
						return value;
					});


					Twig.exports.extendFunction("elcodi_hook", function (value) {

						if (value === undefined || value === null) {
							return;
						}

						return '';
					});

					Twig.exports.extendFunction("url", function (path) {
						return '#';
					});

					Twig.exports.extendFunction("form_theme", function (path) {
						return ;
					});

					Twig.exports.extendFunction("available_options", function (product, attribute) {

						var oOptions = {
							"1" : {
								"id" : "111",
								"name" : "Large"
							}
						}

						return product.attributes[attribute.id].available_options;
					});

					Twig.exports.extendFunction("form_start", function (value) {

						return '<form>';
					});

					Twig.exports.extendFunction("form_row", function (oInput, oOptions) {


						if ( oInput === undefined || oInput === null )  {

							return 'undefined';

						} else {

							if (oInput.label === undefined )  {
								return 'undefined';
							}
						}

						var sType = "text",
							sCode = '',
							sLabel = oInput,
							sValue = oInput,
							sClass = '';

						if (oOptions !== undefined) {
							sClass = oOptions.attr.class === undefined ? ' ' : oOptions.attr.class;
						}

						if ( oInput !== undefined && oInput !== null  ) {

							if (typeof oInput === 'number') {
								sType = "number"
							} else if (typeof oInput === 'object') {
								sType = oInput.type;
								sLabel = oInput.label;
								sValue = oInput.value == undefined ? '' : oInput.value;

							} else if (oInput.indexOf("@") !== -1 ) {
								sType = "email";
							}

						} else {
							sLabel = '';
							sValue = '';
						}

						if (sType !== 'submit') {
							sCode += '<p>';
							sCode += '<label class="required">' + sLabel + '</label>';
							sCode += '<input class="'+ sClass +'" type="'+ sType + '" value="' + sValue +'">';
							sCode += '</p>';
						} else {
							sCode += '<button type="' + sType + '" class="'+ sClass +'"> '+ sLabel + '</button>';
						}

						return sCode;
					});

					Twig.exports.extendFunction("form_widget", function (oInput, oOptions) {



						if ( oInput === undefined || oInput === null)  {

							return 'undefined';

						} else {

							if (oInput.label === undefined )  {
								return 'undefined';
							}
						}

						var oJson = {},
							sLabel =  oInput.label,
							sClass,
							sHtml;



						if (oOptions !== undefined ) {

							sClass = oOptions.attr.class === undefined ? ' ' : oOptions.attr.class;
						}

						if (oOptions !== undefined) {
							oJson = JSON.stringify(oOptions);
						}

						if ( oInput.type == 'submit' ) {
							sHtml = '<button type="submit" class="'+ sClass + '">' + sLabel + '</button>';
						} else {
							sHtml = '<input type="'+ oInput.type + '" class="'+ sClass + '" value="" />';
						}


						return sHtml;
					});

					Twig.exports.extendFunction("form_end", function (product, attribute) {

						return '</form>';
					});

					Twig.exports.extendFunction("elcodi_blog_pages", function ( sVar ) {

						return sVar;
					});

					Twig.exports.extendFunction("elcodi_footer_pages", function ( sVar ) {


						return sVar;
					});

					Twig.exports.extendFunction("paymill_scripts", function ( sVar ) {

						return false;
					});

					Twig.exports.extendFunction("paymill_render", function ( sVar ) {


						return false;
					});
					Twig.exports.extendFunction("form_errors", function ( sVar ) {

						return false;
					});


				}

			]
		},
		default: {
			files: [
				{
					data: oFullFixtures,
					expand: true,
					cwd: './temp/',
					src: ['*.html.twig','!_*.html.twig','!cart*.html.twig','!recover-password.html.twig','!fields.html.twig','!user*.html.twig','!category*.html.twig','!coupon*.html.twig','!product*.html.twig','index.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '.html'
				}
			]
		},
		categoryFull: {
			files: [
				{
					data: oCategoryFullFixtures,
					expand: true,
					cwd: './temp/',
					src: ['category*.html.twig','product*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '.html'
				}
			]
		},
		categoryEmpty: {
			files: [
				{
					data: oCategoryEmptyFixtures,
					expand: true,
					cwd: './temp/',
					src: ['home*.html.twig','category*.html.twig','product*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '-empty.html'
				}
			]
		},
		cartFull: {
			files: [
				{
					data: oCartFullFixtures,
					expand: true,
					cwd: './temp/',
					src: ['cart-*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '.html'
				}
			]
		},
		cartEmpty: {
			files: [
				{
					data: oFullFixtures,
					expand: true,
					cwd: './temp/',
					src: ['cart*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '-empty.html'
				}
			]
		},
		orderEmpty: {
			files: [
				{
					data: oOrderEmtpyFixtures,
					expand: true,
					cwd: './temp/',
					src: ['order*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '-empty.html'
				}
			]
		},
		userForm: {
			files: [
				{
					data: oUserForm,
					expand: true,
					cwd: './temp/',
					src: ['user-*.html.twig'],
					dest: 'Resources/public/preview/',
					ext: '.html'
				}
			]
		}

	}
}
