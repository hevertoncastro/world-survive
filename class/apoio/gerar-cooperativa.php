<?php
//============// COOPERATIVA //=============//

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

$nome = "Comunidade dos Sofredores de Rua";
$cep = "01505-001";
$endereco = "Rua dos Estudantes";
$numero = "483";
$complemento = "";
$bairro = "";
$cidade = "São Paulo";
$estado = "SP";
$telefone = "(11) 3272-9724 ";

//SETA OS VALORES
$oCooperativaVO->setCooperativaID($id);
$oCooperativaVO->setNome($nome);
$oCooperativaVO->setEmail("");
$oCooperativaVO->setSenha("");
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

?>