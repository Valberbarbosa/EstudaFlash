
<?php
class ExibirLista extends Conexao
{

    public function listar($pesquisa = null)
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM lista WHERE id_criador = :id_criador ";

        if (!empty($pesquisa)) {
            $query .= "AND titulo LIKE '%$pesquisa%' OR descricao LIKE '%$pesquisa%' ORDER BY id DESC";
        } else {
            $query .= "ORDER BY id DESC";
        }

        $result = $banco->prepare($query);
        $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
    public function assunto($id)
    {
        $banco = $this->conectar();

        $query = "SELECT count(*) as total FROM assunto WHERE id_lista = :id ORDER BY id DESC";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $id);
        if ($result->execute()) {
            $total = $result->fetchAll(PDO::FETCH_ASSOC);
            return $total[0];
        }

        return [];
    }
}
