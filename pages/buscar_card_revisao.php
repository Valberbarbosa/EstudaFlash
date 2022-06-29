<?php


class ExibirCardRevisar extends Conexao
{
    public function listar($pesquisa)
    {
        $banco = $this->conectar();

        $query = "SELECT 
        revisar.id, 
        revisar.id_assunto, 
        revisar.data, 
        revisar.acao, 
        assunto.titulo, 
        assunto.descricao
        FROM revisar
        INNER JOIN assunto ON revisar.id_assunto=assunto.id 
        WHERE revisar.id_criador = :id_criador ";


        if (!empty($pesquisa)) {
            $query .= "AND assunto.titulo LIKE '%$pesquisa%' OR assunto.descricao LIKE '%$pesquisa%' ORDER BY revisar.id DESC";
        } else {
            $query .= "ORDER BY revisar.id DESC";
        }

        $result = $banco->prepare($query);
        $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }

        return [];
    }
}
