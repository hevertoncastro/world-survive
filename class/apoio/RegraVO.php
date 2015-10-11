<?php
class RegraVO{
	
	private $RegraId;
	private $Titulo;
	private $Data;
	private $Ativo;

	public function getRegraId(){
		return $this->RegraId;
	}

	public function setRegraId($RegraId){
		$this->RegraId = $RegraId;
	}

	public function getTitulo(){
		return $this->Titulo;
	}

	public function setTitulo($Titulo){
		$this->Titulo = $Titulo;
	}
	
	public function getData(){
		return $this->Data;
	}

	public function setData($Data){
		$this->Data = $Data;
	}
	
	public function getAtivo(){
		return $this->Ativo;
	}

	public function setAtivo($Ativo){
		$this->Ativo = $Ativo;
	}
}
?>
