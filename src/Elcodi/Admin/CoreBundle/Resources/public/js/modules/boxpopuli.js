TinyCore.AMD.define('boxpopuli', ['md5','wysiwyg'], function () {
    return {
        md5 : TinyCore.Module.instantiate( 'md5' ),
        wysiwyg : TinyCore.Module.instantiate( 'wysiwyg' ),
        token: '',
        authorName: '',
        authorEmail: '',
        authorGravatar: '',
        context: '',
        source: '',
        routeList: '',
        routeAdd: '',
        /**
         * Init the Boxpopuli environment
         *
         * @param $bxp The boxpopuli html placeholder
         */
        init: function($bxp) {

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

            this.wysiwyg.onStart();
        },
        /**
         * Create comment area in given wrapper object
         *
         * @param $wrapper Object with class .wrapper
         */
        createCommentNewArea: function($wrapper) {

            var $newCommentContainer = $wrapper
                .find('.bxp-new-response')
                .first();

            $newCommentContainer.html(
                '<div class="grid">' +
                    '<form class="form box-lighten">' +
                        '<div class="col-1-12 tablet desktop">' +
                            '<img class="thumbnail" src="' + this.authorGravatar + '" />' +
                        '</div>' +
                        '<div class="col-11-12">' +
                            '<ol>' +
                                '<li class="mb-n">' +
                                    '<textarea data-tc-modules="wysiwyg" data-tc-fullscreen="false" data-tc-html="false"></textarea>' +
                                '</li><li>' +
                                    '<button type="submit" class="bxp-add-button button-primary">Comment</button>' +
                                '</li>' +
                            '</div>' +
                    '</form>' +
                '</div>');
        },
        /**
         * Create comment list
         *
         * @param $wrapper Object with class .wrapper
         */
        buildCommentList: function($wrapper) {

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
                success: function(comments){

                    $.each(comments, function(_, comment) {

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
        initializeCommentWrapper: function($o, commentId) {

            $o.append('<div class="bxp-wrapper" data-comment-id="' + commentId + '">' +
            '<div class="bxp-comment"></div>' +
            '<div class="bxp-response-block" style="margin-left:20px">' +
            '<div class="bxp-new-response"></div>' +
            '<div class="bxp-responses">' +
            '</div>' +
            '</div>' +
            '</div>');
        },
        /**
         * Once a user click add, add this comment into the environment
         *
         * @param $o Object
         */
        registerAddComment: function ($o) {

            var self = this;

            $o.on('click', '.bxp-new-response .bxp-add-button', function() {

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
                parentCommentId = parseInt( parentCommentId, 10 );

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
                    success: function(comment){

                        $contentTextarea.val('');
                        var $commentRendered = self.createCommentItem($responseArea, comment);
                        $commentWrapper
                            .find('.bxp-responses')
                            .first()
                            .prepend($commentRendered);

                        if (parentCommentId > 0) {

                            $newCommentArea.html('');
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
        createCommentLayout: function($mainLayout) {

            $mainLayout.html('<div class="box bxp-container"></div>');
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
        createCommentItem: function($responsesContainer, comment) {

            var self = this;
            var $commentObject = $('<div/>');
            var entity = comment.entity;
            var children = comment.children;
            var commentId = entity.id;
            var authorGravatar = 'http://www.gravatar.com/avatar/' + this.md5.convert(entity.authorEmail) + '?s=32';

            /**
             * We initialize with the skeleton
             */
            self.initializeCommentWrapper($commentObject, commentId);

            var $responsesZone = $commentObject.find('.bxp-response-block .bxp-responses').first();

            $.each(children, function(_, childComment) {

                self.createCommentItem($responsesZone, childComment);
            });

            $commentObject
                .find('.bxp-comment')
                .first()
                .html('' +
                '<div class="box grid">' +
                '<div class="col-1-12">' +
                '<img class="thumbnail" src="' + authorGravatar + '" />' +
                '</div>' +
                '<div class="col-10-12">' +
                '<div class="bxp-actions">' +
                'Done by ' + entity.authorName + ' - ' +
                entity.createdAt + ' - ' +
                '<a href="#" class="bxp-add-response"><i class="icon-comment"></i> Reply</a>' +
                '</div>' +
                '' + entity.content + '' +
                '</div>' +
                '<div class="col-1-12 ta-c">' +
                '</div>' +
                '</div>'
            );

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
            $o.on('click', 'a.bxp-add-response', function() {

                var $commentWrapper = $(this).closest('.bxp-wrapper');
                self.createCommentNewArea($commentWrapper);

                self.wysiwyg.onStart();

                return false;
            });
        },
        onStart: function () {

            var self = this,
                aTargets = oTools.getDataModules('boxpopuli');

            $(aTargets).each(function () {
                self.init( $(this) );
            });
        }
    };
});
