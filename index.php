<?php

require_once 'Basfoiy/Basfoiy.php';

$basfoiy = new Basfoiy(array());

switch($basfoiy->urlParam(1))
{
	case 'search' :
		$basfoiy->searchAction();
		break;
	default :
		$basfoiy->homeAction();
		break;
}