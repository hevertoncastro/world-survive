<?php
class Regra extends RegraVO{

	public function inserirRegra(RegraVO $dados){
	
		$conexao = MySQL::getMySQL();

		$sql = "";
		
		$sql = "INSERT INTO dv_regras(reg_id,reg_titulo,reg_data,reg_ativo) VALUES (";
		$sql .= $dados->getRegraId().",";
		$sql .= "'".$dados->getTitulo()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getAtivo()."');";
				
		$retorno = $conexao->incluir($sql);
		
		if($retorno){
			return $this->consultarRegra($dados->getRegraId());
		}else{
			return false;
		}
	}
	
	public function alterarRegra(RegraVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_regras SET ";
		$sql .=  "reg_titulo = '".$dados->getTitulo()."',";
		$sql .=  "reg_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE reg_id = ".$dados->getRegraId();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return true;
		}else{
			return false;
		}
		
	}
	
	public function excluirRegra($id) {
	
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = 'DELETE FROM dv_regras WHERE reg_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarRegra($id){
		
		$conexao = MySQL::getMySQL();
		
		$regra = new RegraVO();
		
		$sql = "SELECT * FROM dv_regras WHERE reg_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$regra->setRegraId($consulta[0]['reg_id']);
			$regra->setTitulo($consulta[0]['reg_titulo']);
			$regra->setData($consulta[0]['reg_data']);	
			$regra->setAtivo($consulta[0]['reg_ativo']);

			return $regra;	

		}else{
			return false;
		}
	}
	
	public function carregarRegras($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT reg_id as aux FROM dv_regras as reg WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY reg_id DESC';
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
        			$oRegras[$i] = $this->consultarRegra($array['aux']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oRegras;
		
		}else{
			return false;
		}
	}

	public function carregarRegrasCupom($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';

		$sql = "SELECT reg_id as aux FROM dv_regras INNER JOIN dv_cupom_regra ON dv_regras.reg_id = dv_cupom_regra.crg_regra_id WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY reg_data DESC';
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
        			$oRegras[$i] = $this->consultarRegra($array['aux']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oRegras;
		
		}else{
			return false;
		}
	}
	
	public function existeRegra($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT reg_id FROM dv_regras WHERE reg_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
			return true;			
		}else{
			return false;
		}
	}
	
	public function existeCupomRegra($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT crg_id FROM dv_cupom_regra WHERE crg_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
			return true;			
		}else{
			return false;
		}
	}
	
	public function consultarArray($cupom, $regra){
	
		$conexao = MySQL::getMySQL();

		$sql = "SELECT crg_id FROM dv_cupom_regra WHERE crg_regra_id=".$regra." AND crg_cupom_id=".$cupom." LIMIT 1";
		
		$consulta = '';
		
		$consulta = $conexao->consultar($sql);

		if($consulta){
        	if (count($consulta)> 0) {
				return true;
        	} else {
				return false;
			}
			$conexao->fechaConexao();
		
		}else{
			return false;
		}
	}

	public function ativarRegra($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_regras SET reg_ativo = 's' WHERE reg_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function desativarRegra($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_regras SET reg_ativo = 'n' WHERE reg_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}
}

?>
