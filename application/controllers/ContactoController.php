<?php

class ContactoController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->view->titulo = 'Contacto';
		$this->view->menu = 8;
	}

}
