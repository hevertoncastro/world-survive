<?php
class Residuo extends ResiduoVO{

	public function inserirResiduo(ResiduoVO $dados){
	
		$conexao = MySQL::getMySQL();
		
		$sql = "INSERT INTO residuos(res_id,res_nome,res_ativo) VALUES (";
		
		$sql .= $dados->getResiduoID().",";
		$sql .= "'".$dados->getNome()."',";
		$sql .= "'".$dados->getAtivo()."');";

		$retorno = $conexao->incluir($sql);
		
		if($retorno){			
			return $this->consultarResiduo($dados->getResiduoId());
		}else{
			return false;
		}
	}
	
	public function alterarResiduo(ResiduoVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "UPDATE residuos SET ";
		$sql .=  "res_nome = '".$dados->getNome()."', ";
		$sql .=  "res_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE res_id = ".$dados->getResiduoID();
		
		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return $this->consultarResiduo($dados->getResiduoID());
		}else{
			return false;
		}
		
	}
	
	public function excluirResiduo($id) {
	
		$conexao = MySQL::getMySQL(); 
		
		$oResiduo = $this->consultarResiduo($id);
		
		$sql = 'DELETE FROM residuos WHERE res_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarResiduo($id){
		
		$conexao = MySQL::getMySQL();
		
		$residuo = new ResiduoVO();
		
		$sql = "SELECT * FROM residuos WHERE res_id = ".$id;
		
		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$residuo->setResiduoID($consulta[0]['res_id']);
			$residuo->setNome($consulta[0]['res_nome']);
			$residuo->setAtivo($consulta[0]['res_ativo']);

			return $residuo;
			
		}else{
			return false;
		}
	}
	
	public function carregarResiduos($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT * FROM residuos as res WHERE 1=1";
				
		if($where != ''){
			$sql .= $where;
		}
		
		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY res_nome';
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
        			$oResiduos[$i] = $this->consultarResiduo($array['res_id']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oResiduos;
		
		}else{
			return false;
		}
	}
}
?>
