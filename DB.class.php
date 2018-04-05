<?php

class DB
{

    public $id, $msg, $sql;
    public $db;

    function Connect()
    {
        global $pdo;

        $servidor = 'localhost';
        $banco_de_dados = 'desfiliacao';
        $usuario = 'root';
        $senha = '';

        try {
            $this->db = $banco_de_dados;
            $pdo = new PDO ('mysql:host=' . $servidor . ';dbname=' . $banco_de_dados, $usuario, $senha, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8'
            ));
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            error_log($e->getMessage());

            die('Erro ao estabelecer conexão com o banco de dados. ' . $e->getMessage());
        }
    }

    function ExecSQL($sql, $valores = array())
    {
        global $pdo;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
//			echo $sql;
//			die();
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage() . ' -- ' . print_r($valores, 1) . ' --- ' . print_r($_SESSION, 1) . ' --- ' . print_r($_SERVER, 1)));

            return false;
        }

        return $query;
    }

    function getLastInsertId()
    {
        global $pdo;
        return $pdo->lastInsertId();
    }

    function GetObject($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetch(PDO::FETCH_OBJ);

        } catch (Exception $e) {
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetObjectList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetchAll(PDO::FETCH_OBJ);

        } catch (Exception $e) {
            var_dump($e);
//            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");
//
//            $error_mysql = $pdo->prepare($this->sql_error_bd);
//            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));
//
//            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }

    }

    function GetAssocList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

        } catch (Exception $e) {
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetJsonList($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($resultado, JSON_UNESCAPED_UNICODE);

        } catch (Exception $e) {
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }

    function GetColumn($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->fetchColumn();

        } catch (Exception $e) {
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }

    }

    function GetCountRows($sql, $valores = array())
    {
        global $pdo, $config;

        try {
            $query = $pdo->prepare($sql);

            if (count($valores) == 0) {
                $query->execute();
            } else {
                $query->execute($valores);
            }

            return $query->rowCount();

        } catch (Exception $e) {
            error_log(date("d/m/Y H:i:s") . " - [SQL - ERRO] - " . $this->db . ' -- ' . $sql . " - " . $e->getMessage() . "\r\n", 3, DOCUMENT_ROOT . "/_erro_sql.log");

            $error_mysql = $pdo->prepare($this->sql_error_bd);
            $error_mysql->execute(array(date("Y-m-d H:i:s"), $_SERVER['SCRIPT_NAME'], $sql, $e->getMessage()));

            echo GeleiaUtil::ExibirMensagem('erro', $e->getMessage());
        }
    }
}