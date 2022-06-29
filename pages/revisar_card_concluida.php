
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

        $query = "DELETE FROM revisar WHERE id_assunto = :id AND id_criador = :id_criador";

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

$deletar = new DeleteCard($id);

if ($deletar->deletar()) {
    header("location: /revisar.php?msg=true");
} else {
    header("location: /revisar.php?msg=true");
}
