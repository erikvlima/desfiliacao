<?php

require_once 'DB.class.php';
$db = new DB();
$db->Connect();

class Desfiliacao
{
    function Insere($desf)
    {
        global $db;
        $sql = 'INSERT INTO desfiliacao (desf_sindicato, desf_sindicato_email, desf_cnpj, desf_razao_social, desf_email, desf_celular, desf_core, desf_segmentos, desf_data, desf_data_envio, desf_uf, desf_cidade_ibge, desf_cidade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
        return $db->ExecSQL ($sql, array($desf->desf_sindicato, $desf->desf_sindicato_email, $desf->desf_cnpj, $desf->desf_razao_social, $desf->desf_email, $desf->desf_celular, $desf->desf_core, $desf->desf_segmentos, $desf->desf_data, null, $desf->desf_uf, $desf->desf_cidade_ibge, $desf->desf_cidade));
    }
}