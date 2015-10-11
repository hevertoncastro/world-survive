<?php
//INICIA SESSÃO
session_start();

//DESREGISTRA A SESSÃO ATIVA
unset($_SESSION['login_usuario']);
//session_destroy();

//REDIRECIONA PARA O LOGIN
header("Location: index");
exit;
?>
