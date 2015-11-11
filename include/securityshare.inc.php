<?php
// INICIA SESSÃO
session_start();

//PEGA IP
include("getIp.php");

//VERIFICA SE TEM PERMISSÃO
if (empty($_SESSION["login_cooperativa"]["id"]) || empty($_SESSION["login_cooperativa"]["nome"])){
	header("Location: index");
	exit;
}

//VERIFICA SE O IP É VÁLIDO
if($_SESSION["login_cooperativa"]["ip"] != getIP()){
	header("Location: index");
	exit;
}
?>
