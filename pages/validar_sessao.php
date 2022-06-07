
<?php
class ValidarSessao extends Conexao
{
    private $id;
    private $hash;
    public function __construct($id, $hash)
    {
        $this->id = $id;
        $this->hash = $hash;
    }



    public function validar()
    {
        $banco = $this->conectar();

        if (!empty($this->id) and !empty($this->hash)) {
            $query = "SELECT * FROM usuario";
            $result = $banco->prepare($query);
            if ($result->execute()) {
                $dados = $result->fetchAll(PDO::FETCH_ASSOC);
                foreach ($dados as $valor) {
                    if (password_verify($valor['id'], $this->id) and password_verify($valor['hash'], $this->hash)) {
                        $_SESSION['USUARIO_ID'] = $valor['id'];
                        $_SESSION['USUARIO_NOME'] = $valor['nome'];
                        $_SESSION['USUARIO_EMAIL'] = $valor['email'];
                        $_SESSION['USUARIO_FOTO'] = $valor['foto'];
                        $_SESSION['USUARIO_NASCIMENTO'] = $valor['data_nascimento'];
                        
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
