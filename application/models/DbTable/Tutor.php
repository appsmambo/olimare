<?php

class Application_Model_DbTable_Tutor extends Zend_Db_Table_Abstract
{

    protected $_name = 'tutor';

	public function add($institucion, $nombre, $nivel)
	{
		$data = array('institucion' => $institucion, 
					  'nombre' => $nombre,
					  'nivel' => $nivel);
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
	
	public function reporte()
	{
		$select = $this->select()
					   ->from($this, array('nombre', 'nivel'));
		$rows = $this->fetchAll($select);
		return $rows->toArray();
	}
	
	public function reporteSG()
	{
		$select = $this->select()
					   ->from($this, array('nombre', 'nivel'));
		$rows = $this->fetchAll($select);
		return $rows->toArray();
	}

}

