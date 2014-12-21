$(document).on('ready', function() {
	$('.pestana').click(function() {
		$('.pestana').removeClass('btn-primary').addClass('btn-default');
		$(this).removeClass('btn-default').addClass('btn-primary');
		bloque = $(this).prop('rel');
		$('fieldset').fadeOut('fast', function() {
			$('#' + bloque).show();
		});
		return false;
	});
	$('#slider').nivoSlider();
});