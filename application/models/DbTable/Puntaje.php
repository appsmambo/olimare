<?php

class Application_Model_DbTable_Puntaje extends Zend_Db_Table_Abstract
{

    protected $_name = 'puntaje';

	public function add($jurado, $estudiante, $rl, $op, $total)
	{
		$data = array('jurado' => $jurado, 
					  'estudiante' => $estudiante, 
					  'rl' => $rl, 
					  'op' => $op,
					  'total' => $total);
		try {
			$this->insert($data);
			return array('estado' => '1');
		} catch (Exception $ex) {
			return array('estado' => '0', 'msg' => $ex->getMessage());
		}
	}

	public function buscar($estudiante)
	{
		$select = $this->select()->where('estudiante = ?', $estudiante);
		$rows = $this->fetchAll($select);
		return $rows->toArray();
	}

}

