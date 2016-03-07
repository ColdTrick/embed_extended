define(['jquery', 'elgg'], function($, elgg) {

	var textAreaId;
	
	/**
	 * Helper function to close embedded windows opened in a lightbox
	 */
	var lightbox_close = function(event) {

		if ($("#cboxOriginalContent").length) {

			$("#cboxLoadedContent").remove();
			$("#cboxOriginalContent").attr("id", "cboxLoadedContent").show();
		
			$("#cboxClose").unbind();
			$("#cboxClose").bind("click", elgg.ui.lightbox.close);
		} else {
			elgg.ui.lightbox.close();
		}
		
		return false;
	};
	
	/**
	 * Helper function to insert into the editor
	 *
	 * @param {String} hook
	 * @param {String} type
	 * @param {Object} params
	 * @param {String|Boolean} value
	 * @returns {String|Boolean}
	 */
	var insert_ckeditor = function(hook, type, params, value) {
		var textArea = $('#' + params.textAreaId);
		var content = params.content;
	 	if ($.fn.ckeditorGet) {
			try {
				var editor = textArea.ckeditorGet();
	 			var selection = editor.getSelection().getSelectedText();
			    
				if (selection) {
					var $content = $(content);
					if ($content.is("a")) {
						$content.html(selection);
						content = $content.prop('outerHTML');
					}
				}
	
				editor.insertHtml(content);
				return false;
			} catch (e) {
				// do nothing.
			}
		}
	};
	
	/**
	 * Inserts data attached to an embed list item in textarea
	 *
	 * @param {Object} event
	 * @return void
	 */
	var insert = function(event) {
		var textArea = $('#' + textAreaId);
	
		// generalize this based on a css class attached to what should be inserted
		var content = ' ' + $(this).find(".embed-insert").parent().html() + ' ';
		var value = textArea.val();
		var result = textArea.val();
	
		// this is a temporary work-around for #3971
		if (content.indexOf('thumbnail.php') != -1) {
			content = content.replace('size=small', 'size=medium');
		}
	
		textArea.focus();
	
		if (!elgg.isNullOrUndefined(textArea.prop('selectionStart'))) {
			var cursorPos  = textArea.prop('selectionStart');
			var textBefore = value.substring(0, cursorPos);
			var textAfter  = value.substring(cursorPos, value.length);
			result = textBefore + content + textAfter;
	
		} else if (document.selection) {
			// IE compatibility
			var sel = document.selection.createRange();
			sel.text = content;
			result = textArea.val();
		}
	
		// See the ckeditor plugin for an example of this hook
		result = elgg.trigger_hook('embed', 'editor', {
			textAreaId: textAreaId,
			content: content,
			value: value,
			event: event
		}, result);
	
		if (result || result === '') {
			textArea.val(result);
		}
		
		event.preventDefault();
		event.stopPropagation();
		event.stopImmediatePropagation();
	
		lightbox_close();
	};
	
	var move_lighbox_content = function() {
		
		$('#cboxLoadedContent').attr('id', 'cboxOriginalContent').hide();
		$('#cboxOriginalContent').after('<div id="cboxLoadedContent"></div>');	
		
		$('#cboxLoadingOverlay').show();
		
		$('#cboxClose').unbind();
		$('#cboxClose').bind('click', lightbox_close);
	};
	
	var detect_lightbox = function(event) {
		if ($('#cboxLoadedContent').length) {
			move_lighbox_content();
			
			var href = $(this).attr('href');
			elgg.get(href, {
				success: function(data) {
					
					$('#cboxLoadedContent').html(data);
	
					$('#cboxLoadingOverlay').hide();
					$(document).off('click', '.embed-item');
					$(document).on('click', '.embed-item', insert);
					
					$.colorbox.resize();
				}
			});
		} else {
			opts = {};
			// merge opts into defaults
			opts = $.extend({}, elgg.ui.lightbox.getSettings(), opts);
	
			var $this = $(this),
				href = $this.prop('href') || $this.prop('src'),
				dataOpts = $this.data('colorboxOpts');
			// Q: why not use "colorbox"? A: https://github.com/jackmoore/colorbox/issues/435
	
			if (!$.isPlainObject(dataOpts)) {
				dataOpts = {};
			}
	
			// merge data- options into opts
			$.colorbox($.extend({href: href}, opts, dataOpts));
		}
		
		event.preventDefault();
	};
	
	/**
	 * custom lightbox initialization to fix issue with embed loaded in a lightbox
	 */
	var init = function() {
		$(document).on('click', '.elgg-embed-lightbox', detect_lightbox);
	
		// need to reregister
		$(document).off('click', '.embed-item');
		$(document).on('click', '.embed-item', insert);
		// caches the current textarea id
		$(document).on('click', '.embed-control', function() {
			textAreaId = /embed-control-(\S)+/.exec($(this).attr('class'))[0];
			textAreaId = textAreaId.substr("embed-control-" . length);
	
			//elgg.embed_extended.selectedText = $('#' + elgg.embed_extended.textAreaId).ckeditorGet().getSelection().getNative().toString();
		});
	
		elgg.register_hook_handler('embed', 'editor', insert_ckeditor);
	};
	
	elgg.register_hook_handler('init', 'system', init);
});
