<?php
class Admin_ZzzController extends Zend_Controller_Action
{
	public function init()
	{
		$this->_helper->_acl->allow('admin');
		$this->_helper->_acl->allow('super');
		$this->_helper->_acl->allow('user', array('index', 'edit'));
	}

	public function preDispatch()
	{
	}

	public function indexAction()
	{

		$pesan = $this->getRequest()->getParam('pesan');

		$api_key = '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';
		$model = 'text-davinci-003';
		$url = 'https://api.openai.com/v1/engines/' . $model . '/completions';

		$data = array(
			'prompt' => $pesan,
			'max_tokens' => 1000,
			'n' => 1,
			'stop' => '\n'
		);

		$options = array(
			'http' => array(
				'header' => "Content-Type: application/json\r\nAuthorization: Bearer " . $api_key . "\r\n",
				'method' => 'POST',
				'content' => json_encode($data)
			)
		);

		$context = stream_context_create($options);

		if ($pesan != '') {
			$result = file_get_contents($url, false, $context);
			$response = json_decode($result, true);

			// echo $result;
			// echo $response['choices'][0]['text'];
			$this->view->respon = $response['choices'][0]['text'];
		}
	}
}
