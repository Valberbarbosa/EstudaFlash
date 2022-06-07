
<?php
session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class CriarAssunto extends Conexao
{
    private $id_lista;
    private $titulo;
    private $descricao;
    public function __construct($id_lista, $titulo, $descricao)
    {
        $this->id_lista = $id_lista;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
    }



    public function criar()
    {
        $banco = $this->conectar();

        if (!empty($this->titulo) and !empty($this->descricao)) {
            $query = "INSERT INTO assunto (id_lista, id_criador, titulo, descricao) VALUES (:id_lista, :id_criador, :titulo, :descricao)";

            $result = $banco->prepare($query);
            $result->bindParam(':id_lista', $this->id_lista);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            $result->bindParam(':titulo', $this->titulo);
            $result->bindParam(':descricao', $this->descricao);
            if ($result->execute()) {

            }
        }
        return false;
    }
}
$valida = new Validar();
$id_lista = $valida->validarInformacoes(filter_input(INPUT_POST, 'id_lista', FILTER_VALIDATE_INT));
$titulo = $valida->validarInformacoes(filter_input(INPUT_POST, 'titulo', FILTER_UNSAFE_RAW));
$descricao = filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW);

$criarAssunto = new CriarAssunto($id_lista, $titulo, $descricao);

if ($criarAssunto->criar()) {
    header("Location: ../cartoes.php?id={$id_lista}");
} else {
    header("Location: ../cartoes.php?id={$id_lista}");
}
