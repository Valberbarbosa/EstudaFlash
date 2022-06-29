
<?php

class Notificacao extends Conexao
{
    public function listar()
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
        WHERE revisar.id_criador = :id_criador ORDER BY revisar.id DESC";
        $result = $banco->prepare($query);
        $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            $listas = $result->fetchAll(PDO::FETCH_ASSOC);
            $conteudo = [];
            $total = 0;
            foreach ($listas as $lista) {
                $firstDate = new DateTime($lista['data']);
                $secondDate = new DateTime($this->getData());
                $intvl = $firstDate->diff($secondDate);

                if ($lista['acao'] == 'fácil' and $intvl->d == 0) {
                    $conteudo[] = '<p><a href="revisar.php">Você tem um flashcard classificado como fácil para revisar</a></p>';
                    $total++;
                } else if ($lista['acao'] == 'médio' and $intvl->d > 0) {
                    $conteudo[] = '<p><a href="revisar.php">Você tem um flashcard classificado como médio para revisar</a></p>';
                    $total++;
                } else if ($lista['acao'] == 'difícil' and $intvl->d > 1) {
                    $conteudo[] = '<p><a href="revisar.php">Você tem um flashcard classificado como difícil para revisar</a></p>';
                    $total++;
                }
            }
            if (empty($conteudo)) {
                return array("content" => ['<p>Nenhuma notificação até o momento</p>'], "total" => $total);
            } else {
                return array("content" => $conteudo, "total" => $total);
            }
        }
        return array("content" => ['<p>Nenhuma notificação até o momento</p>'], "total" => 0);
    }
    public function getData()
    {
        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $objDateTo = new DateTime();
        $objDateTo->setTimezone($timeZone);
        $data = $objDateTo->format('Y-m-d');
        return $data;
    }
}
