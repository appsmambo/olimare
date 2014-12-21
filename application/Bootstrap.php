<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initOlimare()
	{
		Zend_Session::start();
	}

}

