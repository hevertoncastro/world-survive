<?php
// INICIA SESSÃO
session_start();

//PEGA IP
include("getIp.php");

//VERIFICA SE TEM PERMISSÃO
if (empty($_SESSION["login_cooperativa"]["id"]) || empty($_SESSION["login_cooperativa"]["nome"])){
	header("Location: adm?res=sem_permissao");
	exit;
}

//VERIFICA SE O IP É VÁLIDO
if($_SESSION["login_cooperativa"]["ip"] != getIP()){
	header("Location: adm?res=sem_permissao");
	exit;
}

//VERIFICA SE O TEMPO SEM USO É MAIOR QUE O PERMITIDO AO LOGAR
if(isset($_SESSION["login_cooperativa"]["tempo"]) && date('Y-m-d H:i:s') > date('Y-m-d H:i:s',$_SESSION["login_cooperativa"]["tempo"])){
	header("Location: adm?res=tempo_excedido");
	exit;
} else {
	//CASO NÃO SEJA, ATRIBUI MAIS 30 MINUTOS DA HORA ATUAL
	$_SESSION["login_cooperativa"]["tempo"] = strtotime('+30minutes',strtotime(date('Y-m-d H:i:s')));
}
?>
