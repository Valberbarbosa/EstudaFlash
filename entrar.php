<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');

$sessionCookie = isset($_COOKIE['session'])? $_COOKIE['session']:null;
$hashCookie = isset($_COOKIE['hash'])? $_COOKIE['hash']:null;
$session = new ValidarSessao($sessionCookie, $hashCookie);

if ($session->validar()) {
    header("Location: ../dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.svg" type="image/x-icon">
    <title>EstudaFlash - O lugar perfeito para focar nos seus estudos</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./assets/CSS/acesso.css">
</head>

<body>
    <main>
        <section id="banner">
            <header>
                <div class="header-logo-estudaflash">
                    <span id="open-menu" class="material-symbols-outlined">menu</span>
                    <img draggable="false" src="./assets/IMG/logo-website.svg" alt="logo do estudaflash">
                </div>
                <nav class="menu">
                    <div class="nav-logo-estudaflash">
                        <span id="close-menu" class="material-symbols-outlined">menu</span>
                        <img draggable="false" src="./assets/IMG/logo-website.svg" alt="logo do estudaflash">
                    </div>
                    <div class="header-diretorio-projeto">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="entrar.php">Login</a></li>
                            <li><a href="cadastro.php">Cadastrar</a></li>
                        </ul>
                    </div>
                </nav>
            </header>
        </section>
        <section id="acesso">
            <form action="pages/validar_login.php" method="post">
                <h2>Bem-vindo de volta ao EstudaFlash</h2>
                <fieldset>
                    <legend>E-mail</legend>
                    <input type="email" name="email" id="email" placeholder="Digite seu e-mail">
                </fieldset>
                <fieldset>
                    <legend>Senha</legend>
                    <input type="password" name="senha" id="senha" placeholder="Digite sua senha">
                </fieldset>
                <fieldset>
                    <button type="submit">Se conectar</button>
                </fieldset>
            </form>
        </section>
    </main>
    <script src="/assets/JS/main.js"></script>
</body>

</html>