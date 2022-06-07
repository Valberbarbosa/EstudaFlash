<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
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
                <p class="diretorio-website">Home</p>

                <div id="dashboard">
                    <div class="dashboard-container">
                        <h2>Inglês</h2>
                        <h3 class="dashboard-h3-card">Estudar</h3>
                        <div class="dashboard-progress">
                            <div class="dashboard-progress-line">
                                <div class="dashboard-progress-porcentagem" style="width: 0%"></div>
                            </div>
                            <div class="dashboard-progress-text">
                                <p>PROGRESSO</p>
                                <p><span class="progress-total-atual">0</span>/<span class="progress-total">0</span></p>
                            </div>
                        </div>
                        <div class="dashboard-card">
                            <div class="dashboard-card-conteudo dashboard-card-conteudo-aprender">
                                <div class="dashboard-card-corpo">
                                    <div class="dashbord-card-content dashbord-card-content-aprender active">
                                        <h1>Excuse me</h1>
                                    </div>
                                    <div class="dashbord-card-content dashbord-card-content-aprender">
                                        <h1>Have</h1>
                                    </div>
                                    <div class="dashbord-card-content dashbord-card-content-aprender">
                                        <h1>Nice to meet you</h1>
                                    </div>
                                </div>
                                <div class="dashboard-card-input">
                                    <fieldset>
                                        <legend>Sua resposta</legend>
                                        <div class="dashboard-card-fieldset">
                                            <div class="dashboard-card-fieldset-input">
                                                <button data-op="a" class="dashboard-btn-exercitar">OPÇÃO A</button>
                                                <button data-op="b" class="dashboard-btn-exercitar">OPÇÃO B</button>
                                            </div>
                                            <div class="dashboard-card-fieldset-input">
                                                <button data-op="c" class="dashboard-btn-exercitar">OPÇÃO C</button>
                                                <button data-op="d" class="dashboard-btn-exercitar">OPÇÃO D</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <section id="alerta-add-licao" class="alerta-add-licao">
        <div class="alerta-add-licao-container">
            <h2>Adicionar um novo cartão</h2>

            <form action="#" method="post">
                <fieldset>
                    <legend>Termo</legend>
                    <input type="text" name="titulo" placeholder="Digite o que deseja aprender" id="titulo">
                </fieldset>
                <fieldset>
                    <legend>Definição</legend>
                    <textarea name="descricao" id="descricao" placeholder="Informe a resposta"></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="alerta-add-licao-finalizar">Cancelar</button>
                    <button type="submit" class="alerta-add-licao-concluir">Adicionar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/licao.js"></script>
</body>

</html>