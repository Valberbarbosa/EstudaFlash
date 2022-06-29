<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/buscar_card_revisao.php');
require_once('pages/notificacao.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$card = new ExibirCardRevisar();
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
    <title>Revisão - EstudaFlash</title>
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
                <p class="diretorio-website">Revisar</p>

                <div id="dashboard">
                    <div class="dashboard-container">
                        <h2>Revisar conteúdo</h2>

                        <div class="dashboard-card" style="margin-top: 2rem;">

                            <?php
                            $timeZone = new DateTimeZone('America/Sao_Paulo');
                            $objDateTo = new DateTime();
                            $objDateTo->setTimezone($timeZone);
                            $dataHoje = $objDateTo->format('Y-m-d');

                            $listRevisar = false;
                            foreach ($card->listar($pesquisa) as $card) {
                                $firstDate = new DateTime($card['data']);
                                $secondDate = new DateTime($dataHoje);
                                $intvl = $firstDate->diff($secondDate);

                                $conteudoCard = '<div data-id="' . $card['id_assunto'] . '" class="dashboard-card-conteudo dashboard-card-conteudo-cartoes">
                                        <div data-id="' . $card['id_assunto'] . '" class="dashboard-card-corpo front">
                                            <h1 data-id="' . $card['id_assunto'] . '">' . $card['titulo'] . '</h1>
                                        </div>
                                        <div data-id="' . $card['id_assunto'] . '" class="dashboard-card-acao">
                                            <p>' . ucfirst($card['acao']) . '</p>
                                        </div>
                                    </div>';
                                if ($card['acao'] == 'fácil' and $intvl->d == 0) {
                                    $listRevisar = true;
                                    echo $conteudoCard;
                                } else if ($card['acao'] == 'médio' and $intvl->d > 0) {
                                    $listRevisar = true;
                                    echo $conteudoCard;
                                } else if ($card['acao'] == 'difícil' and $intvl->d > 1) {
                                    $listRevisar = true;
                                    echo $conteudoCard;
                                }
                            }
                            if (!$listRevisar) { ?>
                                <p>Nenhum flashcard para revisar até o momento</p>
                            <?php } ?>


                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>


    <section id="alerta-card-visualizar" class="alerta-card-visualizar">
        <div class="alerta-card-visualizar-content">
            <div class="alerta-card-visualizar-container">
                <div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>
            </div>
            <div class="alerta-card-visualizar-acao">
                <div class="btn-card-acoes">
                    <button class="alerta-card-visualizar-editar"><a href="#">Continuar revisando</a></button>
                    <button class="alerta-card-visualizar-concluida"><a href="#">Marcar como concluída</a></button>
                </div>
            </div>
            <div class="alerta-card-visualizar-btnclose"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="alerta-card-visualizar-close"></div>

    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/revisar.js"></script>
</body>

</html>