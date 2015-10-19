<?php
//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/ColetaVO.php');
require_once('../class/coleta.class.php');
require_once('../class/UsuarioVO.php');
require_once('../class/usuario.class.php');
require_once('../class/CooperativaVO.php');
require_once('../class/cooperativa.class.php');
require_once('../class/LogVO.php');
require_once('../class/log.class.php');
require_once('../class/mapsapi.class.php');

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

//VALIDAÇÕES
if(empty($materiais)){
	echo "materiais";
	exit;
}
if(empty($qtde)){
	echo "qtde";
	exit;
}
if(empty($data)){
	echo "data";
	exit;
}
if(empty($periodo)){
	echo "periodo";
	exit;
}
if(empty($cep)){
	echo "cep";
	exit;
}
if(empty($endereco)){
	echo "endereco";
	exit;
}
if(empty($numero)){
	echo "numero";
	exit;
}
if(empty($cidade)){
	echo "cidade";
	exit;
}

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
$enderecoFormatado = $ApiMaps->formatAddress($endereco, $numero, $cidade, $estado, $cep);

//CHAMA FUNÇÃO QUE RETORNA LATITUDE E LONGITUDE
$LatLng = $ApiMaps->getLatLng($enderecoFormatado);

//ACESSA ARRAY COM LATITUDE E LONGITUDE
$oUsuarioVO->setLatitude($LatLng['lat']);
$oUsuarioVO->setLongitude($LatLng['lng']);

$oUsuarioVO->setAtivo(1);

//COORDENADAS DO ENDEREÇO DO USUÁRIO
$usuEndereco = number_format($LatLng['lat'],6).",".number_format($LatLng['lng'],6);

//ATUALIZA ENDEREÇO
$oUsuario = $Usuario->alterarEndereco($oUsuarioVO);

if($oUsuario){

	// =========  CALCULAR COOPERATIVA MAIS PRÓXIMA ========= //

	//INSTANCIA A CLASSE
	$Cooperativa = new Cooperativa;
	$oCooperativaVO = new CooperativaVO;

	//CARREGA COOPERATIVAS
	$oCooperativas = $Cooperativa->carregarCooperativas(" AND coo_ativo='1'","coo_nome ASC","");

	$distances = "";

	//LOOP EM TODAS COOPERATIVAS
	foreach($oCooperativas as $coo){

		//COORDENADAS DO ENDEREÇO DA COOPERATIVAS	
		$cooEndereco = number_format($coo->getLatitude(),6).",".number_format($coo->getLongitude(),6);

		//CHAMA FUNÇÃO QUE CALCULA DISTÂNCIA E TEMPO
		$distance = $ApiMaps->getDistance($cooEndereco, $usuEndereco);

		if($distance){
			//POPULA ARRAY COM TEMPO E ID DE CADA COOPERATIVA
			$distances[$coo->getCooperativaID()] = $distance['durationValue'];
		}

	}

	//This will return the first index that has the minimum value in the array
	$betterDistance = array_search(min($distances), $distances);

	// ====================================================== //

}

if($oCooperativas){

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
	$oColetaVO->setCooperativaID($betterDistance);
	$oColetaVO->setFuncionarioID('11111111'); //ALTERAR POSTERIORMENTE
	$oColetaVO->setData($data_padrao);
	$oColetaVO->setPeriodo($periodo);
	$oColetaVO->setQtde($qtde);
	$oColetaVO->setInclusao(date('Y-m-d H:i:s'));
	$oColetaVO->setSituacao(1);

	//INSERE NOVO USUÁRIO
	$oInsereColeta = $Coleta->inserirColeta($oColetaVO);

}

if($oInsereColeta){

	//PREENCHE MATERIAS SELECIONADOS
	if(!empty($materiais)){
		foreach($materiais as $item){
			$oInsereItem = $Coleta->inserirItens($id,$item);
		}
	}

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

	//SETA OS DADOS NA SESSÃO
	$_SESSION["coleta"]["id"] = $id;
	$_SESSION["coleta"]["cooperativa"] = $betterDistance;
	$_SESSION["login_usuario"]["latitude"] = $LatLng['lat'];
	$_SESSION["login_usuario"]["longitude"] = $LatLng['lng'];

	echo 'ok';
	exit;

} else {
	echo 'erro';
	exit;
}

