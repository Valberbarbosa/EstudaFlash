<?php

session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');

class ExibirCard extends Conexao
{
    private $id;

    public function __construct($idCartao)
    {
        $this->id = $idCartao;
    }
    public function __get($nome)
    {
        return $this->$nome;
    }

    public function listar()
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM assunto WHERE id = :id and id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $this->id);
        $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
}


$valida = new Validar();

$id = $valida->validarInformacoes(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));

$card = new ExibirCard($id);

if ($card->listar()) {
    exit(json_encode(array('status' => 'sucesso', 'content' => $card->listar())));
} else {
    exit(json_encode(array('status' => 'error', 'content' => $card->listar())));
}
