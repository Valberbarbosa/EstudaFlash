<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/perfil.php');
require_once('pages/notificacao.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$perfil = new Perfil();
$perfilDadosUsuario = $perfil->listar();
$notificacao = new Notificacao();
$notificacao_conteudo = $notificacao->listar();

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
    <link rel="stylesheet" href="assets/CSS/dasboard.css">

</head>

<body>
    <div class="container">
        <aside class="aside-menu">
            <span class="closeMenu-aside"><i class="fa fa-bars" aria-hidden="true"></i></span>
            <div class="aside-logo">
                <img draggable="false" src="./assets/IMG/logo-website.svg" alt="logo do estudaflash">
            </div>
            <div class="aside-diretorio">
                <div class="aside-form">
                    <form action="#" method="get">
                        <input type="text" placeholder="Pesquisar" name="search" id="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
                <ul>
                    <li><a href="dashboard.php"><i class="fas fa-home" aria-hidden="true"></i><span>Home</span></a></li>
                    <li><a href="explore.php"><i class="fas fa-sitemap"></i><span>Explore</span></a></li>
                    <li><a href="revisar.php"><i class="fas fa-tasks"></i><span>Revisar</span></a></li>
                </ul>
                <div class="aside-diretorio-line"></div>
                <ul>
                    <li><a href="perfil.php"><i class="fa-solid fa-user"></i><span>Perfil</span></a></li>
                    <li><a href="/pages/sair.php"><i class="fa-solid fa-right-from-bracket"></i><span>Sair</span></a></li>
                </ul>
            </div>
        </aside>
        <main>
            <header>
                <div class="header-search">
                    <form action="#" method="get">
                        <input type="text" placeholder="Pesquisar" name="search" id="search">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </form>
                </div>
                <div class="header-acoes">
                    <div class="header-logo">
                        <span class="openMenu-aside"><i class="fa fa-bars" aria-hidden="true"></i></span>
                        <img draggable="false" src="./assets/IMG/logo-website.svg" alt="logo do estudaflash">
                    </div>

                    <nav>
                        <ul>
                            <li>
                                <i class="fa-regular fa-bell"></i>
                                <span><?= $notificacao_conteudo['total'] ?></span>
                                <div class="notificacao">
                                    <?php foreach ($notificacao_conteudo['content'] as $notificacao_valor) {
                                        echo $notificacao_valor;
                                    } ?>
                                </div>
                            </li>
                        </ul>
                        <div class="header-acoes-foto">
                            <?php
                            if ($_SESSION['USUARIO_FOTO'] == 'blank-profile-picture-973460.svg') {
                                echo "<p>";
                                $nome = substr($_SESSION['USUARIO_NOME'], 0);
                                echo $nome[0];
                                echo "</p>";
                            } else {
                                echo '<img src="/assets/IMG/UPLOAD/USUARIO/' . $_SESSION['USUARIO_FOTO'] . '" alt="foto de perfil">';
                            }
                            ?>
                        </div>
                        <div class="header-acoes-nome">
                            <p>
                                <?php
                                $nome = explode(" ", $_SESSION['USUARIO_NOME']);
                                echo $nome[0];
                                ?>
                            </p>
                        </div>
                    </nav>
                </div>
            </header>
            <section id="conteudo">
                <p class="diretorio-website">Perfil</p>

                <div id="perfil">
                    <div class="perfil-container">
                        <div class="perfil-container-foto">
                            <div class="perfil-container-foto-img">
                                <?php if (file_exists(__DIR__ . '/assets/IMG/UPLOAD/USUARIO/' . $perfilDadosUsuario['foto'])) {
                                    echo '<img src="./assets/IMG/UPLOAD/USUARIO/' . $perfilDadosUsuario['foto'] . '" id="foto__upload-preview" alt="foto de perfil">';
                                } else {
                                    echo '<img src="./assets/IMG/UPLOAD/USUARIO/blank-profile-picture-973460.svg" id="foto__upload-preview" alt="foto de perfil">';
                                }
                                ?>
                                <span><i class="fas fa-camera"></i></span>
                            </div>
                            <div class="perfil-container-foto-nome">
                                <h2><?= $perfilDadosUsuario['nome'] ?></h2>
                                <button><i class="far fa-image"></i><label for="foto__upload">Carregar</label></button>
                            </div>
                        </div>
                        <div class="perfil-container-formulario">
                            <form action="pages/perfil_update.php" method="post" encType="multipart/form-data">
                                <input type="file" name="foto__upload" id="foto__upload">
                                <div class="perfil-formulario-d-1">
                                    <fieldset>
                                        <legend>Nome</legend>
                                        <input type="text" value="<?= $perfilDadosUsuario['nome'] ?>" name="nome" id="nome">
                                    </fieldset>
                                </div>
                                <div class="perfil-formulario-d-2">
                                    <fieldset>
                                        <legend>Endereço de e-mail</legend>
                                        <input type="text" value="<?= $perfilDadosUsuario['email'] ?>" name="email" id="email">
                                    </fieldset>
                                    <fieldset>
                                        <legend>Data de Nascimento</legend>
                                        <input type="date" value="<?= $perfilDadosUsuario['data_nascimento'] ?>" name="nascimento" id="nascimento">

                                    </fieldset>
                                </div>
                                <div class="perfil-formulario-d-2">
                                    <fieldset>
                                        <legend>Senha Atual</legend>
                                        <input type="text" name="senha" id="senha">
                                    </fieldset>
                                    <fieldset>
                                        <legend>Nova Senha</legend>
                                        <input type="text" name="senhaLop" id="senhaLop">
                                    </fieldset>
                                </div>
                                <button type="submit" class="perfil-btn-formulario">Atualizar</button>
                                <button type="button" class="perfil-btn-formulario perfil-btn-formulario-delete" data-id="<?= $perfilDadosUsuario['id'] ?>">Deletar conta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/perfil.js"></script>
</body>

</html>