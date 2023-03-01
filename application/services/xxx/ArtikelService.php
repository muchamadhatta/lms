<?php
class ArtikelService 
{
	  
 	function __construct() 
	{
		$this->artikel = new Artikel();
	}

	function getAllKeywordData()
	{ 
		$sql = "SELECT GROUP_CONCAT(a.tag SEPARATOR ',') AS judul
				FROM artikel a
				WHERE a.status = 1;";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetch();
		return $result;
	}

	function getDefaultArchivesByMonthData()
	{ 
		$sql = "SELECT DATE_FORMAT(tanggal, '%m%Y') AS id, DATE_FORMAT(tanggal, '%M %Y') AS keterangan, COUNT(*) AS jumlah
				FROM artikel
				GROUP BY DATE_FORMAT(tanggal, '%M %Y')
				ORDER BY tanggal DESC";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($id_subtipe_artikel));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultArchivesByCategoriesData()
	{ 
		$sql = "SELECT a.id, a.subtipe_artikel AS keterangan, COUNT(*) AS jumlah
				FROM subtipe_artikel a
				JOIN artikel b ON a.id = b.id_subtipe_artikel
				GROUP BY a.subtipe_artikel";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($id_subtipe_artikel));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultMonthlyData($tanggal)
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND DATE_FORMAT(a.tanggal, '%m%Y') = ?
				ORDER BY a.tanggal DESC";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($tanggal));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultSearchData($id)
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.judul LIKE ?
				ORDER BY a.tanggal DESC";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array('%'.$id.'%'));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultFilterData($id_subtipe_artikel)
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.id_subtipe_artikel = ?
				ORDER BY a.tanggal DESC";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($id_subtipe_artikel));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultAllData($page)
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1
				ORDER BY a.tanggal DESC
				LIMIT ".$page.",3";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultTopStoriesGroupData()
	{ 
		$sql = "SELECT a.tipe_artikel, c.judul, c.konten, c.id, d.file_name
				FROM tipe_artikel a
				/*LEFT JOIN subtipe_artikel b ON a.id = b.id_tipe_artikel AND b.status = 1*/
				LEFT JOIN artikel c ON a.id = c.id_tipe_artikel AND c.status = 1 AND c.status_artikel_utama = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.status_artikel_utama = 1 AND c.judul IS NOT NULL
				ORDER BY a.id, c.tanggal DESC	";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultTopStoriesData()
	{ 
		$sql = "SELECT a.*, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON a.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.status_artikel_utama = 1
				ORDER BY RAND()
				LIMIT 5";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultLatestData()
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1
				ORDER BY a.tanggal DESC, a.id DESC
				LIMIT 3";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultAllLatestData($id_tipe_artikel)
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND b.id_tipe_artikel = ?
				ORDER BY a.tanggal DESC, a.id DESC
				LIMIT 5";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($id_tipe_artikel));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultChoiceData()
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.status_pilihan = 1
				ORDER BY a.tanggal DESC
				LIMIT 5";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultArchiveData()
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1
				ORDER BY a.tanggal DESC
				LIMIT 5";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}

	function getDefaultPopularData()
	{ 
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name, e.jumlah_kunjungan
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0 AND STATUS = 1
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				JOIN (
					SELECT id_artikel, COUNT(*) AS jumlah_kunjungan
					FROM artikel_visitor
					GROUP BY id_artikel
					ORDER BY COUNT(*) DESC
					LIMIT 3
				) e ON a.id = e.id_artikel
				WHERE a.status = 1
				ORDER BY a.tanggal DESC";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql);
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetchAll();
		return $result;
	}
	
	function getAllData()
	{
		$select = $this->artikel->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'artikel'), array('*'))
			->joinLeft(array('b' => 'subtipe_artikel'), 'a.id_subtipe_artikel = b.id', array('subtipe_artikel'))
			->joinLeft(array('c' => 'tipe_artikel'), 'b.id_tipe_artikel = c.id', array('tipe_artikel'))
			->where('a.status = 1')
			->order('a.tanggal DESC');
		$result = $this->artikel->fetchAll($select);
		return $result;
	}

	function getDefaultData($id)
	{
		$sql = "SELECT a.*, b.subtipe_artikel, c.tipe_artikel, d.file_name
				FROM artikel a
				LEFT JOIN subtipe_artikel b ON a.id_subtipe_artikel = b.id AND b.status = 1
				LEFT JOIN tipe_artikel c ON b.id_tipe_artikel = c.id AND c.status = 1
				LEFT JOIN (
					SELECT id_artikel, file_name
					FROM artikel_file
					WHERE jenis = 0
					GROUP BY id_artikel
					ORDER BY RAND()
				) d ON a.id = d.id_artikel
				WHERE a.status = 1 AND a.id = ?";

		$db = Zend_Registry::get('db');		
		$stmt = $db->query($sql, array($id));
		$stmt->setFetchMode(Zend_Db::FETCH_OBJ); 
		$result = $stmt->fetch();
		return $result;
	}

	function getData($id)
	{
		$select = $this->artikel->select()
			->setIntegrityCheck(false)
			->from(array('a' => 'artikel'), array('*'))
			->joinLeft(array('b' => 'subtipe_artikel'), 'a.id_subtipe_artikel = b.id', array('subtipe_artikel'))
			->joinLeft(array('c' => 'tipe_artikel'), 'b.id_tipe_artikel = c.id', array('tipe_artikel'))
			->where('a.status = 1')
			->where('a.id = ?', $id);

		$result = $this->artikel->fetchRow($select);
		return $result;
	}

	function addData($judul, $konten, $tanggal, $tag, $id_subtipe_artikel, $id_tipe_artikel, $reporter, $penulis, $editor) 
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(			
			'judul' => $judul, 
			'konten' => $konten, 
			'tanggal' => $tanggal, 
			'tag' => $tag, 
			'id_subtipe_artikel' => $id_subtipe_artikel, 
			'id_tipe_artikel' => $id_tipe_artikel, 
			'reporter' => $reporter, 
			'penulis' => $penulis, 
			'editor' => $editor, 
			'user_input' => $user_log,
			'tanggal_input' => $tanggal_log,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
		$this->artikel->insert($params);
		$lastId = $this->artikel->getAdapter()->lastInsertId();
		return $lastId;	
	}

	function editData($id, $judul, $konten, $tanggal, $tag, $id_subtipe_artikel, $id_tipe_artikel, $reporter, $penulis, $editor, $status_artikel_utama, $status_pilihan, $status_publikasi, $status_komentar)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'judul' => $judul, 
			'konten' => $konten, 
			'tanggal' => $tanggal, 
			'tag' => $tag, 
			'id_subtipe_artikel' => $id_subtipe_artikel, 
			'id_tipe_artikel' => $id_tipe_artikel, 
			'reporter' => $reporter, 
			'penulis' => $penulis, 
			'editor' => $editor, 
			'status_artikel_utama' => $status_artikel_utama, 
			'status_pilihan' => $status_pilihan, 
			'status_publikasi' => $status_publikasi, 
			'status_komentar' => $status_komentar, 
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		$where = $this->artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel->update($params, $where);

	}

	public function deleteData($id)
	{
		$where = $this->artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel->delete($where);
	}

	public function softDeleteData($id)
	{
		$user_log = Zend_Auth::getInstance()->getIdentity()->pengguna;
		$tanggal_log = date('Y-m-d H:i:s');

		$params = array(
			'status' => 9,
			'user_update' => $user_log,
			'tanggal_update' => $tanggal_log
		);
 		
		$where = $this->artikel->getAdapter()->quoteInto('id = ?', $id);
		$this->artikel->update($params, $where);
	}

}