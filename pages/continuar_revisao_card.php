
<?php
session_start();
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class ContinuarRevisando extends Conexao
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }



    public function update()
    {
        $banco = $this->conectar();

        $timeZone = new DateTimeZone('America/Sao_Paulo');
        $objDateTo = new DateTime();
        $objDateTo->setTimezone($timeZone);
        $dataHoje = $objDateTo->format('Y/m/d');


        if (!empty($this->id)) {
            $query = "UPDATE revisar SET data = :data WHERE id_assunto = :id AND id_criador = :id_criador";

            $result = $banco->prepare($query);
            $result->bindValue(':data', $dataHoje);
            $result->bindValue(':id', $this->id);
            $result->bindValue(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
}
$valida = new Validar();
$id = $valida->validarInformacoes(filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT));

$continuarRevisao = new ContinuarRevisando($id);

if ($continuarRevisao->update()) {
    header("Location: ../revisar.php");
} else {
    header("Location: ../revisar.php");
}
