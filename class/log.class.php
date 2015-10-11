<?php

class Log extends LogVO{

	public function inserirLog(LogVO $dados){
	
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "INSERT INTO adm_acoes(log_id,log_usuarioid,log_usuario,log_acao,log_pagina,log_ip,log_acesso,log_data) VALUES (";
		
		$sql .= "'',";
		$sql .= "'".$dados->getUsuarioID()."',";
		$sql .= "'".$dados->getUsuario()."',";
		$sql .= "'".$dados->getAcao()."',";
		$sql .= "'".$dados->getPagina()."',";
		$sql .= "'".$dados->getIP()."',";
		$sql .= "'".$dados->getAcesso()."',";
		$sql .= "'".date('Y-m-d H:i:s')."');";
		
		$retorno = $conexao->incluir($sql);
		
		if($retorno){
			
			return true;
		}else{return false;}
	}
	
	public function consultarLog($id){
		
		$conexao = MySQL::getMySQL();
		
		$log = new LogVO();
		
		$sql = "SELECT * FROM adm_acoes WHERE log_id = ".$id;
		
		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$log->setLogID($consulta[0]['log_id']);
			$log->setUsuarioID($consulta[0]['log_usuarioid']);
			$log->setUsuario($consulta[0]['log_usuario']);
			$log->setAcao($consulta[0]['log_acao']);
			$log->setPagina($consulta[0]['log_pagina']);
			$log->setData($consulta[0]['log_data']);
			
			return $log;
			
		}else{
			return false;
		}
	}
	
	public function carregarLog($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT * FROM adm_acoes WHERE 1=1";
		
		if($where != ''){
			$sql .= $where;
		}
		
		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY log_id';
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
        			$oLogs[$i] = $this->consultarLog($array['log_id']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oLogs;
		
		}else{
			return false;
		}
	}
	
}

?>
