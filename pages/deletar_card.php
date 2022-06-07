
<?php
session_start();
require_once('./conexao.php');

class DeleteCard extends Conexao
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }
    public function get($name)
    {
        return $this->$name;
    }
    public function deletar()
    {
        $banco = $this->conectar();

        $query = "DELETE FROM assunto WHERE id = :id AND id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $this->get('id'));
        $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            return true;
        }

        return false;
    }
}

$id = filter_input(INPUT_GET, 'id', FILTER_UNSAFE_RAW);
$id_lista = filter_input(INPUT_GET, 'id_lista', FILTER_UNSAFE_RAW);

$deletar = new DeleteCard($id);

if ($deletar->deletar()) {
    header("location: /cartoes.php?id=$id_lista&msg=true");
} else {
    header("location: /cartoes.php?id=$id_lista&msg=false");
}
