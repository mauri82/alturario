<?php
$url='https://api.weatherbit.io/v2.0/forecast/daily?city=Rosario,AR&key=344c2510212b4857adb5a5d8c70ca1e4&lang=es';
//$fechaParm='2018-07-04T12:00:00-03:00';
$jsonCrudo = file_get_contents($url);
//require('datos.php');
$json = json_decode($jsonCrudo);
//$vientoDireccion=$json->data[0]->datetime;
$indice='';
$fectmp=strtotime($fechaParm);
$fecha=date('Y-m-d',$fectmp);
$indice=99;
for ($i=0;$i<=15;$i++)
{
    if ($fecha==$json->data[$i]->datetime)
    {
        $indice=$i;
    }
}
//Ya se que $indice estan los datos del dia que quiero
//El viento esta en metros por segundo
if ($indice==99){
    exit("No tengo pronostico para ese dia");
}
$vientoDireccion=$json->data[$indice]->wind_cdir;
$vientoDireccionTexto=$json->data[$indice]->wind_cdir_full;
$vientoVelocidad=$json->data[$indice]->wind_spd;
$vientoVelocidad=$vientoVelocidad*3.6;
$vientoVelocidad=round($vientoVelocidad);
$vientoVelocidadRachas=$json->data[$indice]->wind_gust_spd;
$vientoVelocidadRachas=$vientoVelocidadRachas*3.6;
$vientoVelocidadRachas=round($vientoVelocidadRachas);

//Ahora determino la respuesta en base al viento
$salida='Dejame pensar...';
$esSur='no';
if (strpos($vientoDireccion,'S')!==false)
{
    $esSur='si';
}

if ($esSur=='si')
{
    //es sur, hay que ver la velocidad
    if ($vientoVelocidad>=15)
    {
        $salida='Puede estar picado, va a soplar  del '.$vientoDireccionTexto.' a '.$vientoVelocidad.' kilometros por hora';
    }else{
        $salida='Va a soplar '.$vientoDireccionTexto.' pero solo a '.$vientoVelocidad.' kilometros por hora';
    }
}else{
    //No hay sur, se puede remar
    if ($vientoVelocidad>=20)
    {
        $salida='No hay problemas para remar, pero ojo que el viento va a ser '.$vientoDireccionTexto.' a '.$vientoVelocidad.' kilometros por hora';
    }else{
        $salida='No hay problemas para remar, el viento va a ser '.$vientoDireccionTexto.' a '.$vientoVelocidad.' kilometros por hora';
    }
    
}

$response = new \stdClass();
$response->speech = $salida;
$response->displayText = $speech;
$response->source = "webhook";
echo json_encode($response);
?>