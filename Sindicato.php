<?php

require_once 'DB.class.php';
$db = new DB();
$db->Connect();

class Sindicato
{
    function getSindicatos()
    {
        global $db;
        $sql = 'SELECT * FROM sindicato';
        return $db->GetObjectList($sql, array());
    }

    function getSindicato($sind)
    {
        global $db;
        $sql = 'SELECT * FROM sindicato WHERE sind_nome = ?';
        return $db->GetObjectList($sql, array($sind));
    }
}