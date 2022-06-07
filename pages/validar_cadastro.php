
<?php
require_once('./conexao.php');
require_once('./validarInformacoes.php');
class CadastrarUsuario extends Conexao
{
    private $nome;
    private $email;
    private $senha;
    private $nascimento;
    public function __construct($nome, $email, $senha, $nascimento)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = $senha;
        $this->nascimento = $nascimento;
    }



    public function cadastro()
    {
        $banco = $this->conectar();

        if (!empty($this->nome) and !empty($this->email) and !empty($this->senha)) {
            if (!$this->getUserExist()) {
                $query = "INSERT INTO usuario (nome, email, senha, data_nascimento) VALUES (:nome, :email, :senha, :data_nascimento)";

                $result = $banco->prepare($query);
                $result->bindParam(':nome', $this->nome);
                $result->bindParam(':email', $this->email);
                $result->bindParam(':senha', password_hash($this->senha, PASSWORD_DEFAULT));
                $result->bindParam(':data_nascimento', $this->nascimento);
                if ($result->execute()) {
                    if($this->login()){
                        return true;
                    }
                }
            }
        }
        return false;
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
    public function getUserExist()
    {
        $banco = $this->conectar();

        if (!empty($this->email) and !empty($this->senha)) {
            $query = "SELECT * FROM usuario WHERE email = :email";

            $result = $banco->prepare($query);
            $result->bindParam(':email', $this->email);
            if ($result->execute()) {
                $dados = $result->fetchAll(PDO::FETCH_ASSOC);
                if (count($dados) > 0) {
                    return true;
                }
            }
        }
        return false;
    }
}
$valida = new Validar();
$nome = $valida->validarInformacoes(filter_input(INPUT_POST, 'nome', FILTER_UNSAFE_RAW));
$email = $valida->validarInformacoes(filter_input(INPUT_POST, 'email', FILTER_UNSAFE_RAW));
$senha = $valida->validarInformacoes(filter_input(INPUT_POST, 'senha', FILTER_UNSAFE_RAW));
$nascimento = $valida->validarInformacoes(filter_input(INPUT_POST, 'nascimento', FILTER_UNSAFE_RAW));

$cadastro = new CadastrarUsuario($nome, $email, $senha, $nascimento);

if ($cadastro->cadastro()) {
    header("Location: ../dashboard.php");
} else {
    header("Location: ../cadastro.php");
}
