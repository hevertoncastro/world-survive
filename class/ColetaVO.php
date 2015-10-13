<?php
class ColetaVO{

	private $ColetaID;
	private $UsuarioID;
	private $CooperativaID;
	private $FuncionarioID;
	private $Data;
	private $Periodo;
	private $Qtde;
	private $Inclusao;
	private $Situacao;

	function setColetaID($ColetaID) { $this->ColetaID = $ColetaID; }
	function getColetaID() { return $this->ColetaID; }
	function setUsuarioID($UsuarioID) { $this->UsuarioID = $UsuarioID; }
	function getUsuarioID() { return $this->UsuarioID; }
	function setCooperativaID($CooperativaID) { $this->CooperativaID = $CooperativaID; }
	function getCooperativaID() { return $this->CooperativaID; }
	function setFuncionarioID($FuncionarioID) { $this->FuncionarioID = $FuncionarioID; }
	function getFuncionarioID() { return $this->FuncionarioID; }
	function setData($Data) { $this->Data = $Data; }
	function getData() { return $this->Data; }
	function setPeriodo($Periodo) { $this->Periodo = $Periodo; }
	function getPeriodo() { return $this->Periodo; }
	function setQtde($Qtde) { $this->Qtde = $Qtde; }
	function getQtde() { return $this->Qtde; }
	function setInclusao($Inclusao) { $this->Inclusao = $Inclusao; }
	function getInclusao() { return $this->Inclusao; }
	function setSituacao($Situacao) { $this->Situacao = $Situacao; }
	function getSituacao() { return $this->Situacao; }


}
?>
