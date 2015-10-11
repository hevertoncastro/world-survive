<?php
class Categoria extends CategoriaVO{

	public function inserirCategoria(CategoriaVO $dados){
	
		$conexao = MySQL::getMySQL();

		$sql = "";
		
		$sql = "INSERT INTO dv_categorias(cat_id,cat_titulo,cat_data,cat_ativo) VALUES (";
		$sql .= $dados->getCategoriaId().",";
		$sql .= "'".$dados->getTitulo()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getAtivo()."');";
				
		$retorno = $conexao->incluir($sql);
		
		if($retorno){
			return $this->consultarCategoria($dados->getCategoriaId());
		}else{return false;}
	}
	
	public function alterarCategoria(CategoriaVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_categorias SET ";
		$sql .=  "cat_titulo = '".$dados->getTitulo()."',";
		$sql .=  "cat_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE cat_id = ".$dados->getCategoriaId();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			
			return true;
		}else{return false;}
		
	}
	
	public function excluirCategoria($id) {
	
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = 'DELETE FROM dv_categorias WHERE cat_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{return false;}
	}
	
	public function consultarCategoria($id){
		
		$conexao = MySQL::getMySQL();
		
		$regra = new CategoriaVO();
		
		$sql = "SELECT * FROM dv_categorias WHERE cat_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$regra->setCategoriaId($consulta[0]['cat_id']);
			$regra->setTitulo($consulta[0]['cat_titulo']);
			$regra->setData($consulta[0]['cat_data']);	
			$regra->setAtivo($consulta[0]['cat_ativo']);
			
			return $regra;
			
		}else{
			return false;
		}
	}
	
	public function carregarCategorias($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT cat_id as aux FROM dv_categorias as cat WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY cat_id DESC';
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
        			$oCategorias[$i] = $this->consultarCategoria($array['aux']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oCategorias;
		
		}else{
			return false;
		}
	}
	
	public function existeCategoria($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT cat_id FROM dv_categorias WHERE cat_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
			return true;			
		}else{
			return false;
		}
	}

	public function ativarCategoria($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_categorias SET cat_ativo = 's' WHERE cat_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function desativarCategoria($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_categorias SET cat_ativo = 'n' WHERE cat_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}
}

?>
