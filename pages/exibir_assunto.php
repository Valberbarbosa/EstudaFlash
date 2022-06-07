
<?php
class ExibirAssunto extends Conexao
{

    public function listar($id_lista)
    {
        $banco = $this->conectar();

        if (!empty($id_lista)) {
            $query = "SELECT * FROM assunto WHERE id_lista = :id_lista AND id_criador = :id_criador ORDER BY id DESC";

            $result = $banco->prepare($query);
            $result->bindParam(':id_lista', $id_lista);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return [];
    }
    public function listarInformacoesDaSala($id_lista)
    {
        $banco = $this->conectar();

        if (!empty($id_lista)) {
            $query = "SELECT * FROM lista WHERE id = :id_lista AND id_criador = :id_criador";

            $result = $banco->prepare($query);
            $result->bindParam(':id_lista', $id_lista);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return $result->fetchAll(PDO::FETCH_ASSOC);
            }
        }
        return [];
    }
}
