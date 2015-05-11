!function (a) {
	var b, c, d = {};
	d.is = function (a, b) {
		return Object.prototype.toString.call(a).slice(8, -1) === b
	}, d.copy = function (a, b) {
		for (var c in b)if (b.hasOwnProperty(c)) {
			var d = b[c];
			a[c] = this.is(d, "Object") ? this.copy({}, d) : this.is(d, "Array") ? this.copy([], d) : d
		}
		return a
	}, d.log = function (a, b) {
		(window._pen_debug_mode_on || b) && console.log("%cPEN DEBUGGER: %c" + a, "font-family:arial,sans-serif;color:#1abf89;line-height:2em;", "font-family:cursor,monospace;color:#333;")
	}, d.shift = function (a, b, c) {
		c = c || 50;
		var d, e = this["_shift_fn" + a], f = "shift_timeout" + a;
		e ? e.concat([b, c]) : e = [[b, c]], d = e.pop(), clearTimeout(this[f]), this[f] = setTimeout(function () {
			d[0]()
		}, c)
	}, d.merge = function (b) {
		var c = {
			"class": "pen",
			debug: !1,
			stay: b.stay || !b.debug,
			textarea: '<textarea name="content"></textarea>',
			list: ["blockquote", "h2", "h3", "p", "insertorderedlist", "insertunorderedlist", "inserthorizontalrule", "indent", "outdent", "bold", "italic", "underline", "createlink"]
		};
		return 1 === b.nodeType ? c.editor = b : b.match && b.match(/^#[\S]+$/) ? c.editor = a.getElementById(b.slice(1)) : c = d.copy(c, b), c
	}, b = function (b) {
		if (!b)return d.log("can't find config", !0);
		var c = d.merge(b);
		if (1 !== c.editor.nodeType)return d.log("can't find editor");
		c.debug && (window._pen_debug_mode_on = !0);
		var e = c.editor;
		e.classList.add(c["class"]);
		var f = e.getAttribute("contenteditable");
		f || e.setAttribute("contenteditable", "true"), this.config = c, this._sel = a.getSelection(), this.actions(), this.toolbar(), this.markdown && this.markdown.init(this), this.config.stay && this.stay()
	}, b.prototype._effectNode = function (a, b) {
		for (var c = []; a !== this.config.editor;)a.nodeName.match(/(?:[pubia]|h[1-6]|blockquote|[uo]l|li)/i) && c.push(b ? a.nodeName.toLowerCase() : a), a = a.parentNode;
		return c
	}, b.prototype.nostyle = function () {
		var a = this.config.editor.querySelectorAll("[style]");
		return [].slice.call(a).forEach(function (a) {
			a.removeAttribute("style")
		}), this
	}, b.prototype.toolbar = function () {
		for (var b = this, c = "", e = 0, f = this.config.list; e < f.length; e++) {
			var g = f[e], h = "pen-icon icon-" + g;
			c += '<i class="' + h + '" data-action="' + g + '">' + (g.match(/^h[1-6]|p$/i) ? g.toUpperCase() : "") + "</i>", "createlink" === g && (c += '<input class="pen-input" placeholder="http://" />')
		}
		var i = a.createElement("div");
		i.setAttribute("class", this.config["class"] + "-menu pen-menu"), i.innerHTML = c, i.style.display = "none", a.body.appendChild(this._menu = i);
		var j = function () {
			"block" === i.style.display && b.menu()
		};
		window.addEventListener("resize", j), window.addEventListener("scroll", j);
		var k = this.config.editor, l = function () {
			b._isDestroyed || d.shift("toggle_menu", function () {
				var a = b._sel;
				a.isCollapsed ? b._menu.style.display = "none" : (b._range = a.getRangeAt(0), b.menu().highlight())
			}, 200)
		};
		return k.addEventListener("mouseup", l), k.addEventListener("keyup", l), i.addEventListener("click", function (a) {
			var c = a.target.getAttribute("data-action");
			if (c) {
				var d = function (a) {
					b._sel.removeAllRanges(), b._sel.addRange(b._range), b._actions(c, a), b._range = b._sel.getRangeAt(0), b.highlight().nostyle().menu()
				};
				if ("createlink" === c) {
					var e, f = i.getElementsByTagName("input")[0];
					return f.style.display = "block", f.focus(), e = function (a) {
						return a.style.display = "none", a.value ? d(a.value.replace(/(^\s+)|(\s+$)/g, "").replace(/^(?!http:\/\/|https:\/\/)(.*)$/, "http://$1")) : (c = "unlink", void d())
					}, f.onkeypress = function (a) {
						return 13 === a.which ? e(a.target) : void 0
					}, f.onkeypress
				}
				d()
			}
		}), this
	}, b.prototype.highlight = function () {
		var a, b = this._sel.focusNode, c = this._effectNode(b), d = this._menu, e = d.querySelector("input");
		return [].slice.call(d.querySelectorAll(".active")).forEach(function (a) {
			a.classList.remove("active")
		}), e && (e.style.display = "none"), a = function (a) {
			var b = ".icon-" + a, c = d.querySelector(b);
			return c && c.classList.add("active")
		}, c.forEach(function (b) {
			var c = b.nodeName.toLowerCase();
			switch (c) {
				case"a":
					return d.querySelector("input").value = b.href, a("createlink");
				case"i":
					return a("italic");
				case"u":
					return a("underline");
				case"b":
					return a("bold");
				case"ul":
					return a("insertunorderedlist");
				case"ol":
					return a("insertorderedlist");
				case"ol":
					return a("insertorderedlist");
				case"li":
					return a("indent");
				default:
					a(c)
			}
		}), this
	}, b.prototype.actions = function () {
		var a, b, c, e, f = this;
		return a = {
			block: /^(?:p|h[1-6]|blockquote|pre)$/,
			inline: /^(?:bold|italic|underline|insertorderedlist|insertunorderedlist|indent|outdent)$/,
			source: /^(?:insertimage|createlink|unlink)$/,
			insert: /^(?:inserthorizontalrule|insert)$/
		}, c = function (a, b) {
			var c = " to exec 「" + a + "」 command" + (b ? " with value: " + b : "");
			d.log(document.execCommand(a, !1, b) && f.config.debug ? "success" + c : "fail" + c)
		}, e = function (a) {
			for (var b = f._sel.getRangeAt(0), d = b.startContainer; 1 !== d.nodeType;)d = d.parentNode;
			return b.selectNode(d), b.collapse(!1), c(a)
		}, b = function (a) {
			if (-1 !== f._effectNode(f._sel.getRangeAt(0).startContainer, !0).indexOf(a)) {
				if ("blockquote" === a)return document.execCommand("outdent", !1, null);
				a = "p"
			}
			return c("formatblock", a)
		}, this._actions = function (f, g) {
			f.match(a.block) ? b(f) : f.match(a.inline) || f.match(a.source) ? c(f, g) : f.match(a.insert) ? e(f) : this.config.debug && d.log("can not find command function for name: " + f + (g ? ", value: " + g : ""))
		}, this
	}, b.prototype.menu = function () {
		var a = this._range.getBoundingClientRect(), b = a.top - 10, c = a.left + a.width / 2, d = this._menu;
		return d.style.display = "block", d.style.top = b - d.clientHeight + "px", d.style.left = c - d.clientWidth / 2 + "px", this
	}, b.prototype.stay = function () {
		var a = this;
		window.onbeforeunload || (window.onbeforeunload = function () {
			return a._isDestroyed ? void 0 : "Are you going to leave here?"
		})
	}, b.prototype.destroy = function (a) {
		var b = a ? !1 : !0, c = a ? "setAttribute" : "removeAttribute";
		return a || (this._sel.removeAllRanges(), this._menu.style.display = "none"), this._isDestroyed = b, this.config.editor[c]("contenteditable", ""), this
	}, b.prototype.rebuild = function () {
		return this.destroy("it's a joke")
	}, c = function (a) {
		if (!a)return d.log("can't find config", !0);
		var b = d.merge(a), c = b.editor.getAttribute("class");
		return c = c ? c.replace(/\bpen\b/g, "") + " pen-textarea " + b["class"] : "pen pen-textarea", b.editor.setAttribute("class", c), b.editor.innerHTML = b.textarea, b.editor
	}, this.Pen = a.getSelection ? b : c
}(document), function () {
	if (this.Pen) {
		var a = {keymap: {96: "`", 62: ">", 49: "1", 46: ".", 45: "-", 42: "*", 35: "#"}, stack: []};
		a.valid = function (a) {
			var b = a.length;
			return a.match(/[#]{1,6}/) ? ["h" + b, b] : "```" === a ? ["pre", b] : ">" === a ? ["blockquote", b] : "1." === a ? ["insertorderedlist", b] : "-" === a || "*" === a ? ["insertunorderedlist", b] : a.match(/(?:\.|\*|\-){3,}/) ? ["inserthorizontalrule", b] : void 0
		}, a.parse = function (a) {
			var b = a.keyCode || a.which;
			if (32 === b) {
				var c = this.stack.join("");
				return this.stack.length = 0, this.valid(c)
			}
			return this.keymap[b] && this.stack.push(this.keymap[b]), !1
		}, a.action = function (a, b) {
			if (!(a._sel.focusOffset > b[1])) {
				var c = a._sel.focusNode;
				c.textContent = c.textContent.slice(b[1]), a._actions(b[0]), a.nostyle()
			}
		}, a.init = function (b) {
			b.config.editor.addEventListener("keypress", function (c) {
				var d = a.parse(c);
				return d ? a.action(b, d) : void 0
			})
		}, window.Pen.prototype.markdown = a
	}
}(), FrontendCore.define('wysiwyg', [], function () {
	return {
		sPathCss: oGlobalSettings.sPathCssUI + '?v=' + oGlobalSettings.sHash,
		mediator :  FrontendMediator,
		bResize : false,
		_oConstants : {
			EDITOR_SUFIX : '-editor',
			TEXTAREA_SUFIX : '-textarea',
			TEXTAREA_CLASS : 'fc-wysiwyg-textarea',
			FULLSCREEN_EDITABLE_CLASS: 'fc-wysiwyg-full-screen',
			TextHelp : 'Select some text to get some formatting options.',
			TextVisual : '<i class="icon-eye"></i> VISUAL',
			TextHtml : '<i class="icon-code"></i> HTML',
			TextFullscreen : '<i class="icon-arrows-alt"></i> FULLSCREEN',
			TextMinscreen : '<i class="icon-minus"></i> MINIMIZE'
		},
		oDefault: {
			class: 'fc-wysiwyg', // {String} class of the editor,
			debug: false, // {Boolean} false by default
			stay: false, // {Boolean} false by default
			list: ['bold', 'italic', 'underline','insertunorderedlist','createlink'] // editor menu lis
		},
		onStart: function () {

			var aTargets = document.querySelectorAll('[data-fc-modules="wysiwyg"]'),
				self = this;

			FrontendTools.loadCSS(this.sPathCss);

			FrontendTools.trackModule('JS_Libraries', 'call', 'wysiwyg' );

			$(aTargets).each(function () {
				if ( this.getAttribute('data-fc-active') !== 'true') {

					this.setAttribute('data-fc-active', 'true');
					self.autobind(this);
				}
			});

			self.fDatePollyfill();

			self.mediator.subscribe( 'close:wysiwyg', this.closeFormatOptions );

		},
		fDatePollyfill: function() {
			if (!Date.now) {
				Date.now = function() { return new Date().getTime(); };
			}
		},
		closeFormatOptions : function() {
			$('.fc-wysiwyg-menu').hide();
		},
		updateTextarea : function(sId, oTarget) {

			oTarget.value = document.getElementById(sId).innerHTML == '<br>' ? '' : document.getElementById(sId).innerHTML;
		},
		updateEditArea : function(sId, oTarget) {

			document.getElementById(sId).innerHTML = $('#' + oTarget.id).val();
		},
		createEditArea: function(sId, oTarget, oText){
			var oEditArea = document.createElement('div');

			oEditArea.id = sId;
			oEditArea.className = 'fc-wysiwyg';
			oEditArea.innerHTML = $(oTarget).text();
			oEditArea.setAttribute('data-help', oText.help );

			return oEditArea;
		},
		createLink: function( sId, sName, sText ) {

			var oLink = document.createElement('a');

			oLink.innerHTML = sText;
			oLink.href = '#';
			oLink.id = sName + '-' + sId;
			oLink.className = 'button button-slim';

			return oLink;
		},
		createLinkGroup : function ( aElements) {
			var oLinkGroup = document.createElement('div');
			oLinkGroup.className= 'fc-wysiwyg-switch button-group ph-n';

			for (var nKey = 0; nKey < aElements.length; nKey++) {
				oLinkGroup.appendChild(aElements[nKey]);
			}
			return oLinkGroup;
		},
		bindForm : function(sId, oTarget) {

			var self = this;

			$('#' + sId).parents('form').on('submit', function() {

				if ( $('#' + sId).is(':visible') ) {
					self.updateEditArea(sId, oTarget );
				} else {
					self.updateTextarea(sId, oTarget);
				}

			});
		},
		bindHtmlButton : function(sId, oTarget, oText) {

			var self = this;

			$(oTarget).on('focus', function(){
				$(this).parent().find('.fc-wysiwyg-switch').fadeIn();
			}).on('blur', function(){
				$(this).parent().find('.fc-wysiwyg-switch').fadeOut();
				self.updateEditArea(sId, oTarget );
			});

			$('#html-' + sId).on('click', function (event) {

				event.preventDefault();

				$('#' + sId).toggle();

				$('#'+ oTarget.id).toggleClass(self._oConstants.TEXTAREA_CLASS);

				if ( $('#' + sId).is(':visible') ) {
					this.innerHTML = oText.html;
					self.updateEditArea(sId, oTarget );
					$('#' + sId).focus();
				} else {

					$(oTarget).focus();

					if (self.bResize === false ) {

						// @todo not to call directly to autosize
						require(['autosize'], function() {
							$(oTarget).autosize();
						});
						self.bResize = true;
					}

					self.closeFormatOptions();
					this.innerHTML = oText.visual;
					self.updateTextarea(sId, oTarget);
				}
			});

		},
		bindScreenButton: function(sId, oTarget, oText) {

			var self = this;

			$('#screen-' + sId).on('click', function (event) {

				event.preventDefault();

				$('#' + sId).toggleClass(self._oConstants.FULLSCREEN_EDITABLE_CLASS);

				$('#'+ oTarget.id).toggleClass(self._oConstants.FULLSCREEN_EDITABLE_CLASS);

				$(this).parent().toggleClass('fc-wysiwyg-switch-full-screen');

				$('.pen-menu').toggleClass('pen-menu-full-screen');

				if (this.innerHTML.indexOf(oText.minscreen) == -1) {

					$('body').css({'overflow':'hidden', 'height':'100%'});
					this.innerHTML = oText.minscreen;

				} else {

					$('body').css({'overflow':'auto', 'height':'auto'});
					this.innerHTML = oText.fullscreen;

				}

			});
		},
		bindTextarea: function(sId, oTarget) {

			var self = this;

			$('#' + sId).on('blur', function() {
				self.updateTextarea(sId, oTarget);
				$(this).parent().find('.fc-wysiwyg-switch').fadeOut();

			}).on('focus', function(){
				$(this).parent().find('.fc-wysiwyg-switch').fadeIn();
			});

		},
		getText: function(oTarget) {
			var self = this,
				oText = {},
				sName;

			var aText = ['visual','help','fullscreen','minscreen','html'];

			for (var nKey = 0; nKey < aText.length; nKey++) {

				sName = aText[nKey];

				if ( oTarget.getAttribute('data-fc-text-' + sName ) !== null) {
					oText[ sName ] = oTarget.getAttribute('data-fc-text-' + sName );
				} else {
					oText[ sName ] = self._oConstants['Text' + sName.charAt(0).toUpperCase() + sName.slice(1) ];
				}

			}

			return oText;
		},
		autobind: function (oTarget) {

			// To help CSS to position the buttons
			$(oTarget).parent().css('position','relative');

			var oOptions = {},
				self = this,
				oText = self.getText(oTarget),
				sDate = Math.floor(Date.now() / 1000),
				sId = oTarget.id ? oTarget.id + self._oConstants.EDITOR_SUFIX : sDate + self._oConstants.EDITOR_SUFIX,
				sValues = oTarget.getAttribute('data-fc-format-options'),
				oEditArea = self.createEditArea(sId, oTarget, oText),
				oSettings,
				editor,
				oLinkHTML,
				oLinkScreen,
				oLinkGroup,
				aLinks = [];

			// If the textarea has no id we assigned a new one
			if (oTarget.id === '') {
				oTarget.id = sDate + self._oConstants.TEXTAREA_SUFIX;
			}

			if (window.navigator.userAgent.indexOf('MSIE') === -1) {
				// check if the HTML option is enabled and creates the button
				if (oTarget.getAttribute("data-fc-html") !== null) {
					if (oTarget.getAttribute("data-fc-html") !== 'false') {
						oLinkHTML = self.createLink(sId, 'html', oText.html);
						aLinks.push(oLinkHTML);
					}
				} else {
					oLinkHTML = self.createLink(sId, 'html', oText.html);
					aLinks.push(oLinkHTML);
				}

				// check if the Fullscreen option is enabled and creates the button
				if (oTarget.getAttribute("data-fc-fullscreen") !== null) {
					if (oTarget.getAttribute("data-fc-fullscreen") !== 'false') {
						oLinkScreen = self.createLink(sId, 'screen', oText.fullscreen);
						aLinks.push(oLinkScreen);
					}
				} else {
					oLinkScreen = self.createLink(sId, 'screen', oText.fullscreen);
					aLinks.push(oLinkScreen);
				}
			}

			// If there are buttons append all of them after the Target
			if (aLinks.length > 0 ) {
				oLinkGroup = self.createLinkGroup(aLinks);
				$(oTarget).after(oLinkGroup);
			}

			// Add the class to the textarea
			oTarget.className = self._oConstants.TEXTAREA_CLASS + ' fc-wysiwyg-html';

			// Append the link group and the edit area
			$(oTarget).before(oEditArea);

			// Set the editor and the textarea target
			oOptions.editor = document.getElementById(sId);
			oOptions.textarea = oTarget;

			// Get the format options to show the buttons on the toolbox
			if (sValues !== null) {

				aValues = sValues.split(',');

				oOptions.list = [];

				for( var nKey = 0; aValues.length > nKey; nKey++){
					oOptions.list.push(aValues[nKey]);
				}

			}

			// Call the editor with the options
			oSettings = FrontendTools.mergeOptions(self.oDefault, oOptions);

			editor = new Pen(oSettings);

			self.bindForm(sId, oTarget, oText);
			self.bindTextarea(sId, oTarget, oText);

			if (window.navigator.userAgent.indexOf('MSIE') === -1) {

				if ( oTarget.getAttribute("data-fc-html") !== null ) {
					if (oTarget.getAttribute("data-fc-html") !== 'false') {
						self.bindHtmlButton(sId, oTarget, oText);
					}
				} else {
					self.bindHtmlButton(sId, oTarget, oText);
				}


				if ( oTarget.getAttribute("data-fc-fullscreen") !== null ) {
					if (oTarget.getAttribute("data-fc-fullscreen") !== 'false') {
						self.bindScreenButton(sId, oTarget, oText);
					}
				} else {
					self.bindScreenButton(sId, oTarget, oText);
				}
			}

			if ( document.querySelectorAll ) {

				// Clean Paste

				document.querySelector("div[contenteditable]").addEventListener("paste", function(e) {
					e.preventDefault();
					var text = e.clipboardData.getData("text/plain");
					document.execCommand("insertHTML", false, text);
				});
			}

		},
		onStop: function () {
			this.sPathCss = null;
		},
		onDestroy: function () {
			delete this.sPathCss;
		}
	};
});