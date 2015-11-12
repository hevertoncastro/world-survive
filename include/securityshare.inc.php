<?php
// INICIA SESSÃO
session_start();

//PEGA IP
include("getIp.php");

//VERIFICA SE TEM PERMISSÃO
if (empty($_SESSION["login_usuario"]["id"]) || empty($_SESSION["login_usuario"]["nome"])){
	header("Location: index");
	exit;
}

//VERIFICA SE O IP É VÁLIDO
if($_SESSION["login_usuario"]["ip"] != getIP()){
	header("Location: index");
	exit;
}
?>
