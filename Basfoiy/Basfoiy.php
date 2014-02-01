<?php

/**
 * Basfoiy App
 *
 */

Class Basfoiy
{

	private $urlParam;
	private $db;

	/*
	 * initialize  basfoiy	
	 */
	public function __construct(Array $config)
	{
		// set database
		$this->db = new Db($config['db']);
		// set token
		header('X-Bas-Token: THETOKEN');
		// set url params
		$this->urlParam = $this->parseUrl();
	}

	/*
	 * basfoiy home
	 */
	public function homeAction()
	{
		echo 'home';
	}

	/*
	 * basfoiy search
	 */
	public function searchAction()
	{
		// respond as json
		header('Content-Type: application/json');

		// ignore all requests except POST 
		if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
			exit(json_encode(array('error' => true)));
		}
		
		echo json_encode(array('hello' => 'there'));
	}

	/*
	 * return the parsed urlParams
	 */
	public function urlParam($index = 1)
	{
		$index = $index - 1;
		return isset($this->urlParam[$index]) ? $this->urlParam[$index] : false;
	}

	/*
	 * parse the current url
	 */
	private function parseUrl()
	{
		// identify sub directory
		$subdir = explode('index.php',$_SERVER['PHP_SELF']);
		$subdir = isset($subdir[0]) ? $subdir[0] : '';
		// prepare url params
		$urlParams = str_replace($subdir,'',str_replace('index.php','',$_SERVER['REQUEST_URI']));
		$urlParams = explode('/',$urlParams);
		// eliminate empty values
		foreach ($urlParams as $key => $value) {
			if ($value == '') unset($urlParams[$key]);
		}
		// reorder array
		return array_values($urlParams);
	}

}

require_once 'Db.php';