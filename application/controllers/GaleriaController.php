<?php

class GaleriaController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->view->titulo = 'Galería';
		$this->view->menu = 6;
	}

}
