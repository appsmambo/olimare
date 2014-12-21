<?php

class IndexController extends Zend_Controller_Action {

	public function init() {
		$logged = new Zend_Session_Namespace('logged');
		$logged->success = false;
	}

	public function indexAction() {
		$this->_redirect('/sobre-olimare');
	}

}
