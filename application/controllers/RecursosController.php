<?php

class RecursosController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->_forward('/bancoDePruebasAction');
	}

	public function bancoDePruebasAction() {
		$this->view->titulo = 'Banco de pruebas';
		$this->view->menu = 41;
	}

	public function solucionariosAction() {
		$this->view->titulo = 'Solucionarios';
		$this->view->menu = 42;
	}

}
