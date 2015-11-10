<?php
class ApiMaps{

	public function getLatLng($endereco){

		//trata caracteres especiais do endereco
		$endereco = $this->myUrlEncode($endereco);

	    //Pega o conteúdo retornado em json através do file_get_contents():
	    $url = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=".$endereco."&sensor=false");

		//Decodifica o json através do json_decode():
		$json = json_decode($url, true); // decode the JSON into an associative array

		if($json['status'] == "OK"){

			$result['lat'] = $json['results'][0]['geometry']['location']['lat'];
			$result['lng'] = $json['results'][0]['geometry']['location']['lng'];

			return $result;

		} else {
			return false;
		}

	}

	public function getDistance($origem, $destino){

		//trata caracteres especiais do endereco
		//$origem = $this->myUrlEncode($origem);
		//$destino = $this->myUrlEncode($destino);

	    //Pega o conteúdo retornado em json através do file_get_contents():
	    $url = file_get_contents("https://maps.googleapis.com/maps/api/directions/json?origin=".$origem."&destination=".$destino."&mode=driving"); //mode pode ser transit também

		//Decodifica o json através do json_decode():
		$json = json_decode($url, true); // decode the JSON into an associative array

		if($json['status'] == "OK"){

			$result['distanceText'] = $json['routes'][0]['legs'][0]['distance']['text'];
			$result['distanceValue'] = $json['routes'][0]['legs'][0]['distance']['value'];

			$result['durationText'] = $json['routes'][0]['legs'][0]['duration']['text'];
			$result['durationValue'] = $json['routes'][0]['legs'][0]['duration']['value'];

			return $result;

		} else {
			return false;
		}

	}

	public function formatAddress($endereco, $numero, $cidade, $estado, $cep){

		//cria string unica com endereço
		$fomattedAddres = "$endereco";

		if(!empty($numero)) $fomattedAddres .= ", ".$numero;
		if(!empty($cidade)) $fomattedAddres .= ", ".$cidade;
		if(!empty($estado)) $fomattedAddres .= ", ".$estado;
		if(!empty($cep)) $fomattedAddres .= ", ".$cep;

		return $fomattedAddres;

	}

	public function formatShortAddress($endereco, $numero){

		//cria string unica com endereço
		$fomattedAddres = "$endereco";

		if(!empty($numero)) $fomattedAddres .= ", ".$numero;

		return $fomattedAddres;

	}

	public function formatMapsAddress($cidade, $estado, $cep){

		//cria string unica com endereço
		if(!empty($cidade)) $fomattedAddres = $cidade.",";
		if(!empty($estado)) $fomattedAddres .= $estado.",";
		if(!empty($cep)) $fomattedAddres .= $cep;

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

?>