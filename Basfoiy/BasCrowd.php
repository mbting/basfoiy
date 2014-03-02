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

		if (session_status() == PHP_SESSION_NONE) session_start();

	}

	public function indexAction()
	{
		echo  "im alive";
	}


}

require_once 'Db.php';
require_once 'ViewHelper.php';
require_once 'UrlHelper.php';
