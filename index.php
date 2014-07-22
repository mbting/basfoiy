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
	case 'stats' :
		$basfoiy->statsAction();
		break;
	case '':
		$basfoiy->homeAction();
		break;
	default :
		header('HTTP/1.0 404 Not Found');
		$basfoiy->notfoundAction();
		// echo "The requested page was not found.";
		break;
}