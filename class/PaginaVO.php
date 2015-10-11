<?php
class PaginaVO{

	private $PaginaId;
	private $Area;
	private $Titulo;
	private $Texto;
	private $Data;
	private $Ativo;

	public function getPaginaId(){
		return $this->PaginaId;
	}

	public function setPaginaId($PaginaId){
		$this->PaginaId = $PaginaId;
	}

	public function getArea(){
		return $this->Area;
	}

	public function setArea($Area){
		$this->Area = $Area;
	}

	public function getTitulo(){
		return $this->Titulo;
	}

	public function setTitulo($Titulo){
		$this->Titulo = $Titulo;
	}

	public function getTexto(){
		return $this->Texto;
	}

	public function setTexto($Texto){
		$this->Texto = $Texto;
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
