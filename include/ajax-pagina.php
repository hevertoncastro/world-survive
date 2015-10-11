<?php
//INCLUI CONEXÃO COM O BD
require_once('conection.inc.php');

//VERIFICA PERMISSÃO
require_once('security.inc.php');

//INCLUI CLASSES
require_once('../class/MySQL.class.php');
require_once('../class/UsuarioVO.php');
require_once('../class/usuario.class.php');
require_once('../class/LogVO.php');
require_once('../class/log.class.php');

require_once('../class/PaginaVO.php');
require_once('../class/pagina.class.php');

//PEGA NOME DA PÁGINA ATUAL
$pagina = basename($_SERVER['SCRIPT_NAME']);

//DADOS FORMULÁRIO
foreach($_POST as $key => $value) {
  $$key = (isset($key)) ? $value : NULL;
}

//VALIDAÇÕES
if(empty($nome)){
	echo "nome";
	exit;
}

if(empty($sobre)){
	echo "sobre";
	exit;
}

if(empty($link)){
	echo "link";
	exit;
}

if(isset($id) && !empty($id)){

	$Pagina = new Loja;
	$oPaginaVO = new LojaVO;

	$oPaginaVO->setLojaId($id);
	$oPaginaVO->setNome($nome);
	$oPaginaVO->setSobre($sobre);
	$oPaginaVO->setLink($link);
	$oPaginaVO->setTags($tags);
	$oPaginaVO->setAtivo($ativo);

	$oLoja = $Pagina->alterarLoja($oPaginaVO);

	if($oLoja){

		$oLogVO = new LogVO;
		$oLogVO->setUsuarioID($_SESSION["login_usuario"]["id"]);
		$oLogVO->setUsuario($_SESSION["login_usuario"]["nome"]);
		$oLogVO->setAcao('Alteração: Usuário '.$_SESSION["login_usuario"]["nome"].' alterou a loja '.$nome.' ('.$id.')');
		$oLogVO->setPagina($pagina);
		$oLogVO->setIP(getIP());
		$oLogVO->setAcesso(0);
		$oLogVO->setData('Y-m-d H:i:s');
		$Log = new Log;
		$Log->inserirLog($oLogVO);
		echo "ok";
		exit;

	} else {
		echo "erro_sql";
		exit;
	}

} else {

	$Pagina = new Loja;
	$oPaginaVO = new LojaVO;

	do{
	$i = 0;$id = '';
	while($i<4){
		//GERA UM ID ALEATÓRIO DE 4 DÍGITOS
		if($i<1){ $id .= rand(1,9);	} else { $id .= rand(0,9); }
		$i++;
	}
	//ENQUANTO EXISTIR, GERAR NOVO
	}while($Pagina->existeLoja($id));

	$oPaginaVO->setLojaId($id);
	$oPaginaVO->setNome($nome);
	$oPaginaVO->setSobre($sobre);
	$oPaginaVO->setLink($link);
	$oPaginaVO->setTags($tags);
	$oPaginaVO->setCliques(0);
	$oPaginaVO->setLogo('');
	$oPaginaVO->setData(date('Y-m-d'));
	$oPaginaVO->setAtivo($ativo);

	$oLoja = $Pagina->inserirLoja($oPaginaVO);

	if($oLoja){

		$oLogVO = new LogVO;
		$oLogVO->setUsuarioID($_SESSION["login_usuario"]["id"]);
		$oLogVO->setUsuario($_SESSION["login_usuario"]["nome"]);
		$oLogVO->setAcao('Inserção: Usuário '.$_SESSION["login_usuario"]["nome"].' inseriu a loja '.$nome.' ('.$id.')');
		$oLogVO->setPagina($pagina);
		$oLogVO->setIP(getIP());
		$oLogVO->setAcesso(0);
		$oLogVO->setData('Y-m-d H:i:s');
		$Log = new Log;
		$Log->inserirLog($oLogVO);
		echo $id;
		exit;

	} else {
		echo "erro_sql";
		exit;
	}
}
?>