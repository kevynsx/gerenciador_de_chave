<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once('../config.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $codigo_chave = ['codigo_chave'];
    $descricao = ['descricao'];
    $localizacao = ['localizacao'];
}

?>