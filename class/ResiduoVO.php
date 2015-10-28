<?php
class ResiduoVO{

	private $ResiduoID;
	private $Nome;
	private $Ativo;

	function setResiduoID($ResiduoID) { $this->ResiduoID = $ResiduoID; }
	function getResiduoID() { return $this->ResiduoID; }
	function setNome($Nome) { $this->Nome = $Nome; }
	function getNome() { return $this->Nome; }
	function setAtivo($Ativo) { $this->Ativo = $Ativo; }
	function getAtivo() { return $this->Ativo; }
}
?>
