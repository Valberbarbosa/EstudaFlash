
<?php
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class ValidarLogin extends Conexao
{
    private $email;
    private $senha;
    public function __construct($email, $senha)
    {
        $this->email = $email;
        $this->senha = $senha;
    }



    public function login()
    {
        $banco = $this->conectar();

        if (!empty($this->email) and !empty($this->senha)) {
            $query = "SELECT * FROM usuario WHERE email = :email";

            $result = $banco->prepare($query);
            $result->bindParam(':email', $this->email);
            $hash = uniqid();
            if ($result->execute()) {
                $dados = $result->fetchAll(PDO::FETCH_ASSOC);
                if ($dados[0]['email'] == $this->email and password_verify($this->senha, $dados[0]['senha'])) {
                    $query = "UPDATE usuario SET hash = :hash WHERE id = :id";
                    $result = $banco->prepare($query);
                    $result->bindParam(':hash', $hash);
                    $result->bindParam(':id', $dados[0]['id']);
                    if ($result->execute()) {
                        $idSession = password_hash($dados[0]['id'], PASSWORD_DEFAULT);
                        $hashSession = password_hash($hash, PASSWORD_DEFAULT);
                        setcookie('session', $idSession, time() + 30 * 60 * 60 * 60, '/');
                        setcookie('hash', $hashSession, time() + 30 * 60 * 60 * 60, '/');
                        return true;
                    }
                }
            }
        }
        return false;
    }
}
$valida = new Validar();
$email = $valida->validarInformacoes(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW));
$senha = $valida->validarInformacoes(filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW));

$login = new ValidarLogin($email, $senha);

if ($login->login()) {
    header("Location: ../dashboard.php");
} else {
    header("Location: ../entrar.php");
}
