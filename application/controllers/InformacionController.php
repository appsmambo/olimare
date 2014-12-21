<?php

class InformacionController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->_forward('/reglamento');
	}

	public function reglamentoAction() {
		$this->view->titulo = 'Reglamento';
		$this->view->menu = 21;
	}

	public function basesDelConcursoAction() {
		$this->view->titulo = 'Bases del Concurso';
		$this->view->menu = 22;
	}

}
