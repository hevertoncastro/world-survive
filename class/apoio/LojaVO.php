<?php
class LojaVO{
	
	private $LojaId;
	private $Nome;
	private $Sobre;
	private $Link;
	private $Tags;
	private $Cliques;
	private $Logo;
	private $Data;
	private $Ativo;

	public function getLojaId(){
		return $this->LojaId;
	}

	public function setLojaId($LojaId){
		$this->LojaId = $LojaId;
	}

	public function getNome(){
		return $this->Nome;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
	}

	public function getSobre(){
		return $this->Sobre;
	}

	public function setSobre($Sobre){
		$this->Sobre = $Sobre;
	}	
	
	public function getLink(){
		return $this->Link;
	}

	public function setLink($Link){
		$this->Link = $Link;
	}	
	
	public function getTags(){
		return $this->Tags;
	}

	public function setTags($Tags){
		$this->Tags = $Tags;
	}
	
	public function getCliques(){
		return $this->Cliques;
	}

	public function setCliques($Cliques){
		$this->Cliques = $Cliques;
	}

	public function getLogo(){
		return $this->Logo;
	}

	public function setLogo($Logo){
		$this->Logo = $Logo;
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
