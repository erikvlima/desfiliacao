<?php

require_once 'DB.class.php';
$db = new DB();
$db->Connect();

class CidadeEstado
{
    function getCidadeDoEstado($uf)
    {
        global $db;
        $sql = 'SELECT * FROM cidades WHERE estados_cod_estados = ?';
        return $db->GetObjectList($sql, array($uf));
    }
}