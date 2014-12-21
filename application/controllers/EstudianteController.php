<?php

class EstudianteController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		// action body
	}

	public function buscarAction() {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$request = $this->getRequest();
			$codigo = $request->getParam('codigo');
			$ci = $request->getParam('ci');
			$estudiante = new Application_Model_DbTable_Estudiante();
			$result = $estudiante->buscar2($codigo, $ci);
			if (count($result))
				echo json_encode(array('error' => 0, 'id' => $result[0]['id'], 'codigo' => $result[0]['codigo'], 'ci' => $result[0]['ci'], 'apellidos' => $result[0]['apellidos'], 'nombres' => $result[0]['nombres'], 'nivel' => $result[0]['nivel']));
			else
				echo json_encode(array('error' => 1));
		}
		
	}

}
