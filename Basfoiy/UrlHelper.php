<?php

class UrlHelper
{
	private $params;
	private $rootUrl;

	public function __construct()
	{
		$this->rootUrl = 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['PHP_SELF']);
		$subdir = explode('index.php',$_SERVER['PHP_SELF']);
		$subdir = isset($subdir[0]) ? $subdir[0] : '';
		$subdir = ($subdir == '/') ? '' : $subdir;
		// prepare url params
		$urlParams = str_replace($subdir,'',str_replace('index.php','',$_SERVER['REQUEST_URI']));
		$urlParams = explode('/',$urlParams);
		// eliminate empty values
		foreach ($urlParams as $key => $value) {
			if ($value == '') unset($urlParams[$key]);
		}
		// reorder array
		if (!empty($urlParams)) $this->params = array_values($urlParams);
	}

	public function segment($index = null)
	{
		if ($index === null) return $this->params;
		if (isset($this->params[$index - 1]))
			return $this->params[$index - 1];
		return '';
	}

	public function getRootUrl()
	{
		return $this->rootUrl;
	}
}