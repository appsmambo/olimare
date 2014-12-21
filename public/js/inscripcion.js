var oTable;
$(document).on('ready', function() {
	$('.numeros').keyup(function() {
		this.value = this.value.replace(/[^0-9\.]/g, '');
	});
	$('.letras').keyup(function() {
		this.value = this.value.replace(/[^A-Z a-z ñÑáéíóúÁÉÍÓÚ\.]/g, '');
	});
	$('#pais').change(function() {
		pais = $(this).val();
		if (pais != 'EC') {
			$('#provincia').fadeOut('fast', function() {
				$('#provincia2').fadeIn();
			});
		} else {
			$('#provincia2').fadeOut('fast', function() {
				$('#provincia').fadeIn();
			});
		}
	});
	var validator = $('#inscripcion').validate({
		ignore: '',
		submitHandler: function(form) {
			var alumnosArray = oTable.fnGetData();
			if (alumnosArray.length == 0) {
				alert('Debe ingresar estudiantes.');
				$('#alumnoCI').focus();
				return false;
			}
			var alumnosJSON = JSON.stringify(alumnosArray);
			$('#estudiantes').val(alumnosJSON);
			$('#botonEnviar').prop('disabled', true);
			$.ajax({
				type: "POST",
				url: 'inscripciones/registro',
				data: $('#inscripcion').serialize(),
				success: function(data) {
					if (data != '0') {
						$('input:text').val('');
						$('#email, #telefono, #mailRepresentante, #telefonoRepresentante').val('');
						oTable.dataTable().fnClearTable();
						$('#botonEnviar').prop('disabled', false);
						$.blockUI({ message: '<h1>Gracias por registrarse, sus datos fueron ingresados a nuestro sistema.</h1>' });
						window.location.assign('inscripciones/pdf/codigo/' + data);
					} else {
						$.blockUI({ message: '<h1>Se produjo un error al enviar sus datos vuelva a intentarlo.</h1>' });
					}
					setTimeout($.unblockUI, 4500);
				},
				dataType: 'text'
			});
			return false;
		}
	});
	oTable = $('#alumnos').dataTable({
		'bPaginate': false,
		'bLengthChange': false,
		'bFilter': false,
		'bSort': true,
		'bInfo': false,
		'bAutoWidth': false,
		'fnDrawCallback': function(oSettings) {
			var that = this;

			/* Need to redo the counters if filtered or sorted */
			/*if (oSettings.bSorted || oSettings.bFiltered)
			 {
			 this.$('td:first-child', {'filter': 'applied'}).each(function(i) {
			 that.fnUpdate(i + 1, this.parentNode, 0, false, false);
			 });
			 }*/
		},
		'aoColumnDefs': [
			{'bSortable': false, 'aTargets': [0]}
		],
		'aaSorting': [[1, 'asc']]
	});
	$('#alumnoAgregar').click(function() {
		rnd = Math.floor(Math.random() * (9999 - 1000 + 1)) + 1000;
		ci = $.trim($('#alumnoCI').val());
		ape = $.trim($('#alumnoApellidos').val());
		nom = $.trim($('#alumnoNombres').val());
		niv = $('#alumnoNivel').val();
		codigo = ape.charAt(0).toUpperCase() + nom.charAt(0).toUpperCase() + rnd;
		if (ci.length == 0 || ape.length == 0 || nom.length == 0) {
			alert('Verificar los datos del estudiante.')
			return false;
		}
		$('#alumnos').dataTable().fnAddData([
			ci,
			ape,
			nom,
			niv,
			codigo]);
		$('#alumnoCI').val('');
		$('#alumnoApellidos').val('');
		$('#alumnoNombres').val('');
	});
	$('#alumnos tbody tr').click(function(e) {
		if ($(this).hasClass('row_selected')) {
			$(this).removeClass('row_selected');
			$('#delete').hide();
		}
		else {
			oTable.$('tr.row_selected').removeClass('row_selected');
			$(this).addClass('row_selected');
			$('#delete').show();
		}
	});
	$('#delete').click(function() {
		var anSelected = fnGetSelected(oTable);
		if (anSelected.length !== 0) {
			oTable.fnDeleteRow(anSelected[0]);
			$('#delete').hide();
		}
	});
	$('.continuar').click(function() {
		grupo = $(this).data('grupo');
		pestana = $(this).data('pestana');
		esValido = true;
		switch (pestana) {
			case '#pestana2':
				esValido = validator.element('#codigoInstitucion');
				esValido = validator.element('#nombreInstitucion');
				esValido = validator.element('#pais');
				esValido = validator.element('#provincia');
				esValido = validator.element('#direccion');
				esValido = validator.element('#telefono');
				esValido = validator.element('#email');
				esValido = validator.element('#referencia');
				esValido = validator.element('#banco');
				break;
			case '#pestana3':
				esValido = validator.element('#representanteNombre');
				esValido = validator.element('#ciRepresentante');
				esValido = validator.element('#mailRepresentante');
				esValido = validator.element('#telefonoRepresentante');
				break;
			case '#pestana4':
				esValido = validator.element('#docenteNombre1');
				break;
		}
		if (!esValido) {
			validator.valid();
			return false;
		}
		$('.pestana').removeClass('btn-primary').addClass('btn-default');
		$(pestana).removeClass('btn-default').addClass('btn-primary');
		$('fieldset').fadeOut('fast', function() {
			$(grupo).show();
		});
		return false;
	});
});

function fnGetSelected(oTableLocal) {
	return oTableLocal.$('tr.row_selected');
}