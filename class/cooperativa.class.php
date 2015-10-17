<?php
class Cooperativa extends CooperativaVO{

	public function inserirCooperativa(CooperativaVO $dados){
	
		$conexao = MySQL::getMySQL();

		$sql = "INSERT INTO cooperativas(coo_id,coo_nome,coo_email,coo_senha,coo_razao,coo_cnpj,coo_cep,coo_endereco,coo_numero,coo_complemento,coo_bairro,coo_cidade,coo_estado,coo_lat,coo_lng,coo_telefone,coo_inclusao,coo_ativo) VALUES (";
		
		$sql .= $dados->getCooperativaID().",";
		$sql .= "'".$dados->getNome()."',";
		$sql .= "'".$dados->getEmail()."',";
		$sql .= "'".$dados->getSenha()."',";
		$sql .= "'".$dados->getRazao()."',";
		$sql .= "'".$dados->getCnpj()."',";
		$sql .= "'".$dados->getCep()."',";
		$sql .= "'".$dados->getEndereco()."',";
		$sql .= "'".$dados->getNumero()."',";
		$sql .= "'".$dados->getComplemento()."',";
		$sql .= "'".$dados->getBairro()."',";
		$sql .= "'".$dados->getCidade()."',";
		$sql .= "'".$dados->getEstado()."',";
		$sql .= "'".$dados->getLatitude()."',";
		$sql .= "'".$dados->getLongitude()."',";
		$sql .= "'".$dados->getTelefone()."',";
		$sql .= "'".$dados->getInclusao()."',";
		$sql .= "'".$dados->getAtivo()."');";

		$retorno = $conexao->incluir($sql);
		
		if($retorno){			
			return $this->consultarCooperativa($dados->getCooperativaId());
		}else{
			return false;
		}
	}
	
	public function alterarCooperativa(CooperativaVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "UPDATE cooperativas SET ";
		$sql .=  "coo_nome = '".$dados->getNome()."', ";
		$sql .=  "coo_email = '".$dados->getEmail()."', ";
		$sql .=  "coo_senha = '".$dados->getSenha()."', ";
		$sql .=  "coo_razao = '".$dados->getRazao()."', ";
		$sql .=  "coo_cnpj = '".$dados->getCnpj()."', ";
		$sql .=  "coo_cep = '".$dados->getCep()."', ";
		$sql .=  "coo_endereco = '".$dados->getEndereco()."', ";
		$sql .=  "coo_numero = '".$dados->getNumero()."', ";
		$sql .=  "coo_complemento = '".$dados->getComplemento()."', ";
		$sql .=  "coo_bairro = '".$dados->getBairro()."', ";
		$sql .=  "coo_cidade = '".$dados->getCidade()."', ";
		$sql .=  "coo_estado = '".$dados->getEstado()."', ";
		$sql .=  "coo_lat = '".$dados->getLatitude()."', ";
		$sql .=  "coo_lng = '".$dados->getLongitude()."', ";
		$sql .=  "coo_telefone = '".$dados->getTelefone()."', ";
		$sql .=  "coo_inclusao = '".$dados->getInclusao()."', ";
		$sql .=  "coo_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE coo_id = ".$dados->getCooperativaID();
		
		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return $this->consultarCooperativa($dados->getCooperativaID());
		}else{
			return false;
		}
		
	}

	public function alterarEndereco(CooperativaVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "UPDATE cooperativas SET ";
		$sql .=  "coo_cep = '".$dados->getCep()."', ";
		$sql .=  "coo_endereco = '".$dados->getEndereco()."', ";
		$sql .=  "coo_numero = '".$dados->getNumero()."', ";
		$sql .=  "coo_complemento = '".$dados->getComplemento()."', ";
		$sql .=  "coo_bairro = '".$dados->getBairro()."', ";
		$sql .=  "coo_cidade = '".$dados->getCidade()."', ";
		$sql .=  "coo_estado = '".$dados->getEstado()."', ";
		$sql .=  "coo_lat = '".$dados->getLatitude()."', ";
		$sql .=  "coo_lng = '".$dados->getLongitude()."'";
		
		$sql .= " WHERE coo_id = ".$dados->getCooperativaID();
		
		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return $this->consultarCooperativa($dados->getCooperativaID());
		}else{
			return false;
		}
		
	}
	
	public function excluirCooperativa($id) {
	
		$conexao = MySQL::getMySQL(); 
		
		$oCooperativa = $this->consultarCooperativa($id);
		
		$sql = 'DELETE FROM cooperativas WHERE coo_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarCooperativa($id){
		
		$conexao = MySQL::getMySQL();
		
		$cooperativa = new CooperativaVO();
		
		$sql = "SELECT * FROM cooperativas WHERE coo_id = ".$id;
		
		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$cooperativa->setCooperativaID($consulta[0]['coo_id']);
			$cooperativa->setNome($consulta[0]['coo_nome']);
			$cooperativa->setEmail($consulta[0]['coo_email']);
			$cooperativa->setSenha($consulta[0]['coo_senha']);
			$cooperativa->setRazao($consulta[0]['coo_razao']);
			$cooperativa->setCnpj($consulta[0]['coo_cnpj']);
			$cooperativa->setCep($consulta[0]['coo_cep']);
			$cooperativa->setEndereco($consulta[0]['coo_endereco']);
			$cooperativa->setNumero($consulta[0]['coo_numero']);
			$cooperativa->setComplemento($consulta[0]['coo_complemento']);
			$cooperativa->setBairro($consulta[0]['coo_bairro']);
			$cooperativa->setCidade($consulta[0]['coo_cidade']);
			$cooperativa->setEstado($consulta[0]['coo_estado']);
			$cooperativa->setLatitude($consulta[0]['coo_lat']);
			$cooperativa->setLongitude($consulta[0]['coo_lng']);
			$cooperativa->setTelefone($consulta[0]['coo_telefone']);
			$cooperativa->setInclusao($consulta[0]['coo_inclusao']);
			$cooperativa->setAtivo($consulta[0]['coo_ativo']);

			return $cooperativa;
			
		}else{
			return false;
		}
	}
	
	public function carregarCooperativas($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT * FROM cooperativas as coo WHERE 1=1";
				
		if($where != ''){
			$sql .= $where;
		}
		
		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY coo_nome';
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
        			$oCooperativas[$i] = $this->consultarCooperativa($array['coo_id']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oCooperativas;
		
		}else{
			return false;
		}
	}
}
?>
