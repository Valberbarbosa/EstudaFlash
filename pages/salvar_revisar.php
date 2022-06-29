<?php

session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');

class SalvarRevisao extends Conexao
{
    private $id;
    private $id_assunto;
    private $click;

    public function __construct($id, $id_assunto, $click)
    {
        $this->id = $id;
        $this->id_assunto = $id_assunto;
        $this->click = $click;
    }
    public function get($nome)
    {
        return $this->$nome;
    }
    public function salvar()
    {

        if (!$this->listar()) {

            $timeZone = new DateTimeZone('America/Sao_Paulo');
            $objDateTo = new DateTime();
            $objDateTo->setTimezone($timeZone);
            $dataHoje = $objDateTo->format('Y/m/d');

            $banco = $this->conectar();

            $query = "INSERT INTO revisar (id_assunto, id_criador, data, acao) VALUES (:id_assunto, :id_criador, :data, :acao)";

            $result = $banco->prepare($query);
            $result->bindValue(':id_assunto', $this->get('id_assunto'));
            $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
            $result->bindValue(':data', $dataHoje);
            $result->bindValue(':acao', $this->get('click'));

            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
    public function listar()
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM revisar WHERE id_assunto = :id_assunto and id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindValue(':id_assunto', $this->get('id_assunto'));
        $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            if (count($result->fetchAll(PDO::FETCH_ASSOC)) > 0) {
                return true;
            }
        }

        return false;
    }
}


$valida = new Validar();


$id = $valida->validarInformacoes(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));
$idAssunto = $valida->validarInformacoes(filter_input(INPUT_POST, 'id_assunto', FILTER_VALIDATE_INT));
$click = $valida->validarInformacoes(filter_input(INPUT_POST, 'click', FILTER_UNSAFE_RAW));


$card = new SalvarRevisao($id, $idAssunto, $click);



if ($card->salvar()) {
    exit(json_encode(array('status' => 'sucesso')));
} else {
    exit(json_encode(array('status' => 'error')));
}
