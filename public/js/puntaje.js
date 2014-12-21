var oTable;
$(document).on('ready', function() {
	$('.numeros').keyup(function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	$('.letras').keyup(function() {
		this.value = this.value.replace(/[^A-Z a-z ñÑáéíóúÁÉÍÓÚ\.]/g, '');
	});
	$('#buscarEstudiante').click(function() {
		var codigo, ci;
		codigo = $('#codigo').val();
		ci = $('#ci').val();
		$('img', this).fadeIn();
		$.ajax({
			type: "POST",
			url: 'estudiante/buscar',
			data: 'codigo=' + codigo + '&ci=' + ci,
			success: function(data) {
				$('#alumnos tbody').html('');
				$('#ingreso').fadeIn('fast');
				if (data.error) {
					$('#alumnos tbody').append('<tr class="danger"><td colspan="5">No se encontraron registros.</td></tr>');
				} else {
					$('#alumnos tbody').append('<tr class="success"><td>'+data.ci+'</td><td>'+data.apellidos+'</td><td>'+data.nombres+'</td><td>'+data.nivel+'</td><td>'+data.codigo+'</td></tr>');
					$('#id').val(data.id);
					$('fieldset', '#ingreso').fadeIn();
				}
			},
			dataType: 'json'
		});
		$('img', this).fadeOut();
	});
	$('#puntaje').validate({
		ignore: '',
		submitHandler: function(form) {
			confirmar = confirm('GRABAR PUNTAJE? clic en Aceptar para continuar.');
			if (!confirmar) return;
			$('#grabarPuntaje').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: 'puntajes/grabar',
				data: $('#puntaje').serialize(),
				success: function(data) {
					if (data == '1') {
						$('input:text').val('');
						$('#grabarPuntaje').prop('disabled', false);
						$.blockUI({ message: '<h1>Puntaje ingresado correctamente.</h1>' });
					} else {
						$.blockUI({ message: '<h1>Se produjo un error, vuelva a intentarlo.</h1>' });
					}
					setTimeout($.unblockUI, 4500);
				},
				dataType: 'text'
			});
			return false;
		}
	});
});