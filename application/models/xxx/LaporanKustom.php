<?php
class LaporanKustom extends Zend_Db_Table {
	protected $_name;
    protected $_schema;
	protected $_adapter;

    public function init() 
    {
        $this->_name = 'laporan_kustom';
        $this->_schema  = 'db_diparlin';
        $this->_db = Zend_Registry::get('db');
    }
}