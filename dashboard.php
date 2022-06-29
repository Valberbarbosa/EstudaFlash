<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/exibir_lista.php');
require_once('pages/notificacao.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$exibirListas = new ExibirLista();
$notificacao = new Notificacao();
$notificacao_conteudo = $notificacao->listar();

$pesquisa = isset($_GET['search']) ? $_GET['search'] : null;

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
                                <!--<span><i class="fa-solid fa-angle-down"></i></span>-->
                            </p>
                        </div>
                    </nav>
                </div>
            </header>
            <section id="conteudo">
                <p class="diretorio-website">Home</p>

                <div id="dashboard">
                    <div class="dashboard-container">
                        <h2>Suas atividades</h2>
                        <button class="dashbord-container-btn-add dashbord-container-btn-add-licao">Adicionar nova lição</button>
                        <div class="dashboard-card">
                            <?php if (count($exibirListas->listar($pesquisa)) > 0) {
                                foreach ($exibirListas->listar($pesquisa) as $valor_exibirListas) {
                                    $total_exibirListas = $exibirListas->assunto($valor_exibirListas['id']);
                                    $total_exibirListas = $total_exibirListas['total'];
                            ?>
                                    <a href="cartoes.php?id=<?= $valor_exibirListas['id'] ?>" class="dashboard-card-conteudo">
                                        <div class="dashboard-card-corpo">
                                            <h3><?= $valor_exibirListas['titulo'] ?></h3>
                                            <p class="dashboard-card-p-descricao"><?= $valor_exibirListas['descricao'] ?></p>
                                            <p class="dashboard-card-p-total"><?= $total_exibirListas ?> <?= $total_exibirListas > 1 ? 'cartões' : 'cartão' ?> criado até o momento</p>
                                        </div>
                                    </a>
                                <?php }
                            } else {
                                ?>
                                <p>Nenhuma lista foi criada até o momento</p>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>
    <section id="alerta-add-licao" class="alerta-add-licao">
        <div class="alerta-add-licao-container">
            <h2>Criar uma nova lista de estudos</h2>

            <form action="pages/criar_lista.php" method="post">
                <fieldset>
                    <legend>Titulo</legend>
                    <input type="text" name="titulo" placeholder="Digite um título, como &quot;Português&quot;" id="titulo">
                </fieldset>
                <fieldset>
                    <legend>Descrição</legend>
                    <textarea name="descricao" id="descricao" placeholder="Adicione uma descrição para essa categoria"></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="alerta-add-licao-btn alerta-add-licao-finalizar">Cancelar</button>
                    <button type="submit" class="alerta-add-licao-btn alerta-add-licao-concluir">Adicionar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/licao.js"></script>
</body>

</html>