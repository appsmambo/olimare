<?php

class Application_Model_DbTable_Representante extends Zend_Db_Table_Abstract
{

    protected $_name = 'representante';

	public function add($institucion, $cargo, $nombre, $ci, $email, $telefono)
	{
		$data = array('institucion' => $institucion, 
					  'cargo' => $cargo, 
					  'nombre' => $nombre, 
					  'ci' => $ci,
					  'email' => $email,
					  'telefono' => $telefono);
		try {
			$this->insert($data);
			return array('estado' => '1');
		} catch (Exception $ex) {
			return array('estado' => '0', 'msg' => $ex->getMessage());
		}
	}

	public function buscar($idInstitucion)
	{
		$select = $this->select()->where('institucion = ?', $idInstitucion);
		$rows = $this->fetchAll($select);
		return $rows->toArray();
	}

}

