<?php
//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/CooperativaVO.php');
require_once('../class/cooperativa.class.php');

require_once('../class/LogVO.php');
require_once('../class/log.class.php');

//INCLUI ANT SQL INJECTION
include("antiSQLInjection.php");

//PEGA IP
include("getIp.php");

//PEGA NOME DA PÁGINA ATUAL
$pagina = basename($_SERVER['SCRIPT_NAME']);

//PEGA DADOS POR POST
$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$email = noInjection($email);

$senha = isset($_POST['senha']) ? $_POST['senha'] : NULL;
$senha = noInjection($senha);

if(empty($email) && empty($senha)){
	echo "campos_vazios";
	exit;
}
if(empty($email)){
	echo "email_vazio";
	exit;
}
//VALIDA E-MAIL
function validaEmail($mail){
	if(preg_match("/^([[:alnum:]_.-]){2,}@([[:lower:][:digit:]_.-]{2,})(\.[[:lower:]]{2,3})(\.[[:lower:]]{2})?$/", $mail)) {
		return true;
	}else{
		return false;
	}
}
if (!validaEmail($email)){
	echo "email_incorreto";
	exit;
}
if(empty($senha)){
	echo "senha_vazia";
	exit;
}

$Cooperativa = new Cooperativa;
$oCooperativa = $Cooperativa->carregarCooperativas(' AND coo_email = "'.$email.'" AND coo_senha = "'.hash('sha512', $senha).'"','','');

if($oCooperativa){

	$Log = new Log;
	$oLogVO = new LogVO;
	$oLogVO->setUsuarioID($oCooperativa[0]->getCooperativaID());
	$oLogVO->setUsuario($oCooperativa[0]->getNome());
	$oLogVO->setAcao('Acesso: Cooperativa '.$oCooperativa[0]->getNome().' logou no sistema');
	$oLogVO->setPagina($pagina);
	$oLogVO->setIP(getIP());
	$oLogVO->setAcesso(1);
	$oLogVO->setData('Y-m-d H:i:s');
	$Log->inserirLog($oLogVO);

	// INICIA SESSÃO
	session_start();

	$_SESSION["login_cooperativa"]["id"] = $oCooperativa[0]->getCooperativaID();
	$_SESSION["login_cooperativa"]["nome"] = $oCooperativa[0]->getNome();
	$_SESSION["login_cooperativa"]["tempo"] = strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s')));
	$_SESSION["login_cooperativa"]["ip"] = getIP();

	echo 'ok';
	exit;

}else{

	$Log = new Log;
	$oLogVO = new LogVO;
	$oLogVO->setUsuarioID('');
	$oLogVO->setUsuario($email);
	$oLogVO->setAcao('Acesso: Cooperativa '.$email.' tentou logar no sistema');
	$oLogVO->setPagina($pagina);
	$oLogVO->setIP(getIP());
	$oLogVO->setAcesso(1);
	$oLogVO->setData('Y-m-d H:i:s');
	$Log->inserirLog($oLogVO);

	echo 'erro';
	exit;

}