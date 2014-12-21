<?php

class InscripcionesController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->view->titulo = 'Inscripciones';
		$this->view->menu = 3;
	}

	public function registroAction() {
		$flagError = false;
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			//$sessionId = Zend_Session::getId();
			$request = $this->getRequest();
			$institucion = new Application_Model_DbTable_Institucion();
			$representante = new Application_Model_DbTable_Representante();
			$tutor = new Application_Model_DbTable_Tutor();
			$estudiante = new Application_Model_DbTable_Estudiante();

			$return = $institucion->add($request->getParam('codigoInstitucion'), $request->getParam('nombreInstitucion'), $request->getParam('pais'), $request->getParam('provincia'), $request->getParam('canton'), $request->getParam('ciudad'), $request->getParam('direccion'), $request->getParam('telefono'), $request->getParam('email'), $request->getParam('referencia'), $request->getParam('banco'));
			if ($return['estado'] == '1') {
				$idInstitucion = $return['id'];
				$codigo = $request->getParam('codigoInstitucion');
			} else {
				$flagError = true;
				error_log($return['msg'], 0);
				echo '0';
				return;
			}

			$return = $representante->add($idInstitucion, $request->getParam('representanteCargo'), $request->getParam('representanteNombre'), $request->getParam('ciRepresentante'), $request->getParam('mailRepresentante'), $request->getParam('telefonoRepresentante'));
			if ($return['estado'] == '0') {
				$flagError = true;
				error_log($return['msg'], 0);
				echo '0';
				return;
			}

			// Docente #1
			$return = $tutor->add($idInstitucion, $request->getParam('docenteNombre1'), $request->getParam('docenteNivel1'));
			if ($return['estado'] == '0') {
				$flagError = true;
				error_log($return['msg'], 0);
				echo '0';
				return;
			}
			// Docente #2
			if (strlen($request->getParam('docenteNombre2')) > 0)
				$tutor->add($idInstitucion, $request->getParam('docenteNombre2'), $request->getParam('docenteNivel2'));
			// Docente #3
			if (strlen($request->getParam('docenteNombre3')) > 0)
				$tutor->add($idInstitucion, $request->getParam('docenteNombre3'), $request->getParam('docenteNivel3'));
			// Docente #4
			if (strlen($request->getParam('docenteNombre4')) > 0)
				$tutor->add($idInstitucion, $request->getParam('docenteNombre4'), $request->getParam('docenteNivel4'));
			// Docente #5
			if (strlen($request->getParam('docenteNombre5')) > 0)
				$tutor->add($idInstitucion, $request->getParam('docenteNombre5'), $request->getParam('docenteNivel5'));

			// Estudiantes
			$estudiantes = json_decode($request->getParam('estudiantes'));
			foreach ($estudiantes as $fila) {
				$return = $estudiante->add($idInstitucion, $fila[0], $fila[1], $fila[2], $fila[3], $fila[4]);
				if ($return['estado'] == '0') {
					$flagError = true;
					error_log($return['msg'], 0);
					echo '0';
					return;
				}
			}
			if ($flagError == false)
				echo $codigo;
		}
	}

	public function pdfAction() {
		$this->view->titulo = 'Inscripciones';
		$this->view->menu = 3;
		
		$request = $this->getRequest();
		$id = $request->getParam('codigo');
		$sessionId = Zend_Session::getId();
		$fecha = date('d/m/Y');

		require_once(APPLICATION_PATH . '/../library/tcpdf/tcpdf.php');

		$request = $this->getRequest();
		$codigo = $request->getParam('codigo');
		$institucion = new Application_Model_DbTable_Institucion();
		$rowInstitucion = $institucion->buscar($codigo);
		$representante = new Application_Model_DbTable_Representante();
		$rowRepresentante = $representante->buscar($rowInstitucion[0]['id']);
		$tutores = new Application_Model_DbTable_Tutor();
		$rowTutores = $tutores->buscar($rowInstitucion[0]['id']);
		$estudiantes = new Application_Model_DbTable_Estudiante();
		$rowEstudiantes = $estudiantes->buscar($rowInstitucion[0]['id']);

		$html = '<table width="100%" align="center">'
				. '<tr><td width="88%" align="left"><h2>FICHA DE REGISTRO OLIMARE SG 2014</h2></td><td width="12%" align="right"><strong>' . $fecha . '</strong></td></tr>'
				. '</table>'
				. '<hr />'
				. '<br />'
				. '<p><strong>DATOS INFORMATIVOS DE LA INSTITUCIÓN</strong></p>'
				. '<br />'
				. '<table width="100%" align="center">'
				. '<tr><th align="left">Código</th><td align="left">' . $rowInstitucion[0]['codigo'] . '</td></tr>'
				. '<tr><th align="left">Nombre</th><td align="left">' . $rowInstitucion[0]['nombre'] . '</td></tr>'
				. '<tr><th align="left">País</th><td align="left">' . $rowInstitucion[0]['pais'] . '</td></tr>'
				. '<tr><th align="left">Provincia</th><td align="left">' . $rowInstitucion[0]['provincia'] . '</td></tr>'
				. '<tr><th align="left">Canton</th><td align="left">' . $rowInstitucion[0]['canton'] . '</td></tr>'
				. '<tr><th align="left">Ciudad</th><td align="left">' . $rowInstitucion[0]['ciudad'] . '</td></tr>'
				. '<tr><th align="left">Dirección</th><td align="left">' . $rowInstitucion[0]['direccion'] . '</td></tr>'
				. '<tr><th align="left">Teléfono</th><td align="left">' . $rowInstitucion[0]['telefono'] . '</td></tr>'
				. '<tr><th align="left">Correo electrónico</th><td align="left">' . $rowInstitucion[0]['email'] . '</td></tr>'
				. '<tr><th align="left">Referencia de papeleta de depósito</th><td align="left">' . $rowInstitucion[0]['referencia_deposito'] . '</td></tr>'
				. '<tr><th align="left">Nombre de la Entidad Bancaria</th><td align="left">' . $rowInstitucion[0]['banco'] . '</td></tr>'
				. '</table>'
				. '<br />'
				. '<p><strong>DOCENTE REPRESENTANTE ANTE OLIMARE</strong></p>'
				. '<br />'
				. '<table width="100%" align="center">'
				. '<tr><th align="left">Cargo</th><td align="left">' . $rowRepresentante[0]['cargo'] . '</td></tr>'
				. '<tr><th align="left">Nombre</th><td align="left">' . $rowRepresentante[0]['nombre'] . '</td></tr>'
				. '<tr><th align="left">CI / Pasaporte</th><td align="left">' . $rowRepresentante[0]['ci'] . '</td></tr>'
				. '<tr><th align="left">Correo electrónico</th><td align="left">' . $rowRepresentante[0]['email'] . '</td></tr>'
				. '<tr><th align="left">Teléfono</th><td align="left">' . $rowRepresentante[0]['telefono'] . '</td></tr>'
				. '</table>'
				. '<br />'
				. '<p><strong>INFORMACION DE TUTORES POR NIVELES</strong></p>'
				. '<br />'
				. '<table width="100%" align="center">'
				. '<tr><th width="60">#</th><th align="left">Nombre del docente</th><th>Nivel</th></tr>'
				. '<tr><td>1</td><td align="left">' . $rowTutores[0]['nombre'] . '</td><td>' . $rowTutores[0]['nivel'] . '</td></tr>'
				. '<tr><td>2</td><td align="left">' . @$rowTutores[1]['nombre'] . '</td><td>' . @$rowTutores[1]['nivel'] . '</td></tr>'
				. '<tr><td>3</td><td align="left">' . @$rowTutores[2]['nombre'] . '</td><td>' . @$rowTutores[2]['nivel'] . '</td></tr>'
				. '<tr><td>4</td><td align="left">' . @$rowTutores[3]['nombre'] . '</td><td>' . @$rowTutores[3]['nivel'] . '</td></tr>'
				. '<tr><td>5</td><td align="left">' . @$rowTutores[4]['nombre'] . '</td><td>' . @$rowTutores[4]['nivel'] . '</td></tr>'
				. '<tr><td>6</td><td align="left">' . @$rowTutores[5]['nombre'] . '</td><td>' . @$rowTutores[5]['nivel'] . '</td></tr>'
				. '</table>'
				. '<br />'
				. '<p><strong>INGRESO DE ESTUDIANTES</strong></p>'
				. '<br />'
				. '<table width="100%" align="center">'
				. '<tr><th width="60">#</th><th align="left">Apellidos</th><th align="left">Nombres</th><th>Nivel</th><th>Código asignado</th></tr>';
		$contador = 1;
		foreach ($rowEstudiantes as $row) {
			$html .= '<tr><td>' . $contador . '</td><td align="left">' . $row['apellidos'] . '</td><td align="left">' . $row['nombres'] . '</td><td>' . $row['nivel'] . '</td><td>' . $row['codigo'] . '</td></tr>';
			$contador++;
		}
		$html .= '</table><br /><hr />';

		$archivo = 'temporal/'.$sessionId.'.pdf';

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// ---------------------------------------------------------
		// set default font subsetting mode
		$pdf->setFontSubsetting(true);

		// Set font
		// dejavusans is a UTF-8 Unicode font, if you only need to
		// print standard ASCII chars, you can use core fonts like
		// helvetica or times to reduce file size.
		$pdf->SetFont('freesans', '', 10, '', true);

		// Add a page
		// This method has several options, check the source code documentation for more information.
		$pdf->AddPage();

		// Print text using writeHTMLCell()
		$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

		// ---------------------------------------------------------
		// Close and output PDF document
		// This method has several options, check the source code documentation for more information.
		$pdf->Output($archivo, 'F');
		
		$this->view->archivo = $archivo;
	}

}
