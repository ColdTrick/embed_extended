define(['jquery', 'elgg/Ajax'], function($, Ajax){
	var ajax = new Ajax(false);
	
	return {
		init: function() {
			$('.elgg-form-embed-extended-internal-content').submit(function() {
				$('#embed-extended-internal-content-result').hide();
				$('#embed-extended-internal-content-loader').show();
				
				ajax.view('embed_extended/list', {
					method: 'POST',
					data: ajax.objectify(this),
					success: function(data) {
						$('#embed-extended-internal-content-result').html(data);
						
						$('#embed-extended-internal-content-loader').hide();
						$('#embed-extended-internal-content-result').show();
					}
				});
				
				return false;
			});
		}
	};
});