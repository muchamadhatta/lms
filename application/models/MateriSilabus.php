<?php
class MateriSilabus extends Zend_Db_Table 
{
	protected $_name;
    protected $_schema;
	protected $_db;

    public function init() 
    {
        $this->_name = 'materi_silabus';
        $this->_schema  = 'db_mooc';
        $this->_db = Zend_Registry::get('db');
    }
}