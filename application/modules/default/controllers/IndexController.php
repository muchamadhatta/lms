<?php
class IndexController extends Zend_Controller_Action
{
	public function init()
	{  
		$this->_helper->_acl->allow();
	}
	
	public function preDispatch() 
	{
		$this->TipeArtikelService = new TipeArtikelService();
		$this->SubtipeArtikelService = new SubtipeArtikelService();
		$this->ArtikelService = new ArtikelService();
		$this->KontakService = new KontakService();
		$this->KontenStatisService = new KontenStatisService();
		$this->KontenSettingService = new KontenSettingService();
		$this->ArtikelVisitorService = new ArtikelVisitorService();
		$this->TagCloudService = new TagCloudService();
	}
	
	public function indexAction()
	{
		$this->view->MenuRows = $this->TipeArtikelService->getDefaultMenuData();
		$this->view->TipeArtikelRows = $this->TipeArtikelService->getDefaultAllData();
		
		
		$this->view->TopStoriesRows = $this->ArtikelService->getDefaultTopStoriesData();	// topik terhangat = 1 (5 artikel)
		$this->view->LatestArticleRows = $this->ArtikelService->getDefaultLatestData();		// artikel terbaru (3 artikel)
		$this->view->PopularArticleRows = $this->ArtikelService->getDefaultPopularData();	// artikel terpopuler (3 artikel)
		$this->view->ArchiveArtikelRows = $this->ArtikelService->getDefaultArchiveData();	// arsip artikel (3 artikel)
		$this->view->GroupRows = $this->TipeArtikelService->getDefaultTopStoriesGroupData();
		
		$this->view->TagRows = $this->TagCloudService->getDefaultAllData();
		
		$hal = htmlspecialchars(strip_tags($this->getRequest()->getParam('p')),ENT_QUOTES);
		$hal = ($hal) ? $hal : 0;
		$this->view->hal = $hal;
		$this->view->ArtikelRows = $this->ArtikelService->getDefaultAllData($hal);
	}

	public function magazineAction()
	{		
		$id = $this->getRequest()->getParam('id');
		$this->view->row = $this->SubtipeArtikelService->getDefaultData($id);
		$this->view->rows = $this->ArtikelService->getDefaultFilterData($id);
	}

	public function singleAction()
	{
		$id = $this->getRequest()->getParam('id');
		
		// Jenis Browser
		$browser = $_SERVER['HTTP_USER_AGENT'];
		$http_user_agent = $browser;
		$chrome = '/Chrome/';
		$firefox = '/Firefox/';
		$ie = '/IE/';
		if (preg_match($chrome, $browser))
			$data = "Chrome/Opera";
		if (preg_match($firefox, $browser))
			$data = "Firefox";
		if (preg_match($ie, $browser))
			$data = "IE";

		// untuk mengambil informasi dari pengunjung
		$ip_address = $_SERVER['REMOTE_ADDR']."";
		$browser = $data;
		$counter = 1;
		$this->ArtikelVisitorService->addData($id, $ip_address, $counter, $browser, $http_user_agent);
		$this->view->ArtikelVisitorRows = $this->ArtikelVisitorService->getAllData();

		$this->view->row = $this->ArtikelService->getDefaultData($id);
		$this->view->RelatedArticleRows = $this->ArtikelService->getDefaultAllLatestData($id);
	}

	public function cinemaAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->view->rows = $this->ArtikelService->getDefaultMonthlyData($id);
	}

	public function archivesAction()
	{
		$this->view->ArchivesByMonthRows = $this->ArtikelService->getDefaultArchivesByMonthData($id);
		$this->view->ArchivesByCategoriesRows = $this->ArtikelService->getDefaultArchivesByCategoriesData($id);
	}

	public function contactAction()
	{
		if ( $this->getRequest()->isPost() )
		{
			$nama = htmlspecialchars(strip_tags($this->getRequest()->getParam('nama','')),ENT_QUOTES);
			$email = htmlspecialchars(strip_tags($this->getRequest()->getParam('email','')),ENT_QUOTES);
			$judul = htmlspecialchars(strip_tags($this->getRequest()->getParam('judul','')),ENT_QUOTES);
			$pesan = htmlspecialchars(strip_tags($this->getRequest()->getParam('pesan','')),ENT_QUOTES);

			$id = $this->KontakService->addData($nama, $email, $judul, $pesan);

			$this->_redirect('/index/contact');
		} else {
			$this->view->rows = $this->KontenSettingService->getDefaultAllData();
		}
	}

	public function aboutAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->view->row = $this->KontenStatisService->getDefaultData($id);
	}

	public function searchAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->view->id = $id;
		$this->view->rows = $this->ArtikelService->getDefaultSearchData($id);
	}

}