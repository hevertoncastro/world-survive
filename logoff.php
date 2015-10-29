<?php
//INICIA SESSÃO
session_start();

//DESREGISTRA A SESSÃO ATIVA
unset($_SESSION['login_usuario']);
unset($_SESSION['login_cooperativa']);
//session_destroy();

//REDIRECIONA PARA O LOGIN
header("Location: index");
exit;
?>
