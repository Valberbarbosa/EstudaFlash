
<?php
session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class CriarLista extends Conexao
{
    private $titulo;
    private $descricao;
    public function __construct($titulo, $descricao)
    {
        $this->titulo = $titulo;
        $this->descricao = $descricao;
    }



    public function criar()
    {
        $banco = $this->conectar();

        if (!empty($this->titulo) and !empty($this->descricao)) {
            $query = "INSERT INTO lista (id_criador, titulo, descricao) VALUES (:id_criador, :titulo, :descricao)";

            $result = $banco->prepare($query);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            $result->bindParam(':titulo', $this->titulo);
            $result->bindParam(':descricao', $this->descricao);
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
}
$valida = new Validar();
$titulo = $valida->validarInformacoes(filter_input(INPUT_POST, 'titulo', FILTER_UNSAFE_RAW));
$descricao = $valida->validarInformacoes(filter_input(INPUT_POST, 'descricao', FILTER_UNSAFE_RAW));

$criarLista = new CriarLista($titulo, $descricao);

if ($criarLista->criar()) {
    header("Location: ../dashboard.php");
} else {
    header("Location: ../dashboard.php");
}
