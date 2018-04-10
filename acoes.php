<?php
include "CidadeEstado.php";
include  "Sindicato.php";
include  "Desfiliacao.php";

$conexao = new CidadeEstado();
$sindicatoBD = new Sindicato();
$desfiliacao = new Desfiliacao();

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
    case 'insert':
        $array = array(
            "desf_sindicato" => $_POST['sindicato'],
            "desf_sindicato_email" => $_POST['email_sindicato'],
            "desf_cnpj" => $_POST['cnpj'],
            "desf_razao_social" => $_POST['razao'],
            "desf_email" => $_POST['email'],
            "desf_celular" => $_POST['celular'],
            "desf_core" => $_POST['n_core'],
            "desf_segmentos" => $_POST['segmento'],
            "desf_data" => date("d/m/Y"),
            "desf_uf" => $_POST['uf'],
            "desf_cidade" => $_POST['cidades'],
            "desf_sindicato_email" => $_POST['email_sindicato'],
            "desf_cidade_ibge" => null
        );
        $res = $desfiliacao->Insere($array);
}