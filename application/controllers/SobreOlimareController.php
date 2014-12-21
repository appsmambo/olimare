<?php

class SobreOlimareController extends Zend_Controller_Action {

	public function init() {
		/* Initialize action controller here */
	}

	public function indexAction() {
		$this->view->titulo = 'Sobre OLIMARE';
		$this->view->menu = 1;
	}

}
