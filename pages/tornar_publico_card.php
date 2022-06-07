<?php

session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');

class TornarPublico extends Conexao
{
    private $idCartao;
    private $acao;

    public function __construct($idCartao, $acao)
    {
        $this->idCartao = $idCartao;
        $this->acao = $acao;
    }
    public function __get($nome)
    {
        return $this->$nome;
    }



    public function criar()
    {
        $banco = $this->conectar();
        $value = true;
        if ($this->verficarSeExiste($this->__get('idCartao'))) {
            $query = "UPDATE lista SET publico = :publico WHERE id = :id";
            $result = $banco->prepare($query);
            $result->bindParam(':publico', $value);
            $result->bindParam(':id', $this->__get('idCartao'));
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
    public function remover()
    {
        $banco = $this->conectar();
        $value = false;
        $query = "UPDATE lista SET publico = :publico WHERE id = :id";

        $result = $banco->prepare($query);
        $result->bindParam(':publico', $value);
        $result->bindParam(':id', $this->__get('idCartao'));
        if ($result->execute()) {
            return true;
        }

        return false;
    }
    public function verficarSeExiste($id)
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM lista WHERE id = :id and id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $id);
        $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}


$valida = new Validar();
$id = $valida->validarInformacoes(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));
$acao = $valida->validarInformacoes(filter_input(INPUT_POST, 'acao', FILTER_UNSAFE_RAW));

$tornarPublico = new TornarPublico($id, $acao);

if ($acao == 'adicionar') {
    if ($tornarPublico->criar()) {
        exit(json_encode(array('status' => 'sucesso')));
    } else {
        exit(json_encode(array('status' => 'error')));
    }
} else if ($acao == 'remover') {
    if ($tornarPublico->remover()) {
        exit(json_encode(array('status' => 'sucesso')));
    } else {
        exit(json_encode(array('status' => 'error')));
    }
} else {
    exit(json_encode(array('status' => 'bugou')));
}
