<?php
header ('Content-type: text/html; charset=UTF-8'); 

$lat = "-23.558874";
$lng = "-46.502254";

$modifiers = array("0.01", "0.03", "0.05", "0.07", "0.1", "0.2", "0.3", "0.5", "0.7", "0.9");

$i = 0;
while(true){
	echo $i++;
	echo "<br>";

	foreach($modifiers as $modifier){

		if($i>20) break 2;

	}
}



echo "oi";
exit;

// $modifier = "0.01";
// $modifier = "0.03";
// $modifier = "0.05";
// $modifier = "0.07";
// $modifier = "0.1";
// $modifier = "0.2";
// $modifier = "0.3";


// $modifier = array("0.01", "0.03", "0.05", "0.07", "0.1", "0.2", "0.3");

// foreach($modifier as $mod){

// 	echo $mod;
// 	echo "<br>";

// }
// exit;

// echo $lat;
// echo "<br> ---------<br>";
// echo $lat+$modifier;
// echo "<br>---------<br>";
// echo $lat-$modifier;
// echo "<br>---------<br>";

// exit;

// $modifier = "0.01";

// // echo $lat.",".$lng;

// $varLat = "-23.568874";
// $varLng = "-46.502254";

// $search = " AND (coo_lat >= '".($lat-$modifier)."' AND coo_lat <= '".($lat+$modifier)."')
// 	 AND (coo_lng >= '".($lng-$modifier)."' AND coo_lng <= '".($lng+$modifier)."')";

// echo $search;
// exit;
/*
$distances = "";

$distances[1234] = "10000";

if (!empty($distances)) {
    echo "tem";
} else {
    echo 'O array está vazio';
}

exit;
*/
/*
if(
	$varLat >= $lat-$modifier && $varLat <= $lat+$modifier
	&&
	$varLng >= $lng-$modifier && $varLng <= $lng+$modifier
){

	//echo $var." é maior que ".$lat-$modifier." e menor que ".$lat+$modifier;
	echo "sim";

} else {
	//echo $var." está fora do range";
	echo "não";
}

// latitude >= $lat-$modifier && latitude <= $lat+$modifier;

exit;
//============// COOPERATIVA //=============//
//INCLUI CLASSES
require_once('../../include/conection.inc.php');
require_once('../MySQL.class.php');
require_once('../CooperativaVO.php');
require_once('../cooperativa.class.php');
require_once('../mapsapi.class.php');


//INSTANCIA A CLASSE
$Cooperativa = new Cooperativa;
$oCooperativaVO = new CooperativaVO;

//GERA UM ID ALEATÓRIO DE 8 DÍGITOS
$i = 0;
$id = '';
while($i<8){
	if($i<1){ $id .= rand(1,9);	} else { $id .= rand(0,9); }
	$i++;
}


$nome = "Movimento Nacional dos Catadores de Materiais Recicláveis - MNCR";
$cep = "04105-040";
$endereco = "Rua Alceu Wamosy";
$numero = "34";
$complemento = "";
$bairro = "Vila Mariana";
$cidade = "São Paulo";
$estado = "SP";
$telefone = "(11)3399-3475";

//SETA OS VALORES
$oCooperativaVO->setCooperativaID($id);
$oCooperativaVO->setNome($nome);
$oCooperativaVO->setEmail("coo@adm.com");
$oCooperativaVO->setSenha(hash('sha512', $telefone));
$oCooperativaVO->setRazao($nome);
$oCooperativaVO->setCnpj("");
$oCooperativaVO->setCep($cep);
$oCooperativaVO->setEndereco($endereco);
$oCooperativaVO->setNumero($numero);
$oCooperativaVO->setComplemento($complemento);
$oCooperativaVO->setBairro($bairro);
$oCooperativaVO->setCidade($cidade);
$oCooperativaVO->setEstado($estado);


//INSTANCIA CLASSE
$ApiMaps = new ApiMaps;

//CONVERTE ENDEREÇO PRA STRING ÚNICA
$enderecoFormatado = $ApiMaps->formatAddress($endereco, $numero, $cidade, $estado, $cep);

//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
$LatLng = $ApiMaps->getLatLng($enderecoFormatado);

//ACESSA ARRAY COM LATITUDE E LONGITUDE
$oCooperativaVO->setLatitude($LatLng['lat']);
$oCooperativaVO->setLongitude($LatLng['lng']);

$oCooperativaVO->setTelefone($telefone);
$oCooperativaVO->setInclusao('Y-m-d H:i:s');
$oCooperativaVO->setAtivo(1);

//ATUALIZA ENDEREÇO
$oCooperativa = $Cooperativa->inserirCooperativa($oCooperativaVO);

if($oCooperativa) echo "Cooperativa ".$nome." inserida com sucesso";
exit;

//=========================//
*/
?>