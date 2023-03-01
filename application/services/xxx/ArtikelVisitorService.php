<?php
class ArtikelVisitorService {

	function __construct() 
	{
		$this->artikel_visitor = new ArtikelVisitor();
	}

	public function getAllData()
	{
		$hari_ini = date('Y-m-d');
		$kemarin = date("Y-m-d",mktime(0,0,0,date('m'),date('d')-1,date('Y')));;

		$db = Zend_Registry::get('db');
		$sql = "SELECT 'Jumlah Pengunjung Hari Ini' AS keterangan, SUM(counter) AS jumlah
				FROM artikel_visitor
				WHERE status = 1 AND DATE_FORMAT(tanggal, '%Y-%m-%d') = ?
				UNION ALL
				SELECT 'Jumlah Pengunjung Kemarin' AS keterangan, IFNULL(SUM(counter), 0) AS jumlah
				FROM artikel_visitor
				WHERE status = 1 AND DATE_FORMAT(tanggal, '%Y-%m-%d') = ?
				UNION ALL
				SELECT 'Total Pengunjung' AS keterangan, SUM(counter) AS jumlah
				FROM artikel_visitor
				WHERE status = 1";

		$stmt = $db->query($sql, array($hari_ini, $kemarin));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();	
		return $result;
	}

	public function addData($id_artikel, $ip_address, $counter, $browser, $http_user_agent)
	{
		$user_log = $ip_address;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'id_artikel' => $id_artikel,
			'tanggal' => $tanggal_log,
			'ip_address' => $ip_address,
			'counter' => $counter,
			'browser' => $browser,
			'http_user_agent' => $http_user_agent,
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->artikel_visitor->insert($params);
	}
}