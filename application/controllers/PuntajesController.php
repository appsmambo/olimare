<?php

class PuntajesController extends Zend_Controller_Action
{

    private $_logged = null;

    public function init()
    {
		$this->_logged = new Zend_Session_Namespace('logged');
    }

    public function preDispatch()
    {
		if ($this->_logged->success === false) {
			$this->_redirect('/login');
		}
    }

    public function indexAction()
    {
		$this->_forward('/ingreso');
    }

    public function ingresoAction()
    {
		$this->view->titulo = 'Ingreso de Puntajes';
		$this->view->menu = 71;
    }

    public function reportesAction()
    {
		$this->view->titulo = 'Reportes';
		$this->view->menu = 72;
    }

    public function grabarAction()
    {
        $flagError = false;
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$request = $this->getRequest();
			$puntaje = new Application_Model_DbTable_Puntaje();
			$return = $puntaje->add($request->getParam('jurado'), $request->getParam('id'), $request->getParam('razonamiento'), $request->getParam('operatoria'), $request->getParam('total'));
			if ($return['estado'] == '1') {
				echo '1';
			} else {
				$flagError = true;
				error_log($return['msg'], 0);
				echo '0';
			}
		}
    }


}


