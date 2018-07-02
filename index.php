<?php
$solicitud = file_get_contents("php://input");
$json = json_decode($solicitud);
$intent = $json->queryResult->intent->displayName;

switch ($intent){
	case 'Altura Rio':
		require('rio.php');
		break;
	case 'remar':
		$fechaParm=$json->queryResult->parameters->date;
		require('remar.php');
		break;
	case 'windguru':
		require('windguru.php');
		break;		
	default:
		print 'no se....';
		break;
}
?>