<?php

require_once 'Basfoiy/Basfoiy.php';

$basfoiy = new Basfoiy(require 'Basfoiy/config.php');

switch($basfoiy->url->segment(1))
{
	case 'search' :
		$basfoiy->searchAction();
		break;
	case 'suggest' :
		$basfoiy->suggestAction();
		break;
	case '':
		$basfoiy->homeAction();
		break;
	case 'crowd':
		require_once 'Basfoiy/BasCrowd.php';
		$crowd = new BasCrowd(require 'Basfoiy/config.php');
		switch($crowd->url->segment(2))
		{
			case '':
				$crowd->indexAction();
				break;
			case 'words':
				$crowd->wordsAction();
				break;
			case 'suggest':
				$crowd->suggestAction();
				break;
			default :
				header('HTTP/1.0 404 Not Found');
				$basfoiy->notfoundAction();
				break;
		}
		break;
	default :
		header('HTTP/1.0 404 Not Found');
		$basfoiy->notfoundAction();
		// echo "The requested page was not found.";
		break;
}