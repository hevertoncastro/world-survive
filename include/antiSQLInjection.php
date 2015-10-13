<?php
function noInjection($campo, $adicionaBarras = false) {
	if(is_array($campo)){
		foreach ($campo as &$value) {
		    $value = noInjection($value);
		}
		return $campo;
	} else {
		// remove palavras que contenham sintaxe sql
		$campo = preg_replace("/(from|alter table|select|insert|delete|update|were|drop table|show tables|#|\*|--|\\\\)/i","",$campo);
		$campo = trim($campo);//limpa espaços vazio
		$campo = strip_tags($campo);//tira tags html e php
		if($adicionaBarras || !get_magic_quotes_gpc())
		$campo = addslashes($campo);
		return $campo;
	}
}
?>