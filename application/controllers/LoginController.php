<?php

class LoginController extends Zend_Controller_Action {

	private $_baseUrl = null;
	private $_logged = null;

	public function init() {
		$this->_baseUrl = $this->getFrontController()->getBaseUrl();
		$this->_logged = new Zend_Session_Namespace('logged');
	}

	public function indexAction() {
		$this->view->titulo = 'Ingresar al sistema';
		$this->view->menu = 0;
	}

	public function authenticateAction() {
		if ($this->getRequest()->isPost()) {
			$request = $this->getRequest();
			$username = $request->getParam('usuario');
			$password = $request->getParam('clave');
			if ($username == 'admin' && $password == 'olimare') {
				$this->_logged->success = true;
				$this->_redirect('/puntajes');
				return;
			}
		}
		$this->view->mensaje = 'Acceso no autorizado.';
		$this->_forward('/index');
	}

	public function logoutAction() {
		$this->_logged->success = false;
		$this->_forward('/index');
	}

}
