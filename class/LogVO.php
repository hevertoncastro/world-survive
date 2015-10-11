<?php

class LogVO{
	
	private $LogID;
	private $UsuarioID;
	private $Usuario;
	private $Acao;
	private $Pagina;
	private $IP;
	private $Acesso;	
	private $Data;
	
	public function setLogID($LogID) {
		$this->LogID = $LogID;
	}
	public function getLogID() {
		return $this->LogID;
	}
	public function setUsuarioID($UsuarioID){
		$this->UsuarioID = $UsuarioID;
	}
	public function getUsuarioID(){
		return $this->UsuarioID;
	}
	public function setUsuario($Usuario){
		$this->Usuario = $Usuario;
	}
	public function getUsuario(){
		return $this->Usuario;
	}
	public function setAcao($Acao) {
		$this->Acao = $Acao;
	}
	public function getAcao() {
		return $this->Acao;
	}
	public function setPagina($Pagina) {
		$this->Pagina = $Pagina;
	}
	public function getPagina() {
		return $this->Pagina;
	}
	public function setIP($IP) {
		$this->IP = $IP;
	}
	public function getIP() {
		return $this->IP;
	}
	public function setAcesso($Acesso){
		$this->Acesso = $Acesso;
	}
	public function getAcesso(){
		return $this->Acesso;
	}
	public function setData($Data){
		$this->Data = $Data;
	}
	public function getData(){
		return $this->Data;
	}
}

?>
