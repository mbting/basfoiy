<?php

Class ViewHelper
{
	private $location;

	private $config;

	public function __construct(Array $config)
	{
		if (isset($config['db']))
		{
			unset($config['db']);
		}
		$this->config = $config;
	}

	public function setLocation($location)
	{
		$this->location = $location;
		return $this;
	}

	public function load($variables = null)
	{	

		if (is_array($variables)) {
			extract($variables);
		}
		include 'View/header.php';
		include 'View/' . $this->location . '.php';
		include 'View/footer.php';
	}
}