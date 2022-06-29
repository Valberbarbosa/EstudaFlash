
<?php
session_start();
require_once('./conexao.php');

class DeleteDisciplina extends Conexao
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

        $query = "DELETE FROM lista WHERE id = :id AND id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindValue(':id', $this->get('id'));
        $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            $query = "DELETE FROM assunto WHERE id_lista = :id AND id_criador = :id_criador";
            $result = $banco->prepare($query);
            $result->bindValue(':id', $this->get('id'));
            $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        }

        return false;
    }
}

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

$deletar = new DeleteDisciplina($id);

if ($deletar->deletar()) {
    header("location: /dashboard.php?&msg=true");
} else {
    header("location: /dashboard.php?&msg=false");
}
