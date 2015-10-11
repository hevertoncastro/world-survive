<?php
class CategoriaVO{
	
	private $CategoriaId;
	private $Titulo;
	private $Data;
	private $Ativo;

	public function getCategoriaId(){
		return $this->CategoriaId;
	}

	public function setCategoriaId($CategoriaId){
		$this->CategoriaId = $CategoriaId;
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
