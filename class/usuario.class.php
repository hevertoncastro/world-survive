<?php
class Usuario extends UsuarioVO{

	public function inserirUsuario(UsuarioVO $dados){
	
		$conexao = MySQL::getMySQL();
		
		$sql = "INSERT INTO usuarios(usu_id,usu_nome,usu_email,usu_senha,usu_cep,usu_endereco,usu_numero,usu_complemento,usu_bairro,usu_cidade,usu_estado,usu_celular,usu_inclusao,usu_ativo) VALUES (";
		
		$sql .= $dados->getUsuarioID().",";
		$sql .= "'".$dados->getNome()."',";
		$sql .= "'".$dados->getEmail()."',";
		$sql .= "'".$dados->getSenha()."',";
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
			return $this->consultarUsuario($dados->getUsuarioId());
		}else{
			return false;
		}
	}
	
	public function alterarUsuario(UsuarioVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE usuarios SET ";
		$sql .=  "usu_nome = '".$dados->getNome()."', ";
		$sql .=  "usu_email = '".$dados->getEmail()."', ";
		$sql .=  "usu_senha = '".$dados->getSenha()."', ";
		$sql .=  "usu_cep = '".$dados->getCep()."', ";
		$sql .=  "usu_endereco = '".$dados->getEndereco()."', ";
		$sql .=  "usu_numero = '".$dados->getNumero()."', ";
		$sql .=  "usu_complemento = '".$dados->getComplemento()."', ";
		$sql .=  "usu_bairro = '".$dados->getBairro()."', ";
		$sql .=  "usu_cidade = '".$dados->getCidade()."', ";
		$sql .=  "usu_estado = '".$dados->getEstado()."', ";
		$sql .=  "usu_celular = '".$dados->getCelular()."', ";
		$sql .=  "usu_inclusao = '".$dados->getInclusao()."', ";
		$sql .=  "usu_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE usu_id = ".$dados->getUsuarioID();
		
		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return $this->consultarUsuario($dados->getUsuarioID());
		}else{
			return false;
		}
		
	}
	
	public function alterarMinhaConta(UsuarioVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE usuarios SET ";
		$sql .=  "usu_nome = '".addslashes($dados->getNome())."',";
		$sql .=  "usu_senha = '".md5(addslashes($dados->getSenha()))."'";
		
		$sql .= " WHERE usu_id = ".$dados->getUsuarioID();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return $this->consultarUsuario($dados->getUsuarioID());
		}else{
			return false;
		}
		
	}
	
	public function excluirUsuario($id) {
	
		$conexao = MySQL::getMySQL(); 
		
		$oUsuario = $this->consultarUsuario($id);
		
		$sql = '';
		
		$sql = 'DELETE FROM usuarios WHERE usu_id = '.$id;
		
		$retorno = $conexao->excluir($sql);
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarUsuario($id){
		
		$conexao = MySQL::getMySQL();
		
		$usuario = new UsuarioVO();
		
		$sql = "SELECT * FROM usuarios WHERE usu_id = ".$id;
		
		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$usuario->setUsuarioID($consulta[0]['usu_id']);
			$usuario->setNome($consulta[0]['usu_nome']);
			$usuario->setEmail($consulta[0]['usu_email']);
			$usuario->setSenha($consulta[0]['usu_senha']);
			$usuario->setCep($consulta[0]['usu_cep']);
			$usuario->setEndereco($consulta[0]['usu_endereco']);
			$usuario->setNumero($consulta[0]['usu_numero']);
			$usuario->setComplemento($consulta[0]['usu_complemento']);
			$usuario->setBairro($consulta[0]['usu_bairro']);
			$usuario->setCidade($consulta[0]['usu_cidade']);
			$usuario->setEstado($consulta[0]['usu_estado']);
			$usuario->setCelular($consulta[0]['usu_celular']);
			$usuario->setInclusao($consulta[0]['usu_inclusao']);
			$usuario->setAtivo($consulta[0]['usu_ativo']);

			return $usuario;
			
		}else{
			return false;
		}
	}
	
	public function carregarUsuarios($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT * FROM usuarios as usu WHERE 1=1";
				
		if($where != ''){
			$sql .= $where;
		}
		
		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY usu_nome';
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
        			$oUsuarios[$i] = $this->consultarUsuario($array['usu_id']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oUsuarios;
		
		}else{
			return false;
		}
	}

	public function existeUsuario($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT usu_id FROM usuarios WHERE usu_id = ".$id;

		$consulta = $conexao->consultar($sql);
		
		if($consulta){
			return true;			
		}else{
			return false;
		}
	}

	public function ativarUsuario($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE usuarios SET usu_ativo = 's' WHERE usu_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function desativarUsuario($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE usuarios SET usu_ativo = 'n' WHERE usu_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}	
}
?>
