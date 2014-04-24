<?php

/**
 * Basfoiy App
 *
 */

Class BasCrowd
{
	private $config;
	private $db;
	private $view;

	public function __construct(Array $config)
	{
		$this->config = $config;
		// set database
		$this->db = new Db($this->config['db']);
		// set url params
		$this->url = new UrlHelper();
		// set view helper
		$this->view = new ViewHelper($this->config);
		$this->view->setTemplate('crowd');

		if (session_status() == PHP_SESSION_NONE) session_start();

	}

	public function indexAction()
	{
		$this->view->setLocation('index')->load();
	}

	public function browseAction()
	{
		$this->view->setLocation('browse')->load();
	}

	public function wordsAction()
	{
		$output = array('error' => true,'result' => 'An error has occured');
		$total = $this->db->query('select count(1) count from basdata');
		$total = $total[0]->count;
		$limit = intval($this->config['crowdlimit']);
		$pages = ceil($total / $limit);
		$page = intval($this->url->segment(3));
		$page = ($page == 0) ? 1 : $page;
		$offset = ($page - 1)  * $limit;

		$q = $this->db->prepare('select * from basdata limit :limit offset :offset');
		$q->bindParam(':limit', $limit, PDO:: PARAM_INT);
		$q->bindParam(':offset', $offset, PDO:: PARAM_INT);
		$result = $this->db->fetch($q);

		// respond as json
		header('Content-Type: application/json');
		if ($result !== false) 
		{
			$output['error'] = false;
			$output['result'] = $result;
			$output['lastpage'] = $total;
		}
		echo json_encode($output);
	}

	public function suggestAction()
	{
		$output = array('error' => true,'result' => 'An error has occured');
		$total = $this->db->query('select count(1) count from bassuggests');
		$total = $total[0]->count;
		$limit = intval($this->config['crowdlimit']);
		$pages = ceil($total / $limit);
		$page = intval($this->url->segment(3));
		$page = ($page == 0) ? 1 : $page;
		$offset = ($page - 1)  * $limit;

		$q = $this->db->prepare('select * from bassuggests limit :limit offset :offset');
		$q->bindParam(':limit', $limit, PDO:: PARAM_INT);
		$q->bindParam(':offset', $offset, PDO:: PARAM_INT);
		$result = $this->db->fetch($q);

		// respond as json
		header('Content-Type: application/json');
		if ($result !== false) 
		{
			$output['error'] = false;
			$output['result'] = $result;
			$output['lastpage'] = $total;
		}
		echo json_encode($output);
	}

}

require_once 'Db.php';
require_once 'ViewHelper.php';
require_once 'UrlHelper.php';
