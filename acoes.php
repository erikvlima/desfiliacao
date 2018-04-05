<?php

include "Conexao.php";
include "CidadeEstado.php";

$conexao = new CidadeEstado();

$acao = isset($_GET['acao']) ? $_GET['acao'] : $_POST['acao'];

switch ($acao) {
    case 'busca-cidades-do-estado':
        $cidades = $conexao->getCidadeDoEstado($_POST['uf']);
        echo ( json_encode($cidades));
        break;
}