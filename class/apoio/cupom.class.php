<?php
class Cupom extends CupomVO{

	public function inserirCupom(CupomVO $dados){
	
		$conexao = MySQL::getMySQL();

		$sql = "";
		
		$sql = "INSERT INTO dv_cupons(cup_id,cup_categoria,cup_loja,cup_titulo,cup_codigo,cup_link,cup_descricao,cup_regras,cup_curtidas,cup_cliques,cup_data,cup_expira,cup_alterado,cup_tipo,cup_ativo) VALUES (";
		$sql .= $dados->getCupomId().",";
		$sql .= $dados->getCategoriaId().",";
		$sql .= $dados->getLojaId().",";
		$sql .= "'".$dados->getTitulo()."',";
		$sql .= "'".$dados->getCodigo()."',";
		$sql .= "'".$dados->getLink()."',";
		$sql .= "'".$dados->getDescricao()."',";
		$sql .= "'".$dados->getRegras()."',";
		$sql .= "'".$dados->getCurtidas()."',";
		$sql .= "'".$dados->getCliques()."',";
		$sql .= "'".$dados->getData()."',";
		$sql .= "'".$dados->getExpira()."',";
		$sql .= "'".$dados->getAlterado()."',";
		$sql .= "'".$dados->getTipo()."',";
		$sql .= "'".$dados->getAtivo()."');";
				
		$retorno = $conexao->incluir($sql);
		
		if($retorno){
			return $this->consultarCupom($dados->getCupomId());
		}else{
			return false;
		}
	}
	
	public function alterarCupom(CupomVO $dados) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_cupons SET ";
		$sql .=  "cup_categoria = '".$dados->getCategoriaId()."',";
		$sql .=  "cup_loja = '".$dados->getLojaId()."',";
		$sql .=  "cup_titulo = '".$dados->getTitulo()."',";
		$sql .=  "cup_codigo = '".$dados->getCodigo()."',";
		$sql .=  "cup_link = '".$dados->getLink()."',";
		$sql .=  "cup_descricao = '".$dados->getDescricao()."',";
		$sql .=  "cup_regras = '".$dados->getRegras()."',";
		$sql .=  "cup_expira = '".$dados->getExpira()."',";
		$sql .=  "cup_alterado = '".$dados->getAlterado()."',";
		$sql .=  "cup_tipo = '".$dados->getTipo()."',";
		$sql .=  "cup_ativo = '".$dados->getAtivo()."'";
		
		$sql .= " WHERE cup_id = ".$dados->getCupomId();

		$retorno = $conexao->alterar($sql);
		
		if($retorno){			
			return true;
		}else{
			return false;
		}
		
	}
	
	public function excluirCupom($id) {
	
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = 'DELETE FROM dv_cupons WHERE cup_id = '.$id;
		
		$retorno = $conexao->excluir($sql);

		if($retorno){

			$sqlRegras = 'DELETE FROM dv_cupom_regra WHERE crg_cupom_id = '.$id;

			$retornoRegras = $conexao->excluir($sqlRegras);

		}
		
		$conexao->fechaConexao();
		
		if($retorno){
			return true;
		}else{
			return false;
		}
	}
	
	public function consultarCupom($id){
		
		$conexao = MySQL::getMySQL();
		
		$cupom = new CupomVO();
		
		$sql = "SELECT cup.*, cat.cat_titulo as cattitulo, loj.loj_nome as lojnome, loj.loj_logo as lojlogo FROM dv_cupons as cup INNER JOIN dv_categorias as cat ON cup.cup_categoria = cat.cat_id INNER JOIN dv_lojas as loj ON cup.cup_loja = loj.loj_id WHERE cup.cup_id = ".$id;
		
		$consulta = $conexao->consultar($sql);
		
		if($consulta){
		
			$cupom->setCupomId($consulta[0]['cup_id']);
			$cupom->setCategoriaId($consulta[0]['cup_categoria']);
			$cupom->setCategoria($consulta[0]['cattitulo']);
			$cupom->setLojaId($consulta[0]['cup_loja']);
			$cupom->setLoja($consulta[0]['lojnome']);
			$cupom->setLojaLogo($consulta[0]['lojlogo']);
			$cupom->setTitulo($consulta[0]['cup_titulo']);
			$cupom->setCodigo($consulta[0]['cup_codigo']);	
			$cupom->setLink($consulta[0]['cup_link']);	
			$cupom->setDescricao($consulta[0]['cup_descricao']);
			$cupom->setRegras($consulta[0]['cup_regras']);
			$cupom->setCurtidas($consulta[0]['cup_curtidas']);	
			$cupom->setCliques($consulta[0]['cup_cliques']);	
			$cupom->setData($consulta[0]['cup_data']);	
			$cupom->setExpira($consulta[0]['cup_expira']);				
			$cupom->setAlterado($consulta[0]['cup_alterado']);	
			$cupom->setTipo($consulta[0]['cup_tipo']);
			$cupom->setAtivo($consulta[0]['cup_ativo']);
			
			return $cupom;
			
		}else{
			return false;
		}
	}
	
	public function carregarCupons($where, $order, $limit){
		
		$conexao = MySQL::getMySQL();
		
		$sql = '';
		
		$sql = "SELECT cup_id as aux FROM dv_cupons as cup LEFT JOIN dv_categorias as cat ON cup.cup_categoria = cat.cat_id LEFT JOIN dv_lojas as loj ON cup.cup_loja = loj.loj_id WHERE 1=1".$where."";

		if($order != ''){
			$sql .= ' ORDER BY '.$order;
		}else{
			$sql .= ' ORDER BY cup_id DESC';
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
        			$oCupons[$i] = $this->consultarCupom($array['aux']);
        			$i++;	
				}
        	}
			$conexao->fechaConexao();
			return $oCupons;
		
		}else{
			return false;
		}
	}
	
	public function existeCupom($id){
		
		$conexao = MySQL::getMySQL();
		
		$sql = "SELECT cup_id FROM dv_cupons WHERE cup_id = ".$id;

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
	
	public function inserirArray($cupom, $array, $tabela){
	
		$conexao = MySQL::getMySQL();

		//DELETA TODOS OS ITENS PARA SOBREPOR LOGO EM SEGUIDA
		$sql = 'DELETE FROM '.$tabela.' WHERE crg_cupom_id = '.$cupom;
		
		$retorno = $conexao->excluir($sql);
		
		if(!$retorno) return false;
		
		foreach ($array as $arr) {
			
			do{
			$i = 0;$id = '';		
			while($i<8){
				//GERA UM ID ALEATÓRIO DE 8 DÍGITOS
				if($i<1){ $id .= rand(1,9);	} else { $id .= rand(0,9); }	
				$i++;	
			}
			//ENQUANTO EXISTIR, GERAR NOVO
			}while($this->existeCupomRegra($id));
			
			$sql = "";
			$sql = "INSERT INTO ".$tabela."(crg_id,crg_cupom_id,crg_regra_id,crg_data) VALUES (";
			$sql .= "'".$id."',";
			$sql .= "'".$cupom."',";
			$sql .= "'".$arr."',";
			$sql .= "'".date('Y-m-d')."');";
			
			$retorno = $conexao->incluir($sql);
			
			if(!$retorno) return false;
		}
	}

	public function atualizaCliques($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_cupons SET cup_cliques = cup_cliques+1 WHERE cup_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function ativarCupom($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_cupons SET cup_ativo = 's' WHERE cup_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}

	public function desativarCupom($id) {
		
		$conexao = MySQL::getMySQL();
		
		$sql = "";
		
		$sql = "UPDATE dv_cupons SET cup_ativo = 'n' WHERE cup_id = ".$id;

		$retorno = $conexao->alterar($sql);
		
		if($retorno){
			return true;
		}else{
			return false;
		}
		
	}
}

?>
