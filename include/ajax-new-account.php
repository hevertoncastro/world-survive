<?php
//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/UsuarioVO.php');
require_once('../class/usuario.class.php');
require_once('../class/LogVO.php');
require_once('../class/log.class.php');

//INCLUI ANT SQL INJECTION
include("antiSQLInjection.php");

//PEGA IP
include("getIp.php");

//PEGA NOME DA PÁGINA ATUAL
$pagina = basename($_SERVER['SCRIPT_NAME']);

//PEGA DADOS POR POST
$name = isset($_POST['name']) ? $_POST['name'] : NULL;
$name = noInjection($name);
$name = trim($name);
$name = strip_tags($name);
$name = addslashes($name);

$email = isset($_POST['email']) ? $_POST['email'] : NULL;
$email = noInjection($email);
$email = trim($email);
$email = strip_tags($email);
$email = addslashes($email);

$senha = isset($_POST['senha']) ? $_POST['senha'] : NULL;
$senha = noInjection($senha);
$senha = trim($senha);
$senha = strip_tags($senha);
$senha = addslashes($senha);

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
if(strlen($senha)<6){
	echo "senha_curta";
	exit;	
}

$Usuario = new Usuario;
$oUsuario = $Usuario->carregarUsuarios(' AND usu_email = "'.$email.'"','','');

if($oUsuario){
	echo "usuario_existe";
	exit;
}


//INSTANCIA A CLASSE
$oUsuarioVO = new UsuarioVO;

//GERA UM ID ALEATÓRIO DE 8 DÍGITOS
$i = 0;
$id = '';		
while($i<8){
	if($i<1){ $id .= rand(1,9);	} else { $id .= rand(0,9); }
	$i++;
}

//SETA OS VALORES
$oUsuarioVO->setUsuarioID($id);
$oUsuarioVO->setNome($name);
$oUsuarioVO->setEmail($email);
$oUsuarioVO->setSenha(hash('sha512',$senha));
$oUsuarioVO->setInclusao(date('Y-m-d H:i:s'));
$oUsuarioVO->setAtivo(1);

//INSERE NOVO USUÁRIO
$oInsereUsuario = $Usuario->inserirUsuario($oUsuarioVO);

if($oInsereUsuario){

	$Log = new Log;
	$oLogVO = new LogVO;
	$oLogVO->setUsuarioID($id);
	$oLogVO->setUsuario($name);
	$oLogVO->setAcao('Conta: Usuário '.$name.' ('.$email.') se cadastrou no sistema');
	$oLogVO->setPagina($pagina);
	$oLogVO->setIP(getIP());
	$oLogVO->setAcesso(0);
	$oLogVO->setData('Y-m-d H:i:s');
	$Log->inserirLog($oLogVO);

	// INICIA SESSÃO
	session_start();

	$_SESSION["login_usuario"]["id"] = $id;
	$_SESSION["login_usuario"]["nome"] = $name;
	$_SESSION["login_usuario"]["tempo"] = strtotime('+30 minutes',strtotime(date('Y-m-d H:i:s')));
	$_SESSION["login_usuario"]["ip"] = getIP();

	echo 'ok';
	exit;

} else {
	echo 'erro';
	exit;
}

