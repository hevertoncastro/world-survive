<?php
//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/ColetaVO.php');
require_once('../class/coleta.class.php');
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

//INSTANCIA A CLASSE
$Coleta = new Coleta;

//INSERE NOVO USUÁRIO
$oAlteraFuncionario = $Coleta->alterarFuncionario($coletaid, $worker);

if($oAlteraFuncionario){

	$Log = new Log;
	$oLogVO = new LogVO;
	$oLogVO->setUsuarioID($usuarioID);
	$oLogVO->setUsuario($usuarioNome);
	$oLogVO->setAcao('Coleta: Usuário '.$usuarioNome.' atribuiu a coleta '.$coletaid.' para o funcionário '.$worker);
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

