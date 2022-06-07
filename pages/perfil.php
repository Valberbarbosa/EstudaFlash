
<?php

class Perfil extends Conexao
{
    public function listar()
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM usuario WHERE id = :id";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            $dados = $result->fetchAll(PDO::FETCH_ASSOC);
            return $dados[0];
        }

        return [];
    }
    public function saveWidthPhoto($nome, $email, $foto, $nascimento, $senhaAtual, $senhaNova)
    {
        $banco = $this->conectar();

        $senhaAtualCriptografada = password_hash($senhaAtual, PASSWORD_DEFAULT);
        if (!empty($senhaAtual) and !empty($senhaNova) and $this->getUserDados($senhaAtual)) {
            $query = "UPDATE usuario SET nome = :nome, email = :email, foto = :foto, senha = :senha, data_nascimento = :nascimento WHERE id = :id_criador";
            $result = $banco->prepare($query);
            $result->bindParam(':nome', $nome);
            $result->bindParam(':email', $email);
            $result->bindParam(':foto', $foto);
            $result->bindParam(':senha', $senhaAtualCriptografada);
            $result->bindParam(':nascimento', $nascimento);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        } else {
            $query = "UPDATE usuario SET nome = :nome, email = :email, foto = :foto, data_nascimento = :nascimento WHERE id = :id_criador";
            $result = $banco->prepare($query);
            $result->bindParam(':nome', $nome);
            $result->bindParam(':email', $email);
            $result->bindParam(':foto', $foto);
            $result->bindParam(':nascimento', $nascimento);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
    public function saveWithoutPhoto($nome, $email, $nascimento, $senhaAtual, $senhaNova)
    {
        $banco = $this->conectar();

        $senhaAtualCriptografada = password_hash($senhaAtual, PASSWORD_DEFAULT);
        if (!empty($senhaAtual) and !empty($senhaNova) and $this->getUserDados($senhaAtual)) {
            $query = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, data_nascimento = :nascimento WHERE id = :id_criador";
            $result = $banco->prepare($query);
            $result->bindParam(':nome', $nome);
            $result->bindParam(':email', $email);
            $result->bindParam(':senha', $senhaAtualCriptografada);
            $result->bindParam(':nascimento', $nascimento);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        } else {
            $query = "UPDATE usuario SET nome = :nome, email = :email, data_nascimento = :nascimento WHERE id = :id_criador";
            $result = $banco->prepare($query);
            $result->bindParam(':nome', $nome);
            $result->bindParam(':email', $email);
            $result->bindParam(':nascimento', $nascimento);
            $result->bindParam(':id_criador', $_SESSION['USUARIO_ID']);
            if ($result->execute()) {
                return true;
            }
        }
        return false;
    }
    public function getUserDados($senhaAtual)
    {
        $banco = $this->conectar();

        $query = "SELECT * FROM usuario WHERE id = :id";

        $result = $banco->prepare($query);
        $result->bindParam(':id', $_SESSION['USUARIO_ID']);
        if ($result->execute()) {
            $dados = $result->fetchAll(PDO::FETCH_ASSOC);
            if (password_verify($senhaAtual, $dados[0]['senha'])) {
                return true;
            }
        }

        return false;
    }
}
