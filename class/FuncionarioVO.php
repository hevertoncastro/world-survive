<?php
class FuncionarioVO{

	private $FuncionarioID;
	private $CooperativaID;
	private $Nome;
	private $Cpf;
	private $Cep;
	private $Endereco;
	private $Numero;
	private $Complemento;
	private $Bairro;
	private $Cidade;
	private $Estado;
	private $Celular;
	private $Inclusao;
	private $Ativo;

	function setFuncionarioID($FuncionarioID) { $this->FuncionarioID = $FuncionarioID; }
	function getFuncionarioID() { return $this->FuncionarioID; }
	function setCooperativaID($CooperativaID) { $this->CooperativaID = $CooperativaID; }
	function getCooperativaID() { return $this->CooperativaID; }
	function setNome($Nome) { $this->Nome = $Nome; }
	function getNome() { return $this->Nome; }
	function setCpf($Cpf) { $this->Cpf = $Cpf; }
	function getCpf() { return $this->Cpf; }
	function setCep($Cep) { $this->Cep = $Cep; }
	function getCep() { return $this->Cep; }
	function setEndereco($Endereco) { $this->Endereco = $Endereco; }
	function getEndereco() { return $this->Endereco; }
	function setNumero($Numero) { $this->Numero = $Numero; }
	function getNumero() { return $this->Numero; }
	function setComplemento($Complemento) { $this->Complemento = $Complemento; }
	function getComplemento() { return $this->Complemento; }
	function setBairro($Bairro) { $this->Bairro = $Bairro; }
	function getBairro() { return $this->Bairro; }
	function setCidade($Cidade) { $this->Cidade = $Cidade; }
	function getCidade() { return $this->Cidade; }
	function setEstado($Estado) { $this->Estado = $Estado; }
	function getEstado() { return $this->Estado; }
	function setCelular($Celular) { $this->Celular = $Celular; }
	function getCelular() { return $this->Celular; }
	function setInclusao($Inclusao) { $this->Inclusao = $Inclusao; }
	function getInclusao() { return $this->Inclusao; }
	function setAtivo($Ativo) { $this->Ativo = $Ativo; }
	function getAtivo() { return $this->Ativo; }


}
?>
