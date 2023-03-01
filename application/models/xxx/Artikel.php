<?php
class Artikel extends Zend_Db_Table 
{
	protected $_name;
    protected $_schema;
	protected $_db;

    public function init() 
    {
        $this->_name = 'artikel';
        $this->_schema  = 'db_diparlin';
        $this->_db = Zend_Registry::get('db');
    }
}