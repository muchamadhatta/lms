<?php
class ArtikelImage extends Zend_Db_Table 
{
	protected $_name;
    protected $_schema;
	protected $_db;

    public function init() 
    {
        $this->_name = 'artikel_image';
        $this->_schema  = 'db_diparlin';
        $this->_db = Zend_Registry::get('db');
    }
}