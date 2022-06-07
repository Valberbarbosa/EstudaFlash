<?php

class ExibirCardPublico extends Conexao
{

    public function exibir()
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM lista WHERE publico = '1'";

        $result = $banco->prepare($query);
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


