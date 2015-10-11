<?php
class MySQL {
	private $servidor;
	private $usuario;
	private $senha;
	private $banco;
	private $conexao;
	private static $instancia;
	
	function __construct(){
		$this->setServidor(HOST_BANCO);
		$this->setUsuario(LOGIN_BANCO);
		$this->setSenha(SENHA_BANCO);
		$this->setBanco(NOME_BANCO);

		try{
			$this->abreConexao();
		} catch (Exception $e) {
			echo $e->getMessage();
		} 
	
	}
	
	public static function getMySQL() {
		
		if(!MySQL::$instancia){
			MySQL::$instancia = new MySQL();
		}
		
		return MySQL::$instancia;
	}
	
	public function abreConexao() {

		$dsn = "mysql:host=".$this->getServidor().";dbname=".$this->getBanco().";charset=utf8";
		$username = $this->getUsuario();
		$password = $this->getSenha();
		$options = array(
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false,
		    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		); 

		$this->setConexao(new PDO($dsn, $username, $password, $options));
		
		return true;
	}
	
	public function fechaConsulta() {
		//return mysql_free_result($this->getComandoSql());
	}
	
	public function fechaConexao() {
		$this->setConexao(null);
	}
	
	public function incluir($sql) {		
		try{
			//abre conexão
			$this->abreConexao();
		    //executa as instruções SQL
		    $this->getConexao()->exec($sql);
		    //fecha conexão
		    $this->fechaConexao();
		    return true;
		}catch (PDOException $e){
	        //se houver exceção, exibe
	        echo utf8_encode("Não foi possível executar a query de inserção. | ").$e->getMessage();
		}
	}

	public function alterar($sql) {		
		try{
			//abre conexão
			$this->abreConexao();
		    //executa as instruções SQL
		    $this->getConexao()->exec($sql);
		    //fecha conexão
		    $this->fechaConexao();
		    return true;
		}catch (PDOException $e){
	        //se houver exceção, exibe
	        echo utf8_encode("Não foi possível executar a query de alteração. | ").$e->getMessage();
		}
	}
	
	public function excluir($sql) {
		try{
			//abre conexão
			$this->abreConexao();
		    //executa as instruções SQL
		    $this->getConexao()->exec($sql);
		    //fecha conexão
		    $this->fechaConexao();
		    return true;
		}catch (PDOException $e){
	        //se houver exceção, exibe
	        echo utf8_encode("Não foi possível executar a query de exclusão. | ").$e->getMessage();
		}
	}
	
	public function consultar($sql) {

		$registros = array();
		$linha = null;
		$conta = 0;
		$this->setComandoSQL($sql);

		try{
			//abre conexão
			$this->abreConexao();

		    //executa uma instrução de consulta
		    $result = $this->getConexao()->query($this->getComandoSQL());

		    if($result){
		        //percorre os resultados via o laço foreach
		        foreach($result as $item){
		        	//exibe o resultado
	    			$registros[$conta] = $item;
	    			$conta++;
	           }
	           //fecha consulta
		        $this->fechaConsulta();

		        //fecha conexão
		        $this->fechaConexao();

	    		return $registros;
		    }
		}catch (PDOException $e){
		        echo $e->getMessage();
		}
	}
	
	public function setServidor($servidor) {
		$this->servidor = $servidor;
	}
	
	public function getServidor() {
		return $this->servidor;
	}
	
	public function setUsuario($usuario) {
		$this->usuario = $usuario;
	}
	
	public function getUsuario() {
		return $this->usuario;
	}
	
	public function setSenha($senha) {
		$this->senha = $senha;
	}
	
	public function getSenha() {
		return $this->senha;
	}
	
	public function setBanco($banco) {
		$this->banco = $banco;
	}
	
	public function getBanco() {
		return $this->banco;
	}
	
	public function setConexao($conexao) {
		$this->conexao = $conexao;
	}
	public function getConexao() {
		return $this->conexao;
	}
	
	public function setComandoSQL($comandoSQL) {
		$this->comandoSQL = $comandoSQL;
	}
	
	public function getComandoSQL() {
		return $this->comandoSQL;
	}
}
?>