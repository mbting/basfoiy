<?php

/**
 * Basfoiy App
 *
 */

Class Basfoiy
{

	private $config;
	public $url;
	private $db;
	private $view;

	private $tokenKey;

	/*
	 * initialize  basfoiy	
	 */
	public function __construct(Array $config)
	{
		$this->config = $config;
		// set database
		$this->db = new Db($this->config['db']);
		// set url params
		$this->url = new UrlHelper();
		// set view helper
		$this->view = new ViewHelper($this->config);
		// set csrf token key
		$this->tokenKey = md5($config["token"]);

		session_start();

		// if ($_SESSION[$this->tokenKey] === null) {
		// 	$_SESSION[$this->tokenKey] = base64_encode(openssl_random_pseudo_bytes(16));
		// }
	}

	/*
	 * basfoiy home
	 */
	public function homeAction()
	{
		// set a new hash on every page reload
		$_SESSION[$this->tokenKey] = base64_encode(openssl_random_pseudo_bytes(16));
		$text = $result = $this->db->query('select bas from footertexts order by rand() limit 1');
		$this->view->setLocation('index')->load(array('token' => $_SESSION[$this->tokenKey],'text' => $text[0]->bas));
	}

	/*
	 * basfoiy search
	 */
	public function searchAction()
	{
		// respond as json
		header('Content-Type: application/json');

		//output array
		$output = array('error' => true,'result' => '');

		// ignore all requests except needed ones 
		$keyword = isset($_POST['basterm']) ? $_POST['basterm'] : false;
		if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $keyword === false || $keyword == '')
		// if ($this->checkToken() === false || $_SERVER['REQUEST_METHOD'] !== 'POST' || $keyword === false || $keyword == '')
		// if ($keyword === false || $keyword == '')
		{
			exit(json_encode($output));
		}

		// query the keyowrd
		$result = $this->db->query(
				'select * from basdata WHERE eng like :word or dhi like :word or latin like :word order by eng limit 5',
				array('word' => $keyword . '%')
			);

		// if no results are found
		if ($result === false && $this->config['findSimilar'])
		{
			// check for similar words in english
			$result = $this->db->query(
				'select eng from basdata where levenshtein(:word,eng) < 3 order by levenshtein(:word,eng) asc limit 1',
				array('word' => $keyword)
			);
			// if still not found
			if ($result === false) 
			{
				// query for similar words in latin
				$result = $this->db->query(
					'select eng from basdata where levenshtein(:word,latin) < 3 order by levenshtein(:word,latin) asc limit 1',
					array('word' => $keyword)
				);
			}
			// update keyword with any similar words found
			if (property_exists($result[0],'eng'))
			{
				$keyword = $result[0]->eng;
			} 
			else 
			{
				$keyword = $result[0]->latin;
			}
		}

		// query one more time
		$result = $this->db->query(
				'select * from basdata WHERE eng like :word or dhi like :word or latin like :word order by eng limit 5',
				array('word' => $keyword . '%')
			);

		// give up!
		if ($result !== false)
		{
			$output['error'] = false;
			$output['result'] = $result;
		} 
		echo json_encode($output);

	}

	public function notfoundAction()
	{
		$this->view->setLocation('404',false)->load();
	}

	public function suggestAction() {
		// respond as json
		header('Content-Type: application/json');
		$resp = recaptcha_check_answer ($this->config["apiKeys"]["recaptcha"]["private"],
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
		if ($resp->is_valid == true)
		{
			if ($_POST['baseng'] == '' && $_POST['basdhi'] == '' && $_POST['baslatin'] == '')
			{
				echo json_encode(array(
								"error" => true,
								"msg" => "Please enter one of the words!"
								));
				exit;
			}

			$this->db->insert(
				'insert into bassuggests (eng,dhi,latin) values (:eng,:dhi,:latin)',
				array(
					'eng' => $_POST['baseng'],
					'dhi' => $_POST['basdhi'],
					'latin' => $_POST['baslatin']
					)
				);
		}
		// return
		echo json_encode(array(
								"error" => ($resp->is_valid == true) ? false : true,
								"msg" => ($resp->error === null) ? "Thank you!" : "Please Try again!"
								));
	}

	/*
	 * check csrf token
	 */
	public function checkToken()
	{
		if ($_SESSION[$this->tokenKey] == $_SERVER['BasToken']) 
			return true;
		return false;
	}

}

require_once 'Db.php';
require_once 'ViewHelper.php';
require_once 'UrlHelper.php';
require_once 'Lib/recaptchalib.php';

// error_reporting(0);
