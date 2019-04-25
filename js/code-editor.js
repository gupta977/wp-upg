 'use strict';
 (function($){
    $(function(){
		if( $('#personal_up').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
					mode:'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_up'), editorSettings );
        }
		
        if( $('#personal_main').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
					mode:'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_main'), editorSettings );
        }
		
		if( $('#personal_down').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
					mode:'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_down'), editorSettings );
        }
			if( $('#personal_pick').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
					mode:'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_pick'), editorSettings );
        }


        if( $('#personal_form_post').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
                    mode: 'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_form_post'), editorSettings );
        }
		  if( $('#personal_post_youtube').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
                    mode: 'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_post_youtube'), editorSettings );
        }
		
		    if( $('#personal_form_edit').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
                    mode: 'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_form_edit'), editorSettings );
        }
		  if( $('#personal_edit_youtube').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
                    mode: 'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#personal_edit_youtube'), editorSettings );
        }
		
		if( $('#newcontent').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					lineNumbers: false,
                    mode: 'php',
                }
            );
            var editor = wp.codeEditor.initialize( $('#newcontent'), editorSettings );
        }

        if( $('#code_editor_page_css').length ) {
            var editorSettings = wp.codeEditor.defaultSettings ? _.clone( wp.codeEditor.defaultSettings ) : {};
            editorSettings.codemirror = _.extend(
                {},
                editorSettings.codemirror,
                {
                    indentUnit: 2,
                    tabSize: 2,
					
                    mode: 'css',
                }
            );
            var editor = wp.codeEditor.initialize( $('#code_editor_page_css'), editorSettings );
        }
    });
 })(jQuery);