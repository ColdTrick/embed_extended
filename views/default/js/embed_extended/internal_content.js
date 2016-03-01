define(function(require){
	var elgg = require('elgg');
	var $ = require('jquery');
	
	return {
		init: function() {
			$('.elgg-form-embed-extended-internal-content').submit(function() {
				$('#embed-extended-internal-content-result').hide();
				$('#embed-extended-internal-content-loader').show();
				
				elgg.post($(this).attr('action'), {
					data: $(this).serialize(),
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