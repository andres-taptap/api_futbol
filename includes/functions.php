<?php
$protocol = isset($_SERVER["HTTP_X_FORWARDED_PROTO"]) ? 'https' : 'http';
$pathGA = '/taptap/api_futbol/'; //Cambiar por la ruta correcta
$path = $protocol.'://latam.taptapnetworks.com'.$pathGA;
//$path = '';
$test = 'false'; //true: para no medir; false: para medir

// Para diferenciar en GA según dónde se quiera distribuir: sonata, pbs, extern
if(!isset($cd)){$cd = (isset($_GET['cd']) && strip_tags($_GET['cd']) !== '') ? strip_tags($_GET['cd']) : 'sonata';}
if(!isset($dev)){$dev = (isset($_GET['dev']) && strip_tags($_GET['dev']) !== '') ? strip_tags($_GET['dev']) : 'smartphone';}
if(!isset($v)){$v = (isset($_GET['v']) && strip_tags($_GET['v']) !== '') ? strip_tags($_GET['v']) : '1';}

$clickSonata = (isset($_GET['click']) && strip_tags($_GET['click']) !== '' && strpos($_GET['click'],'http') !== false) ? strip_tags($_GET['click']) : '';
if($clickSonata !== ''){$ccSonata = "<img width=\"1\" height=\"1\" style=\"border:0;position:absolute;top:99999px;left:0\" src=\"".urldecode($clickSonata)."\"/>";}
else{$ccSonata = '';}

$trackEventsSonata = (isset($_GET['cet_encode']) && strip_tags($_GET['cet_encode']) !== '') ? urldecode(strip_tags($_GET['cet_encode'])) : '';

$timestamp = time(); //Sustituir en el $pixel y en el $cc por el valor [RANDOM]

$cc = '';
$pixel = ''; //Añadir $protocol al inicio: $protocol.'://urldelpixel';

//if($dev == 'smartphone'){
//    $cc = '';
//    $pixel = ''; //Añadir $protocol al inicio: $protocol.'://urldelpixel';
//}
//elseif($dev == 'tablet'){
//    $cc = '';
//    $pixel = ''; //Añadir $protocol al inicio: $protocol.'://urldelpixel';
//}  

if($pixel !== '' && $test === 'false' && $cd !== 'test'){$pixelImg = "<img width='1' height='1' style='border:0;position:absolute;top:-99999px;left:0' src='".$pixel."'/>";}
else{$pixelImg = '';}

?>
