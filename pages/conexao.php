<?php

class Conexao
{

    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'EstudaFlash';

    public function conectar()
    {
        try {
            $conexao = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", $this->user, $this->password);
            return $conexao;
            //echo "Conexão com sucesso!!";
        } catch (PDOException $err) {
            echo "ERRO: Não foi possivel conectar.";
        }
    }
}
