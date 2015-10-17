<?php
// =========  CALCULAR COOPERATIVA MAIS PRÓXIMA ========= //


//INSTANCIA A CLASSE
$Cooperativa = new Cooperativa;
$oCooperativaVO = new CooperativaVO;

//CARREGA RESÍDUOS
$oCooperativas = $Cooperativa->carregarCooperativas(" AND coo_cidade='São Paulo' ","coo_nome ASC","");

header ('Content-type: text/html; charset=UTF-8');

$cont = 0;
$distances = "";

foreach($oCooperativas as $coo){

	//CONVERTE ENDEREÇO PRA STRING ÚNICA
	$cooEnderecoFormatado = $ApiMaps->formatAddress($coo->getEndereco(), $coo->getNumero(), $coo->getCidade(), $coo->getEstado(), $coo->getCep());

	//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
	$cooLatLng = $ApiMaps->getLatLng($cooEnderecoFormatado);

	$usuEndereco = $LatLng['lat'].",".$LatLng['lng'];
	$cooEndereco = $cooLatLng['lat'].",".$cooLatLng['lng'];

	echo $cooEndereco;
	echo "<br>";
	echo $usuEndereco;
	echo "<br>";

	//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
	$distance = $ApiMaps->getDistance($cooEndereco, $usuEndereco);

	echo $coo->getCooperativaID();
	echo " / ";
	echo $coo->getNome();
	echo " / ";
	echo $coo->getLatitude();
	echo " / ";
	echo $coo->getLongitude();
	echo " / ";
	echo $distance['distanceText'];
	echo " / ";
	echo $distance['distanceValue'];
	echo " / ";
	echo $distance['durationText'];
	echo " / ";
	echo $distance['durationValue'];
	echo "<br>=======================================<br><br>";

	$distances[$coo->getCooperativaID()] = $distance['durationValue'];

	$cont++;

}

echo "<br>";
echo "<br>";

print_r($distances);

echo "<br>";
echo "<br>";

//This will return the first index that has the minimum value in the array
$betterDistance = array_search(min($distances), $distances);

echo $betterDistance;
exit;

// ====================================================== //

?>