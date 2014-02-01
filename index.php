<?php

require_once 'Basfoiy/Basfoiy.php';

$basfoiy = new Basfoiy(require_once 'Basfoiy/config.php');

switch($basfoiy->urlParam(1))
{
	case 'search' :
		$basfoiy->searchAction();
		break;
	default :
		$basfoiy->homeAction();
		break;
}