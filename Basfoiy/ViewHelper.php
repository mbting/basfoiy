<?php

Class ViewHelper
{
	private $theme;
	private $location;

	public function __construct($theme)
	{
		$this->theme = $theme;
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
		include 'View/' . $this->theme . '/header.php';
		include 'View/' . $this->theme . '/' . $this->location . '.php';
		include 'View/' . $this->theme . '/footer.php';
	}
}