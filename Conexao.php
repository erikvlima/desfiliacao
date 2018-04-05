<?php

class Conexao
{
    var $host = "localhost";
    var $usuario = "root";
    var $senha = "";
    var $banco = "desfiliacao";
    private $mysqli;

    public function Abrir()
    {
        $this->mysqli = new mysqli($this->host, $this->usuario, $this->senha, $this->banco);
    }

    public function Fechar()
    {
        $this->mysqli->close();
    }

    public function Executar($sql)
    {
        $con = new Conexao();
        $con->Abrir();
        $re = $con->mysqli->query($sql);
        $con->Fechar();
        return $re;
    }

    public function getEstados(){

        $estados = $this->Executar('SELECT * FROM estados');
        return $estados;
    }

    public function getCidadeDoEstado($uf){
        $cidades = $this->Executar('SELECT * FROM cidades WHERE estados_cod_estados = '.$uf);
//        $array = array();
//        while ($obj = $cidades->fetchAll(PDO::FETCH_OBJ )) {
//            $array[] = $obj;
//        }
        $obj = $cidades->fetchAll(PDO::FETCH_OBJ );
        return $obj;
    }
}

?>