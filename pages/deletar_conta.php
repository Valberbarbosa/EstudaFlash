
<?php
session_start();
require_once('./conexao.php');
class DeleteConta extends Conexao
{

    public function deletar()
    {
        $banco = $this->conectar();

        $query = "DELETE FROM lista WHERE id_criador = :id_criador";

        $result = $banco->prepare($query);
        $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            $query = "DELETE FROM assunto WHERE id_criador = :id_criador";

            $result = $banco->prepare($query);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                $query = "DELETE FROM usuario WHERE id = :id_criador";

                $result = $banco->prepare($query);
                $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
                if ($result->execute()) {
                    return true;
                }
            }
        }

        return false;
    }
}
$deletar = new DeleteConta();

if ($deletar->deletar()) {
    header("location: /index.php");
} else {
    header("location: /index.php");
}
