<?php

$cooperativas = array
  (
  array("id"=>"id123", "lat"=>"123", "lng"=>"456"),
  array("id"=>"id123", "lat"=>"789", "lng"=>"012"),
  array("id"=>"id123", "lat"=>"345", "lng"=>"678"),
  array("id"=>"id123", "lat"=>"123", "lng"=>"456"),
  array("id"=>"id123", "lat"=>"123", "lng"=>"456")
  );

$distancias = "";

$cont = 0;

foreach($cooperativas as $coo){

	echo $cont;
	echo "<br>";

	print_r($coo);
	echo $coo['lat'];
	echo " / ";
	echo $coo['lng'];
	echo "<br>--------<br>";

	$cont++;

}

exit;


//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/ColetaVO.php');
require_once('../class/coleta.class.php');
require_once('../class/UsuarioVO.php');
require_once('../class/usuario.class.php');
require_once('../class/mapsapi.class.php');
require_once('../class/LogVO.php');
require_once('../class/log.class.php');

//INCLUI ANT SQL INJECTION
include("antiSQLInjection.php");

//PEGA IP
include("getIp.php");

//RECUPERA ID DA SESSÃO DO USUÁRIO
session_start();
$usuarioID = $_SESSION["login_usuario"]["id"];
$usuarioNome = $_SESSION["login_usuario"]["nome"];

//PEGA NOME DA PÁGINA ATUAL
$pagina = basename($_SERVER['SCRIPT_NAME']);

//DADOS FORMULÁRIO
foreach($_POST as $key => $value) {
  $$key = (isset($key)) ? noInjection($value) : NULL;
}

/*
//VALIDAÇÕES
if(empty($name) && empty($email) && empty($senha)){
	echo "campos_vazios";
	exit;
}
if(empty($name)){
	echo "nome_vazio";
	exit;
}
if(empty($email)){
	echo "email_vazio";
	exit;
}
if(empty($senha)){
	echo "senha_vazia";
	exit;
}
if(strlen($senha)<6){
	echo "senha_curta";
	exit;
}
if($oColeta){
	echo "usuario_existe";
	exit;
}
*/

//INSTANCIA A CLASSE
$Usuario = new Usuario;
$oUsuarioVO = new UsuarioVO;

//SETA OS VALORES
$oUsuarioVO->setUsuarioID($usuarioID);
$oUsuarioVO->setCep($cep);
$oUsuarioVO->setEndereco($endereco);
$oUsuarioVO->setNumero($numero);
$oUsuarioVO->setComplemento($complemento);
$oUsuarioVO->setBairro($bairro);
$oUsuarioVO->setCidade($cidade);
$oUsuarioVO->setEstado($estado);

//INSTANCIA CLASSE
$ApiMaps = new ApiMaps;

//CONVERTE ENDEREÇO PRA STRING ÚNICA
$enderecoFormatado = $ApiMaps->formatAddress($endereco, $numero, "$cidade", $estado, $cep);

//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
$LatLng = $ApiMaps->getLatLng($enderecoFormatado);

//ACESSA ARRAY COM LATITUDE E LONGITUDE
$oUsuarioVO->setLatitude($LatLng['lat']);
$oUsuarioVO->setLongitude($LatLng['lng']);

$oUsuarioVO->setAtivo(1);

//ATUALIZA ENDEREÇO
$oUsuario = $Usuario->alterarEndereco($oUsuarioVO);


// =========  CALCULAR COOPERATIVA MAIS PRÓXIMA ========= //

$cooperativas = array
  (
  array("lat"=>"123","lng"=>"456"),
  array("lat"=>"789","lng"=>"012"),
  array("lat"=>"345","lng"=>"678"),
  array("lat"=>"123","lng"=>"456"),
  array("lat"=>"123","lng"=>"456")
  );

foreach($cooperativas as $coo){

	print_r($coo);

}

exit;










// ====================================================== //


//INSTANCIA A CLASSE
$Coleta = new Coleta;
$oColetaVO = new ColetaVO;

//GERA UM ID ALEATÓRIO DE 8 DÍGITOS
$i = 0;
$id = '';
while($i<8){
	if($i<1){ $id .= rand(1,9);	} else { $id .= rand(0,9); }
	$i++;
}

//SETA OS VALORES
$oColetaVO->setColetaID($id);
$oColetaVO->setUsuarioID($usuarioID);
$oColetaVO->setCooperativaID('22222222'); //ALTERAR POSTERIORMENTE
$oColetaVO->setFuncionarioID('11111111'); //ALTERAR POSTERIORMENTE
$oColetaVO->setData($data_padrao);
$oColetaVO->setPeriodo($periodo);
$oColetaVO->setQtde($qtde);
$oColetaVO->setInclusao(date('Y-m-d H:i:s'));
$oColetaVO->setSituacao(1);

//INSERE NOVO USUÁRIO
$oInsereColeta = $Coleta->inserirColeta($oColetaVO);

if($oInsereColeta){

	//PREENCHE MATERIAS SELECIONADOS
	if(!empty($materiais)){
		foreach($materiais as $item){
			$oInsereItem = $Coleta->inserirItens($id,$item);
		}
	}

	if($oUsuario){

		$Log = new Log;
		$oLogVO = new LogVO;
		$oLogVO->setUsuarioID($usuarioID);
		$oLogVO->setUsuario($usuarioNome);
		$oLogVO->setAcao('Coleta: Usuário '.$usuarioNome.' solicitou uma coleta');
		$oLogVO->setPagina($pagina);
		$oLogVO->setIP(getIP());
		$oLogVO->setAcesso(0);
		$oLogVO->setData('Y-m-d H:i:s');
		$Log->inserirLog($oLogVO);

		echo 'ok';
		exit;
	} else {
		echo 'erro';
		exit;
	}
} else {
	echo 'erro';
	exit;
}

