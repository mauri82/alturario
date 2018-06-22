<?php 
// Inicio Consulta altura Rosario 
$url='http://sitiowcontingencia.prefecturanaval.gov.ar/alturas/index.php';
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
$altura=trim($htmlRosario[4]);
$altura=str_replace(",",".",$altura);
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
$respuesta="La altura del rio es de ".$altura." metros, ".$estado;
// Fin altura Rosario


$method = $_SERVER['REQUEST_METHOD'];
// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	//$text = $json->result->parameters->text;
	$text = $json->result->parameters->text;

	
        $speech="El rio esta en 1.23 metros";
	$response = new \stdClass();
	//$response->speech = $speech;
	//$response->displayText = $speech;
	//$response->fulfillmentText = $speech;
	$response->fulfillmentText = $respuesta;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Altura del Rio - Metodo no permitido (solo POST)";
}

?>
