FrontendCore.define('boxpopuli', ['md5'], function () {
	return {
		md5: TinyCore.Module.instantiate('md5'),
		token: '',
		authorName: '',
		authorEmail: '',
		authorGravatar: '',
		context: '',
		source: '',
		routeList: '',
		routeAdd: '',
		templates: {},
		/**
		 * Init the Boxpopuli environment
		 *
		 * @param $bxp The boxpopuli html placeholder
		 */
		init: function ($bxp) {

			$bxp.html('');
			this.token = $bxp.data('token');
			this.authorName = $bxp.data('author-name');
			this.authorEmail = $bxp.data('author-email');
			this.authorGravatar = 'http://www.gravatar.com/avatar/' + this.md5.convert(this.authorEmail) + '?s=32';
			this.context = $bxp.data('context');
			this.source = $bxp.data('source');
			this.routeList = $bxp.data('route-list');
			this.routeAdd = $bxp.data('route-add');

			this.createCommentLayout($bxp);

		},
		/**
		 * Create comment area in given wrapper object
		 *
		 * @param $wrapper Object with class .wrapper
		 */
		createCommentNewArea: function ($wrapper, sSide) {

			var $newCommentContainer = $wrapper.find('.bxp-new-response').first(),
				self = this;

			$newCommentContainer.html(self.templates.commentNew.render({
				urlAvatar: self.authorGravatar,
				authorName: self.authorName,
				commentSide: sSide
			}));
		},
		/**
		 * Create comment list
		 *
		 * @param $wrapper Object with class .wrapper
		 */
		buildCommentList: function ($wrapper) {

			var self = this;
			var $responsesContainer = $wrapper
				.find('.bxp-response-block .bxp-responses')
				.first();
			$responsesContainer.html();

			$.ajax({
				type: "GET",
				url: self.routeList,
				dataType: "json",
				async: true,
				success: function (comments) {

					$.each(comments, function (_, comment) {

						self.createCommentItem($responsesContainer, comment);
					});
				}
			});
		},
		/**
		 * Initialize comment wrapper
		 *
		 * Initializes the comment area
		 * Initializes the flash area
		 * Initializes the response block are
		 * Initializes the new response area
		 * Initializes the responses area
		 *
		 * @param $o Object where to prepend a wrapper
		 */
		initializeCommentWrapper: function ($o, commentId) {

			var self = this;

			$o.append(self.templates.commentWrapper.render({
				commentId: commentId
			}));
		},
		/**
		 * Once a user click add, add this comment into the environment
		 *
		 * @param $o Object
		 */
		registerAddComment: function ($o) {

			var self = this;

			$o.on('click', '.bxp-new-response .bxp-remove-textarea', function () {
				var $this = $(this);
				$this.closest('.bxp-new-response').html('');
			});



			$o.on('click', '.bxp-new-response .bxp-add-button', function () {

				var $this = $(this);
				var $commentWrapper = $this.closest('.bxp-wrapper');
				var $newCommentArea = $this.closest('.bxp-new-response');
				var $responseArea = $commentWrapper.closest('.bxp-response-block .bxp-responses');
				var $contentTextarea = $newCommentArea
					.find('textarea')
					.first();
				var content = $contentTextarea.val();

				if (!content) {

					self.createFlash($commentWrapper, 'You must add some text...', 'info');
					return false;
				}

				var parentCommentId = $commentWrapper.data('comment-id');
				parentCommentId = parseInt(parentCommentId, 10);

				$.ajax({
					type: "POST",
					url: self.routeAdd,
					dataType: 'json',
					data: {
						content: content,
						parent: parentCommentId,
						author_name: self.authorName,
						author_email: self.authorEmail
					},
					async: true,
					success: function (comment) {

						$contentTextarea.val('');
						var $commentRendered = self.createCommentItem($responseArea, comment, parentCommentId);
						$commentWrapper
							.find('.bxp-responses')
							.first()
							.append($commentRendered);

						if (parentCommentId > 0) {

							$newCommentArea.html('');
						} else {
							$('#' + $contentTextarea[0].id).html('');
						}
					}
				});

				return false;
			});
		},
		/**
		 * Create the Boxpopuli comments area
		 *
		 * @param $mainLayout Main layout
		 */
		createCommentLayout: function ($mainLayout) {

			$mainLayout.html('<div class="bxp-container"></div>');
			var $container = $mainLayout.find('.bxp-container');

			/**
			 * Create the main wrapper
			 */
			this.initializeCommentWrapper($container, 0);

			/**
			 * Initialize the main wrapper
			 */
			var $wrapper = $container.find('.bxp-wrapper').first();
			this.createCommentNewArea($wrapper);
			this.buildCommentList($wrapper);

			/**
			 * Register all listeners
			 */
			this.registerAddComment($container);
			this.registerResponseAddComment($container);
		},
		/**
		 * Create comment item
		 *
		 * Given responses container, create a new comment and append it
		 * at the end of the responses
		 *
		 * @param $responsesContainer The responses container
		 * @param comment The comment
		 */
		createCommentItem: function ($responsesContainer, comment, parentCommentId) {

			var self = this;
			var $commentObject = $('<div/>');
			var entity = comment.entity;
			var children = comment.children;
			var commentId = entity.id;
			var authorGravatar = 'http://www.gravatar.com/avatar/' + this.md5.convert(entity.authorEmail) + '?s=32';
			var sSide = parentCommentId !== undefined && parentCommentId > 0 ? 'right' : 'left';
			var sTargetComment = parentCommentId !== undefined && parentCommentId > 0 ? parentCommentId : commentId;

			/**
			 * We initialize with the skeleton
			 */
			self.initializeCommentWrapper($commentObject, sTargetComment);

			var $responsesZone = $commentObject.find('.bxp-response-block .bxp-responses').first();

			$.each(children, function (_, childComment) {

				self.createCommentItem($responsesZone, childComment, commentId );


			});

			$commentObject
				.find('.bxp-comment')
				.first()
				.html(self.templates.commentItem.render({
					urlAvatar: authorGravatar,
					authorName: entity.authorName,
					commentDate: entity.createdAt,
					commentText: entity.content,
					commentSide: sSide,
					targetId: sTargetComment
				}));

			$commentObject.prependTo($responsesContainer);

			return $commentObject;
		},
		/**
		 * Register respond comment
		 *
		 * @param $o Object
		 */
		registerResponseAddComment: function ($o) {

			var self = this;
			$o.on('click', 'a.bxp-add-response', function () {

				var $commentWrapper = $('#' + this.href.replace('response','comment').split('#')[1]);

				self.createCommentNewArea($commentWrapper, 'right');

			});

		},
		setTemplate: function (sName) {
			this.templates[sName] = twig({
				href: oGlobalSettings.sPathJsTwig + sName + '.html.twig',
				async: false
			});
		},
		onStart: function () {

			var self = this,
				aTargets = FrontendTools.getDataModules('boxpopuli');

			self.setTemplate('commentItem');
			self.setTemplate('commentWrapper');
			self.setTemplate('commentNew');
			self.setTemplate('commentForm');

			$(aTargets).each(function () {
				self.init($(this));
			});
		}
	};
});
