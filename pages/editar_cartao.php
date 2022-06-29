
<?php
session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class EditarCartao extends Conexao
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
            $query = "UPDATE lista SET titulo = :titulo, descricao = :descricao WHERE id = :id AND id_criador = :id_criador";

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
$id_lista = $valida->validarInformacoes(filter_input(INPUT_POST, 'id_lista', FILTER_VALIDATE_INT));
$titulo = $valida->validarInformacoes(filter_input(INPUT_POST, 'titulo', FILTER_UNSAFE_RAW));
$descricao = $valida->validarInformacoes(filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW));

$editar = new EditarCartao($id_lista, $titulo, $descricao);
echo "<pre>";
    print_r($_POST);
echo "</pre>";

if ($editar->editar()) {
    header("Location: ../cartoes.php?id={$id_lista}");
} else {
    header("Location: ../cartoes.php?id={$id_lista}");
}
