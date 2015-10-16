<?php
class Coleta extends ColetaVO{

	public function inserirColeta(ColetaVO $dados){

		$conexao = MySQL::getMySQL();

		$sql = "INSERT INTO coletas(col_id,usu_id,coo_id,fun_id,col_data,col_periodo,col_qtde,col_inclusao,col_situacao) VALUES (";

		$sql .= $dados->getColetaID().",";
		$sql .= "'".$dados->getUsuarioID()."',";
		$sql .= "'".$dados->getCooperativaID()."',";
		$sql .= "'".$dados->getFuncionarioID()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getPeriodo()."',";
		$sql .= "'".$dados->getQtde()."',";
		$sql .= "'".$dados->getInclusao()."',";
		$sql .= "'".$dados->getSituacao()."');";

		$retorno = $conexao->incluir($sql);

		if($retorno){
			return $this->consultarColeta($dados->getColetaId());
		}else{
			return false;
		}
	}
	public function inserirItens($coleta,$residuo){

		$conexao = MySQL::getMySQL();

		$sql = "INSERT INTO itens(col_id,res_id) VALUES (";

		$sql .= "'".$coleta."',";
		$sql .= "'".$residuo."');";

		$retorno = $conexao->incluir($sql);

		return $retorno;
	}

	public function alterarColeta(ColetaVO $dados) {

		$conexao = MySQL::getMySQL();

		$sql = "UPDATE coletas SET ";
		$sql .=  "res_nome = '".$dados->getNome()."', ";
		$sql .=  "res_ativo = '".$dados->getAtivo()."'";

		$sql .= " WHERE col_id = ".$dados->getColetaID();

		$retorno = $conexao->alterar($sql);

		if($retorno){
			return $this->consultarColeta($dados->getColetaID());
		}else{
			return false;
		}

	}

	public function excluirColeta($id) {

		$conexao = MySQL::getMySQL(); 

		$oColeta = $this->consultarColeta($id);

		$sql = 'DELETE FROM coletas WHERE col_id = '.$id;

		$retorno = $conexao->excluir($sql);

		$conexao->fechaConexao();

		if($retorno){
			return true;
		}else{
			return false;
		}
	}

	public function consultarColeta($id){

		$conexao = MySQL::getMySQL();

		$coleta = new ColetaVO();

		$sql = "SELECT * FROM coletas WHERE col_id = ".$id;

		$consulta = $conexao->consultar($sql);

		if($consulta){

			$coleta->setColetaID($consulta[0]['col_id']);
			$coleta->setUsuarioID($consulta[0]['usu_id']);
			$coleta->setCooperativaID($consulta[0]['coo_id']);
			$coleta->setFuncionarioID($consulta[0]['fun_id']);
			$coleta->setData($consulta[0]['col_data']);
			$coleta->setPeriodo($consulta[0]['col_periodo']);
			$coleta->setQtde($consulta[0]['col_qtde']);
			$coleta->setInclusao($consulta[0]['col_inclusao']);
			$coleta->setSituacao($consulta[0]['col_situacao']);

			return $coleta;

		}else{
			return false;
		}
	}

	public function carregarColetas($where, $order, $limit){

		$conexao = MySQL::getMySQL();

		$sql = "SELECT * FROM coletas as res WHERE 1=1";

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
        			$oColetas[$i] = $this->consultarColeta($array['col_id']);
        			$i++;
				}
        	}
			$conexao->fechaConexao();
			return $oColetas;

		}else{
			return false;
		}
	}
}
?>
