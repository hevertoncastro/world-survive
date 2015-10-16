<?php
class ApiMaps{

	public function getLatLng($endereco){

		//trata caracteres especiais do endereco
		$endereco = $this->myUrlEncode($endereco);

	    //Pega o conteúdo retornado em json através do file_get_contents():
	    $url = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$endereco."&sensor=false");

		//Decodifica o json através do json_decode():
		$json = json_decode($url, true); // decode the JSON into an associative array

		$result['lat'] = $json['results'][0]['geometry']['location']['lat'];
		$result['lng'] = $json['results'][0]['geometry']['location']['lng'];

		return $result;

	}

	public function getDistance($origem, $destino){

		//trata caracteres especiais do endereco
		$origem = $this->myUrlEncode($origem);
		$destino = $this->myUrlEncode($destino);

	    //Pega o conteúdo retornado em json através do file_get_contents():
	    $url = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".$origem."&destination=".$destino."&mode=driving"); //mode pode ser transit também

		//Decodifica o json através do json_decode():
		$json = json_decode($url, true); // decode the JSON into an associative array

		$result['distanceText'] = $json['routes'][0]['legs'][0]['distance']['text'];
		$result['distanceValue'] = $json['routes'][0]['legs'][0]['distance']['value'];

		$result['durationText'] = $json['routes'][0]['legs'][0]['duration']['text'];
		$result['durationValue'] = $json['routes'][0]['legs'][0]['duration']['value'];

		return $result;

	}

	//https://maps.googleapis.com/maps/api/directions/json?origin=EnderecodeOrgigem&destination=EnderecodeDestino&mode=driving

	public function formatAddress($endereco, $numero, $cidade, $estado, $cep){

		//cria string unica com endereço
		$fomattedAddres = "$endereco";

		if(!empty($numero)) $fomattedAddres .= ", ".$numero;
		if(!empty($cidade)) $fomattedAddres .= ", ".$cidade;
		if(!empty($estado)) $fomattedAddres .= ", ".$estado;
		if(!empty($cep)) $fomattedAddres .= ", ".$cep;

		return $fomattedAddres;

	}

	public function myUrlEncode($url){

		//caracteres gerados pelo urlencode()
		$entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
		//caracteres para substituição
	    $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");

	    //endereço tratado para ser enviado
	    return str_replace($entities, $replacements, urlencode($url));
	}
}


//https://maps.googleapis.com/maps/api/directions/json?origin=-21.0208301,-47.3740569&destination=Rua%20Peixoto%20Gomide,296&mode=driving

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Classe de testes API Google Maps</title>
	<link rel="stylesheet" href="">
</head>
<body>
<?php

//INSTANCIA CLASSE
$ApiMaps = new ApiMaps;

//ENDEREÇO DO CLIENTE NO FORMATO DO BANCO
$endereco = "Rua Manoel Jorge Correa";
$numero = "40";
$cidade = "São Paulo";
$estado = "SP";
$cep = "";

//CONVERTE ENDEREÇO PRA STRING ÚNICA
$enderecoFormatado = $ApiMaps->formatAddress($endereco, $numero, "$cidade", $estado, $cep);

echo "Endereço do cliente formatado: <br>".$enderecoFormatado."<br><br>";

//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
$LatLng = $ApiMaps->getLatLng($enderecoFormatado);

//ACESSA ARRAY COM LATITUDE E LONGITUDE
echo "Latitude: ".$LatLng['lat'];
echo "<br>";
echo "Longitude: ".$LatLng['lng'];
echo "<br><br>======================================<br><br>";

//===============================================================//

//ENDEREÇO DA COOPERATIVA NO FORMATO DO BANCO
$cooEndereco = "Rua Peixoto Gomide";
$cooNumero = "296";
$cooCidade = "São Paulo";
$cooEstado = "SP";
$cooCep = "01.409-000";

//CONVERTE ENDEREÇO PRA STRING ÚNICA
$cooEnderecoFormatado = $ApiMaps->formatAddress($cooEndereco, $cooNumero, "$cooCidade", $cooEstado, $cooCep);

echo "Endereço da cooperativa formatado: <br>".$cooEnderecoFormatado."<br><br>";

//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
$cooLatLng = $ApiMaps->getLatLng($cooEnderecoFormatado);

//ACESSA ARRAY COM LATITUDE E LONGITUDE
echo "Latitude: ".$cooLatLng['lat'];
echo "<br>";
echo "Longitude: ".$cooLatLng['lng'];
echo "<br><br>======================================<br><br>";

//===============================================================//


//CONVERTE EM COORDENADAS OS DOIS ENDEREÇOS
$coordenadasEndereco = $LatLng['lat'].",".$LatLng['lng'];
$coordenadasCooEndereco = $cooLatLng['lat'].",".$cooLatLng['lng'];

//CALCULA DISTANCIA E TEMPO ENTRE OS DOIS ENDEREÇOS
$distanceEnderecos = $ApiMaps->getDistance($coordenadasEndereco, $coordenadasCooEndereco);


//ACESSA ARRAY COM DISTÊNCIA E DURAÇÃO
echo "Distância: ".$distanceEnderecos['distanceText']." (".$distanceEnderecos['distanceValue'].")";
echo "<br>";
echo "Duração: ".$distanceEnderecos['durationText']." (".$distanceEnderecos['durationValue'].")";

?>
</body>
</html>