
<?php
session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class CriarAssunto extends Conexao
{
    private $id;
    private $titulo;
    private $descricao;
    public function __construct($id, $titulo, $descricao)
    {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
    }



    public function editar()
    {
        $banco = $this->conectar();

        if (!empty($this->titulo) and !empty($this->descricao)) {
            $query = "UPDATE assunto SET titulo = :titulo, descricao = :descricao WHERE id = :id AND id_criador = :id_criador";

            $result = $banco->prepare($query);
            $result->bindValue(':titulo', $this->titulo);
            $result->bindValue(':descricao', $this->descricao);
            $result->bindValue(':id', $this->id);
            $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
}
$valida = new Validar();
$id = $valida->validarInformacoes(filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT));
$id_lista = $valida->validarInformacoes(filter_input(INPUT_POST, 'id_lista', FILTER_VALIDATE_INT));
$titulo = $valida->validarInformacoes(filter_input(INPUT_POST, 'titulo', FILTER_UNSAFE_RAW));
$descricao = filter_input(INPUT_POST, 'descricao__editar', FILTER_UNSAFE_RAW);

$criarAssunto = new CriarAssunto($id, $titulo, $descricao);
echo "<pre>";
    print_r($_POST);
echo "</pre>";

if ($criarAssunto->editar()) {
    header("Location: ../cartoes.php?id={$id_lista}");
} else {
    header("Location: ../cartoes.php?id={$id_lista}");
}
