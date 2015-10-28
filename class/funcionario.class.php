<?php
class Funcionario extends FuncionarioVO{

	public function inserirFuncionario(FuncionarioVO $dados){

		$conexao = MySQL::getMySQL();

		$sql = "INSERT INTO funcionarios(fun_id,fun_coo,fun_nome,fun_cpf,fun_cep,fun_endereco,fun_numero,fun_complemento,fun_bairro,fun_cidade,fun_estado,fun_celular,fun_inclusao,fun_ativo) VALUES (";

		$sql .= $dados->getFuncionarioID().",";
		$sql .= $dados->getCooperativaID().",";
		$sql .= "'".$dados->getNome()."',";
		$sql .= "'".$dados->getCpf()."',";
		$sql .= "'".$dados->getCep()."',";
		$sql .= "'".$dados->getEndereco()."',";
		$sql .= "'".$dados->getNumero()."',";
		$sql .= "'".$dados->getComplemento()."',";
		$sql .= "'".$dados->getBairro()."',";
		$sql .= "'".$dados->getCidade()."',";
		$sql .= "'".$dados->getEstado()."',";
		$sql .= "'".$dados->getCelular()."',";
		$sql .= "'".$dados->getInclusao()."',";
		$sql .= "'".$dados->getAtivo()."');";

		$retorno = $conexao->incluir($sql);

		if($retorno){
			return $this->consultarFuncionario($dados->getFuncionarioId());
		}else{
			return false;
		}
	}

	public function alterarFuncionario(FuncionarioVO $dados) {

		$conexao = MySQL::getMySQL();

		$sql = "UPDATE funcionarios SET ";
		$sql .=  "fun_coo = '".$dados->getCooperativaID()."', ";
		$sql .=  "fun_nome = '".$dados->getNome()."', ";
		$sql .=  "fun_cpf = '".$dados->getCep()."', ";
		$sql .=  "fun_cep = '".$dados->getCep()."', ";
		$sql .=  "fun_endereco = '".$dados->getEndereco()."', ";
		$sql .=  "fun_numero = '".$dados->getNumero()."', ";
		$sql .=  "fun_complemento = '".$dados->getComplemento()."', ";
		$sql .=  "fun_bairro = '".$dados->getBairro()."', ";
		$sql .=  "fun_cidade = '".$dados->getCidade()."', ";
		$sql .=  "fun_estado = '".$dados->getEstado()."', ";
		$sql .=  "fun_celular = '".$dados->getCelular()."', ";
		$sql .=  "fun_inclusao = '".$dados->getInclusao()."', ";
		$sql .=  "fun_ativo = '".$dados->getAtivo()."'";

		$sql .= " WHERE fun_id = ".$dados->getFuncionarioID();

		$retorno = $conexao->alterar($sql);

		if($retorno){
			return $this->consultarFuncionario($dados->getFuncionarioID());
		}else{
			return false;
		}

	}

	public function excluirFuncionario($id) {

		$conexao = MySQL::getMySQL();

		$oFuncionario = $this->consultarFuncionario($id);

		$sql = 'DELETE FROM funcionarios WHERE fun_id = '.$id;

		$retorno = $conexao->excluir($sql);

		$conexao->fechaConexao();

		if($retorno){
			return true;
		}else{
			return false;
		}
	}

	public function consultarFuncionario($id){

		$conexao = MySQL::getMySQL();

		$funcionario = new FuncionarioVO();

		$sql = "SELECT * FROM funcionarios WHERE fun_id = ".$id;

		$consulta = $conexao->consultar($sql);

		if($consulta){

			$funcionario->setFuncionarioID($consulta[0]['fun_id']);
			$funcionario->setCooperativaID($consulta[0]['fun_coo']);
			$funcionario->setNome($consulta[0]['fun_nome']);
			$funcionario->setCpf($consulta[0]['fun_cpf']);
			$funcionario->setCep($consulta[0]['fun_cep']);
			$funcionario->setEndereco($consulta[0]['fun_endereco']);
			$funcionario->setNumero($consulta[0]['fun_numero']);
			$funcionario->setComplemento($consulta[0]['fun_complemento']);
			$funcionario->setBairro($consulta[0]['fun_bairro']);
			$funcionario->setCidade($consulta[0]['fun_cidade']);
			$funcionario->setEstado($consulta[0]['fun_estado']);
			$funcionario->setCelular($consulta[0]['fun_celular']);
			$funcionario->setInclusao($consulta[0]['fun_inclusao']);
			$funcionario->setAtivo($consulta[0]['fun_ativo']);

			return $funcionario;

		}else{
			return false;
		}
	}

	public function carregarFuncionarios($where, $order, $limit){

		$conexao = MySQL::getMySQL();

		$sql = "SELECT * FROM funcionarios as fun WHERE 1=1";

		if($where != ''){
			$sql .= $where;
		}

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY fun_nome';
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
        			$oFuncionarios[$i] = $this->consultarFuncionario($array['fun_id']);
        			$i++;
				}
        	}
			$conexao->fechaConexao();
			return $oFuncionarios;

		}else{
			return false;
		}
	}
}
?>
