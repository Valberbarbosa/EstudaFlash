<?php
session_start();
require_once('conexao.php');
require_once('validar_sessao.php');
require_once('validarInformacoes.php');
require_once('perfil.php');

$validarDados = new Validar();
$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$perfil = new Perfil();
$nome = $validarDados->validarInformacoes($_POST['nome']);
$email = $validarDados->validarInformacoes($_POST['email']);
$nascimento = $validarDados->validarInformacoes($_POST['nascimento']);
$senhaAtual = $validarDados->validarInformacoes($_POST['senha']);
$senhaNova = $validarDados->validarInformacoes($_POST['senhaLop']);

$ARQUIVO['PASTA'] = dirname(__DIR__) . '/assets/IMG/UPLOAD/USUARIO/';
$ARQUIVO['TMP_NAME'] = $_FILES['foto__upload']['tmp_name'];
$ARQUIVO['NAME'] = $_FILES['foto__upload']['name'];
$ARQUIVO['RENAME'] =  'EstudaFlash__PERFIL__' . uniqid() . '__' . time() . '.' . pathinfo($ARQUIVO['NAME'], PATHINFO_EXTENSION);
echo $ARQUIVO['RENAME'];

if (!empty($nome) and !empty($email) and !empty($nascimento)) {
    if ($_FILES['foto__upload']['size'] > 0 and $_FILES['foto__upload']['error'] == 0) {
        if (move_uploaded_file($ARQUIVO['TMP_NAME'], $ARQUIVO['PASTA'] . $ARQUIVO['RENAME'])) {
            if($perfil->saveWidthPhoto($nome, $email, $ARQUIVO['RENAME'], $nascimento, $senhaAtual, $senhaNova)){
                header('Location: ../perfil.php');
            }
        }
    }else{
        if($perfil->saveWithoutPhoto($nome, $email, $nascimento, $senhaAtual, $senhaNova)){
            header('Location: ../perfil.php');
        }
    }
}else{
    header('Location: ../perfil.php');
}
