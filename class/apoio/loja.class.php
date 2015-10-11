<?php
class Loja extends LojaVO{

	public function inserirLoja(LojaVO $dados){
	
		$conexao = MySQL::getMySQL();

		$sql = "";
		
		$sql = "INSERT INTO dv_lojas(loj_id,loj_nome,loj_sobre,loj_link,loj_tags,loj_cliques,loj_logo,loj_data,loj_ativo) VALUES (";
		$sql .= $dados->getLojaId().",";
		$sql .= "'".$dados->getNome()."',";
		$sql .= "'".$dados->getSobre()."',";
		$sql .= "'".$dados->getLink()."',";
		$sql .= "'".$dados->getTags()."',";
		$sql .= "'".$dados->getCliques()."',";
		$sql .= "'".$dados->getLogo()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getAtivo()."');";
				
		$retorno = $conexao->incluir($sql);
		
		if($retorno){
			return $this->consultarLoja($dados->getLojaId());
		}else{
			return false;
		}
	}
	
	public function alterarLoja(LojaVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_lojas SET ";
		$sql .=  "loj_nome = '".$dados->getNome()."',";
		$sql .=  "loj_sobre = '".$dados->getSobre()."',";
		$sql .=  "loj_link = '".$dados->getLink()."',";
		$sql .=  "loj_tags = '".$dados->getTags()."',";
		$sql .=  "loj_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE loj_id = ".$dados->getLojaId();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return true;
		}else{
			return false;
		}
		
	}
	
	public function excluirLoja($id) {
	
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = 'DELETE FROM dv_lojas WHERE loj_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarLoja($id){
		
		$conexao = MySQL::getMySQL();
		
		$loja = new LojaVO();
		
		$sql = "SELECT * FROM dv_lojas WHERE loj_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$loja->setLojaId($consulta[0]['loj_id']);
			$loja->setNome($consulta[0]['loj_nome']);
			$loja->setSobre($consulta[0]['loj_sobre']);
			$loja->setLink($consulta[0]['loj_link']);
			$loja->setTags($consulta[0]['loj_tags']);
			$loja->setCliques($consulta[0]['loj_cliques']);
			$loja->setLogo($consulta[0]['loj_logo']);
			$loja->setData($consulta[0]['loj_data']);	
			$loja->setAtivo($consulta[0]['loj_ativo']);
			
			return $loja;
			
		}else{
			return false;
		}
	}
	
	public function carregarLojas($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT loj_id as aux FROM dv_lojas as loj WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY loj_id DESC';
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
        			$oLojas[$i] = $this->consultarLoja($array['aux']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oLojas;
		
		}else{
			return false;
		}
	}
	
	public function existeLoja($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT loj_id FROM dv_lojas WHERE loj_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
			return true;			
		}else{
			return false;
		}
	}
	
	public function alterarLogo(LojaVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_lojas SET ";
		$sql .=  "loj_logo = '".$dados->getLogo()."'";
		
		$sql .= " WHERE loj_id = ".$dados->getLojaId();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return true;
		}else{
			return false;
		}
		
	}
	
	public function excluirLogo($id) {
	
		$conexao = MySQL::getMySQL();

		$oLoja = $this->consultarLoja($id);

		$logoAntiga = $oLoja->getLogo();

		if(!empty($logoAntiga)){
			$antiga = '../imagens/logos/'.$logoAntiga;
			if(file_exists($antiga)){
				unlink($antiga);
			}						
		}		

		$sql = "";		
		$sql = "UPDATE dv_lojas SET loj_logo = ''";		
		$sql .= " WHERE loj_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
						
			return true;
		}else{return false;}
	}

	public function atualizaCliques($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_lojas SET loj_cliques = loj_cliques+1 WHERE loj_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function ativarLoja($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_lojas SET loj_ativo = 's' WHERE loj_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function desativarLoja($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_lojas SET loj_ativo = 'n' WHERE loj_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}
}

?>
