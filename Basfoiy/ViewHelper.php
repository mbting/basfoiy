<?php

Class ViewHelper
{
	private $location;

	private $config;

	private $loadTemplate;

	public function __construct(Array $config)
	{
		if (isset($config['db']))
		{
			unset($config['db']);
		}
		$this->config = $config;
	}

	public function setLocation($location,$template = true)
	{
		$this->location = $location;
		$this->loadTemplate = $template;
		return $this;
	}

	public function load($variables = null)
	{	

		if (is_array($variables)) {
			extract($variables);
		}
		if ($this->loadTemplate === false) 
		{
			include 'View/' . $this->location . '.php';
		}
		else 
		{
			include 'View/header.php';
			include 'View/' . $this->location . '.php';
			include 'View/footer.php';
		}
	}

}