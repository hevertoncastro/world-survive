<?php
class CupomVO{
	
	private $CupomId;
	private $CategoriaId;
	private $Categoria;
	private $LojaId;
	private $Loja;
	private $LojaLogo;
	private $Titulo;
	private $Codigo;
	private $Link;
	private $Descricao;
	private $Regras;
	private $Curtidas;
	private $Cliques;
	private $Data;
	private $Expira;
	private $Alterado;
	private $Tipo;
	private $Ativo;

	public function getCupomId(){
		return $this->CupomId;
	}

	public function setCupomId($CupomId){
		$this->CupomId = $CupomId;
	}

	public function getCategoriaId(){
		return $this->CategoriaId;
	}

	public function setCategoriaId($CategoriaId){
		$this->CategoriaId = $CategoriaId;
	}

	public function getCategoria(){
		return $this->Categoria;
	}

	public function setCategoria($Categoria){
		$this->Categoria = $Categoria;
	}

	public function getLojaId(){
		return $this->LojaId;
	}

	public function setLojaId($LojaId){
		$this->LojaId = $LojaId;
	}

	public function getLoja(){
		return $this->Loja;
	}

	public function setLoja($Loja){
		$this->Loja = $Loja;
	}

	public function getLojaLogo(){
		return $this->LojaLogo;
	}

	public function setLojaLogo($LojaLogo){
		$this->LojaLogo = $LojaLogo;
	}

	public function getTitulo(){
		return $this->Titulo;
	}

	public function setTitulo($Titulo){
		$this->Titulo = $Titulo;
	}

	public function getCodigo(){
		return $this->Codigo;
	}

	public function setCodigo($Codigo){
		$this->Codigo = $Codigo;
	}

	public function getLink(){
		return $this->Link;
	}

	public function setLink($Link){
		$this->Link = $Link;
	}

	public function getDescricao(){
		return $this->Descricao;
	}

	public function setDescricao($Descricao){
		$this->Descricao = $Descricao;
	}
	
	public function getRegras(){
		return $this->Regras;
	}

	public function setRegras($Regras){
		$this->Regras = $Regras;
	}

	public function getCurtidas(){
		return $this->Curtidas;
	}

	public function setCurtidas($Curtidas){
		$this->Curtidas = $Curtidas;
	}

	public function getCliques(){
		return $this->Cliques;
	}

	public function setCliques($Cliques){
		$this->Cliques = $Cliques;
	}

	public function getData(){
		return $this->Data;
	}

	public function setData($Data){
		$this->Data = $Data;
	}

	public function getExpira(){
		return $this->Expira;
	}

	public function setExpira($Expira){
		$this->Expira = $Expira;
	}

	public function getAlterado(){
		return $this->Alterado;
	}

	public function setAlterado($Alterado){
		$this->Alterado = $Alterado;
	}

	public function getTipo(){
		return $this->Tipo;
	}

	public function setTipo($Tipo){
		$this->Tipo = $Tipo;
	}

	public function getAtivo(){
		return $this->Ativo;
	}

	public function setAtivo($Ativo){
		$this->Ativo = $Ativo;
	}
}
?>
