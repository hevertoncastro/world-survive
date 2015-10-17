<?php
class CooperativaVO{

	private $CooperativaID;
	private $Nome;
	private $Email;
	private $Senha;
	private $Razao;
	private $Cnpj;
	private $Cep;
	private $Endereco;
	private $Numero;
	private $Complemento;
	private $Bairro;
	private $Cidade;
	private $Estado;
	private $Latitude;
	private $Longitude;
	private $Telefone;
	private $Inclusao;
	private $Ativo;

	function setCooperativaID($CooperativaID) { $this->CooperativaID = $CooperativaID; }
	function getCooperativaID() { return $this->CooperativaID; }
	function setNome($Nome) { $this->Nome = $Nome; }
	function getNome() { return $this->Nome; }
	function setEmail($Email) { $this->Email = $Email; }
	function getEmail() { return $this->Email; }
	function setSenha($Senha) { $this->Senha = $Senha; }
	function getSenha() { return $this->Senha; }
	function setRazao($Razao) { $this->Razao = $Razao; }
	function getRazao() { return $this->Razao; }
	function setCnpj($Cnpj) { $this->Cnpj = $Cnpj; }
	function getCnpj() { return $this->Cnpj; }
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
	function setLatitude($Latitude) { $this->Latitude = $Latitude; }
	function getLatitude() { return $this->Latitude; }
	function setLongitude($Longitude) { $this->Longitude = $Longitude; }
	function getLongitude() { return $this->Longitude; }
	function setTelefone($Telefone) { $this->Telefone = $Telefone; }
	function getTelefone() { return $this->Telefone; }
	function setInclusao($Inclusao) { $this->Inclusao = $Inclusao; }
	function getInclusao() { return $this->Inclusao; }
	function setAtivo($Ativo) { $this->Ativo = $Ativo; }
	function getAtivo() { return $this->Ativo; }

}

?>
