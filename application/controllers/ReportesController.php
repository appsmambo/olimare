<?php

class ReportesController extends Zend_Controller_Action
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
        $this->view->titulo = 'Reportes';
		$this->view->menu = 72;
    }

    public function institucionAction()
    {
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$institucion = new Application_Model_DbTable_Institucion();
			$rows = $institucion->reporte();
			echo json_encode($rows);
		}
	}

    public function institucionSgAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$institucion = new Application_Model_DbTable_Institucion();
			$rows = $institucion->reporteSG();
			echo json_encode($rows);
		}
    }

    public function estudianteAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$request = $this->getRequest();
			$estudiante = new Application_Model_DbTable_Estudiante();
			$rows = $estudiante->reporte($request->getParam('nivel'));
			echo json_encode($rows);
		}
    }

    public function estudianteSgAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$estudiante = new Application_Model_DbTable_Estudiante();
			$rows = $estudiante->reporteSG();
			echo json_encode($rows);
		}
    }
	
	public function docenteAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$docente = new Application_Model_DbTable_Tutor();
			$rows = $docente->reporte();
			echo json_encode($rows);
		}
    }
	
	public function docenteSgAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$docente = new Application_Model_DbTable_Tutor();
			$rows = $docente->reporte();
			echo json_encode($rows);
		}
    }
	
	public function docenteNivelAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$docente = new Application_Model_DbTable_Tutor();
			$rows = $docente->reporte();
			echo json_encode($rows);
		}
    }
	
	public function docenteNivelSgAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$docente = new Application_Model_DbTable_Tutor();
			$rows = $docente->reporte();
			echo json_encode($rows);
		}
    }
	
	public function estudianteNivelAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$estudiante = new Application_Model_DbTable_Estudiante();
			$rows = $estudiante->reporte();
			echo json_encode($rows);
		}
    }

    public function estudianteNivelSgAction()
    {
        $this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if ($this->getRequest()->isPost()) {
			$estudiante = new Application_Model_DbTable_Estudiante();
			$rows = $estudiante->reporteSG();
			echo json_encode($rows);
		}
    }

}
