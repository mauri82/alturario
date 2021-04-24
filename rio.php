<?php
$url='https://contenidosweb.prefecturanaval.gob.ar/alturas/index.php';
$html = file_get_contents($url);
//$inicio=strpos($html,'<table class="table table-hover fpTable">');
//$fin=strpos($html,'<table class="table table-hover fpTable">');
$inicio=strpos($html,'<th scope="row">280</th>');
$fin=strpos($html,'<th scope="row">290</th>');
$largo=$fin-$inicio;
$htmlRosario=substr($html,$inicio,$largo);
$html='';
$htmlRosario=str_replace('<th scope="row">280</th> <th scope="row" class="pna-port-left">ROSARIO</th> <td>PARANA</td>','',$htmlRosario);
$htmlRosario=str_replace(' scope="row"','',$htmlRosario);
$htmlRosario=str_replace(' class="pna-port-left"','',$htmlRosario);
$htmlRosario=str_replace(' class="warning"','',$htmlRosario);
$htmlRosario=str_replace('</th>','',$htmlRosario);
$htmlRosario=str_replace('</td>','',$htmlRosario);
$htmlRosario=str_replace('<th>','<td>',$htmlRosario);
$htmlRosario=explode('<td>', $htmlRosario);
$altura=$htmlRosario[4];
$altura=trim(str_replace(",",".",$altura));
$estado_tmp=$htmlRosario[7];
$estado='-';
$estado_tmp=trim($estado_tmp);
switch ($estado_tmp){
	case 'ESTAC.':
		$estado='estacionario';
		break;
	case 'CRECE':
		$estado='crece';
		break;
	case 'BAJA':
		$estado='baja';
		break;		
	default:
		$estado='';
		break;
}
$respuesta="El río está en ".$altura." metros, ".$estado;

$response = new \stdClass();
//$response->speech = $respuesta;
//$response->displayText = $respuesta;
//$response->return = $respuesta;
$response->fulfillmentText = $respuesta;
//$response->source = "webhook";
echo json_encode($response);
?>
