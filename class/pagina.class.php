<?php
class Pagina extends PaginaVO{

	public function inserirPagina(PaginaVO $dados){

		$conexao = MySQL::getMySQL();

		$sql = "";

		$sql = "INSERT INTO adm_paginas(pag_id,pag_area,pag_titulo,pag_texto,pag_data,pag_ativo) VALUES (";
		$sql .= $dados->getPaginaId().",";
		$sql .= "'".$dados->getArea()."',";
		$sql .= "'".$dados->getTitulo()."',";
		$sql .= "'".$dados->getTexto()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getAtivo()."');";

		$retorno = $conexao->incluir($sql);

		if($retorno){
			return $this->consultarPagina($dados->getPaginaId());
		}else{
			return false;
		}
	}

	public function alterarPagina(PaginaVO $dados) {

		$conexao = MySQL::getMySQL();

		$sql = "";

		$sql = "UPDATE adm_paginas SET ";
		$sql .=  "adm_nome = '".$dados->getNome()."',";
		$sql .=  "adm_sobre = '".$dados->getSobre()."',";
		$sql .=  "adm_link = '".$dados->getLink()."',";
		$sql .=  "adm_tags = '".$dados->getTags()."',";
		$sql .=  "adm_ativo = '".$dados->getAtivo()."'";

		$sql .= " WHERE pag_id = ".$dados->getPaginaId();

		$retorno = $conexao->alterar($sql);

		if($retorno){
			return true;
		}else{
			return false;
		}

	}

	public function excluirPagina($id) {

		$conexao = MySQL::getMySQL();

		$sql = '';

		$sql = 'DELETE FROM adm_paginas WHERE pag_id = '.$id;

		$retorno = $conexao->excluir($sql);

		$conexao->fechaConexao();

		if($retorno){
			return true;
		}else{
			return false;
		}
	}

	public function consultarPagina($id){

		$conexao = MySQL::getMySQL();

		$loja = new PaginaVO();

		$sql = "SELECT * FROM adm_paginas WHERE pag_id = ".$id;

		$consulta = $conexao->consultar($sql);

		if($consulta){

			$loja->setPaginaId($consulta[0]['pag_id']);
			$loja->setNome($consulta[0]['adm_nome']);
			$loja->setSobre($consulta[0]['adm_sobre']);
			$loja->setLink($consulta[0]['adm_link']);
			$loja->setTags($consulta[0]['adm_tags']);
			$loja->setCliques($consulta[0]['adm_cliques']);
			$loja->setLogo($consulta[0]['adm_logo']);
			$loja->setData($consulta[0]['adm_data']);	
			$loja->setAtivo($consulta[0]['adm_ativo']);

			return $loja;

		}else{
			return false;
		}
	}

	public function carregarPaginas($where, $order, $limit){

		$conexao = MySQL::getMySQL();

		$sql = '';

		$sql = "SELECT pag_id as aux FROM adm_paginas as loj WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY pag_id DESC';
		}

		if ($limit!=''){
   			$sql .= ' LIMIT '.$limit;
   		}

		$consulta = '';

		$consulta = $conexao->consultar($sql);

		if($consulta){
			$i=0;
        	if (count($consulta)> 0) {

				$size = count($consulta);

				foreach($consulta as $array) {
        			$oPaginas[$i] = $this->consultarPagina($array['aux']);
        			$i++;
				}
        	}
			$conexao->fechaConexao();
			return $oPaginas;

		}else{
			return false;
		}
	}

	public function existePagina($id){

		$conexao = MySQL::getMySQL();

		$sql = "SELECT pag_id FROM adm_paginas WHERE pag_id = ".$id;

		$consulta = $conexao->consultar($sql);

		if($consulta){
			return true;
		}else{
			return false;
		}
	}

	public function ativarPagina($id) {

		$conexao = MySQL::getMySQL();

		$sql = "";

		$sql = "UPDATE adm_paginas SET adm_ativo = 's' WHERE pag_id = ".$id;

		$retorno = $conexao->alterar($sql);

		if($retorno){
			return true;
		}else{
			return false;
		}

	}

	public function desativarPagina($id) {

		$conexao = MySQL::getMySQL();

		$sql = "";

		$sql = "UPDATE adm_paginas SET adm_ativo = 'n' WHERE pag_id = ".$id;

		$retorno = $conexao->alterar($sql);

		if($retorno){
			return true;
		}else{
			return false;
		}

	}
}

?>
