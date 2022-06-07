<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/exibir_card_publico.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$card = new ExibirCardPublico();
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
                    <li><a href="perfil.php"><i class="fa-solid fa-user"></i><span>Perfil</span></a></li>
                </ul>
                <div class="aside-diretorio-line"></div>
                <ul>
                    <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span>Configuração</span></a></li>
                    <li><a href="#"><i class="fa-solid fa-right-from-bracket"></i><span>Sair</span></a></li>
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
                            <li><i class="fa-regular fa-bell"></i></li>
                            <li><i class="far fa-envelope"></i></li>
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
                <p class="diretorio-website">Explorar</p>
                <div id="dashboard">
                    <div class="dashboard-container">
                        <h2>Cartões públicos</h2>
                        <p class="dashboard-paragrafo">Veja abaixo todos os cartões público que você pode visualizar e estudar a partir de conteúdos criados por outras pessoas</p>
                        <div class="dashboard-card dashboard-card-mx-4">
                            <?php
                            if (count($card->exibir()) > 0) {
                                foreach ($card->exibir() as $value) {
                                    $total_exibirListas = $card->assunto($value['id']);
                                    $total_exibirListas = $total_exibirListas['total'];
                            ?>
                                    <a href="cartoes.php?id=1" class="dashboard-card-conteudo">
                                        <div class="dashboard-card-corpo">
                                            <h3><?= $value['titulo'] ?></h3>
                                            <p class="dashboard-card-p-descricao"><?= $value['descricao'] ?></p>
                                            <p class="dashboard-card-p-total"><?= $total_exibirListas ?> <?= $total_exibirListas > 1? 'cartões':'cartão' ?> criado até o momento</p>
                                        </div>
                                    </a>
                            <?php
                                }
                            } else {
                                echo 'Nenhum card foi adicionado como público até o momento';
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <script src="./assets/JS/dashboard.js"></script>
</body>

</html>