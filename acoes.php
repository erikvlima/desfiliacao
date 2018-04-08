<?php
include "CidadeEstado.php";
include  "Sindicato.php";

$conexao = new CidadeEstado();
$sindicatoBD = new Sindicato();

$acao = isset($_GET['acao']) ? $_GET['acao'] : $_POST['acao'];

switch ($acao) {
    case 'busca-cidades-do-estado':
        $cidades = $conexao->getCidadeDoEstado($_POST['uf']);
        echo ( json_encode($cidades));
        break;

    case 'busca-email-sindicato':
        $sind = $sindicatoBD->getSindicato($_POST['sind']);
        if($sind)
            echo $sind[0]->sind_email;
        else
            echo '';
        break;
}