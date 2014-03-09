<?php

Class ViewHelper
{
	private $config;

	private $location;
	private $header;
	private $footer;

	private $template;
	private $loadTemplate;

	public function __construct(Array $config)
	{
		if (isset($config['db']))
		{
			unset($config['db']);
		}
		$this->config = $config;
		$this->setTemplate();
	}

	public function setTemplate($template = false)
	{
		$this->template = ($template === false) ? false : $template;
		$this->header = ($template === false) ? 'View/header.php' : 'View/' . $this->template . 'header.php';
		$this->footer = ($template === false) ? 'View/footer.php' : 'View/' . $this->template . 'footer.php';
		return $this;
	}

	public function setLocation($location,$template = true)
	{
		$this->location = ($this->template === false) ? 'View/' . $location . '.php' : 'View/' . $this->template . '/' . $location . '.php';
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
			include $this->location;
		}
		else
		{
			include $this->header;
			include $this->location;
			include $this->footer;
		}
	}

}