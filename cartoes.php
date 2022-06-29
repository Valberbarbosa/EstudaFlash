<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/exibir_assunto.php');
require_once('pages/notificacao.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$assunto = new ExibirAssunto();
$assunto2 = new ExibirAssunto();
$notificacao = new Notificacao();
$notificacao_conteudo = $notificacao->listar();


$idLista = isset($_GET['id']) ? $_GET['id'] : 0;
if ($assunto->listarInformacoesDaSala($idLista)) {
    foreach ($assunto->listarInformacoesDaSala($idLista) as $value_listarInformacoesDaSala) {
        $lista_id = $value_listarInformacoesDaSala['id'];
        $lista_titulo = $value_listarInformacoesDaSala['titulo'];
        $lista_descricao = $value_listarInformacoesDaSala['descricao'];
        $lista_publico = $value_listarInformacoesDaSala['publico'];
    }
} else {
    require_once("404.php");
    exit();
}

$pesquisa = isset($_GET['search']) ? $_GET['search'] : null;


?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.svg" type="image/x-icon">
    <title><?= $lista_titulo ?> - EstudaFlash</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/ui/trumbowyg.min.css" integrity="sha512-nwpMzLYxfwDnu68Rt9PqLqgVtHkIJxEPrlu3PfTfLQKVgBAlTKDmim1JvCGNyNRtyvCx1nNIVBfYm8UZotWd4Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/emoji/ui/trumbowyg.emoji.min.css" integrity="sha512-xpR3G7LZbpAnoUgES2Xu2Z/mK8NwejLjJpNHQtmdU36yGP2AS5kgpflPwv6vEurEeruDcghOtHkWNsOkwVx2ig==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/giphy/ui/trumbowyg.giphy.min.css" integrity="sha512-XtXSCsMCGIY7o4dasaT3nwKT3VPbYa+BMqBHxbThLEheafPGri4XDyiJiZAzri9vKSLb0UsxZHtXM9KCoH/hKw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                        <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
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
                <p class="diretorio-website">Home</p>

                <div id="dashboard">
                    <div class="dashboard-container">
                        <h2><?= $lista_titulo ?></h2>
                        <h3 class="dashbord-h3">Estudar</h3>
                        <div class="dashboard-tornar">
                            <div class="dashboard-tornar-publico">
                                <div class="ball ball-mover <?= $lista_publico == 1 ? 'btn-text-m' : '' ?>">
                                    <span class="btn-texto"><?= $lista_publico == 1 ? 'Sim' : 'Não' ?></span>
                                    <div class="btn <?= $lista_publico == 1 ? 'btn-m' : '' ?>"></div>
                                    <input type="hidden" id="ball__mover-value" class="btn-value" name="tipo" value="<?= $idLista ?>">
                                </div>
                                <span>Tornar público?</span>
                            </div>

                        </div>
                        <div class="dashbord-acoes">
                            <button class="dashbord-container-btn-add dashbord-container-btn-add-cartoes">Adicionar novo assunto</button>
                            <div>
                                <button class="dashbord-container-btn-deletar dashbord-container-btn-add-licao"><a href="pages/deletar_disciplina.php?id=<?= $idLista ?>">Deletar Disciplina</a></button>
                                <button class="dashbord-container-btn-editar dashbord-container-btn-add-licao">Editar cartão</button>
                            </div>
                        </div>
                        <div class="dashboard-card">
                            <?php
                            if (count($assunto->listar($idLista, $pesquisa)) > 0) {
                                $array = '';
                                $count = 1;
                                $countPostagem = 0;
                                foreach ($assunto->listar($idLista, $pesquisa) as $valor_exibirAssunto) {

                                    if ($count < count($assunto->listar($idLista, $pesquisa))) {
                                        $array .= "" . $valor_exibirAssunto['id'] . ",";
                                        //$array .= "'". $count ."':'" . $valor_exibirAssunto['id'] . "', ";
                                        $count++;
                                    } else {
                                        $array .= "" . $valor_exibirAssunto['id'] . "";
                                        //$array .= "'". $count ."':'" . $valor_exibirAssunto['id'] . "'";
                                    }
                            ?>
                                    <div data-postagem="<?= $countPostagem ?>" class="dashboard-card-id-<?= $countPostagem ?> dashboard-card-conteudo dashboard-card-conteudo-cartoes">
                                        <div data-id="<?= $valor_exibirAssunto['id'] ?>" data-postagem="<?= $countPostagem ?>" class="dashboard-card-corpo front">
                                            <h1 data-id="<?= $valor_exibirAssunto['id'] ?>" data-postagem="<?= $countPostagem ?>"><?= $valor_exibirAssunto['titulo'] ?></h1>
                                        </div>
                                    </div>
                                <?php
                                    $countPostagem++;
                                }
                                $arrayCard = "" . $array . "";
                                echo '<input type="hidden" id="cards-opcao" name="cards-opcao" value="' . $arrayCard . '">';
                            } else {
                                ?>
                                <p>Nenhuma assunto foi criada até o momento</p>
                            <?php
                            }
                            ?>

                            <!--
                            <div class="dashboard-card-conteudo dashboard-card-conteudo-cartoes">
                                <div class="dashboard-card-corpo front">
                                    <h1>Excuse me</h1>
                                </div>
                                <div class="dashboard-card-corpo back">
                                    <h1>Com licença</h1>
                                </div>
                            </div>
                            -->
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <section id="cartao-editar" class="cartao-editar">
        <div class="cartao-editar-container">
            <h2>Editar informações do cartão</h2>

            <form action="pages/editar_cartao.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_lista" value="<?= $_GET['id'] ?>">
                <fieldset>
                    <legend>Titulo</legend>
                    <input type="text" name="titulo" value="<?= $lista_titulo ?>" placeholder="Informe o nome para este cartão" id="nome__cartao">
                </fieldset>
                <fieldset>
                    <legend>Descrição</legend>
                    <textarea name="descricao" id="descricao__cartao" placeholder="Informe uma descrição para este cartão"><?= $lista_descricao ?></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="cartao-editar-btn cartao-editar-finalizar">Cancelar</button>
                    <button type="submit" class="cartao-editar-btn cartao-editar-concluir">Modificar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <section id="alerta-add-licao" class="alerta-add-licao">
        <div class="alerta-add-licao-container">
            <h2>Adicionar um novo cartão</h2>

            <form action="pages/criar_assunto.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_lista" value="<?= $_GET['id'] ?>">
                <fieldset>
                    <legend>Termo</legend>
                    <input type="text" name="titulo" placeholder="Digite o que deseja aprender" id="titulo">
                </fieldset>
                <fieldset>
                    <legend>Definição</legend>
                    <textarea class="textarea" name="descricao" id="descricao" placeholder="Informe a resposta"></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="alerta-add-licao-btn alerta-add-licao-finalizar">Cancelar</button>
                    <button type="submit" class="alerta-add-licao-btn alerta-add-licao-concluir">Adicionar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <section id="alerta-editar-licao" class="alerta-editar-licao">
        <div class="alerta-editar-licao-container">
            <h2>Editar cartão</h2>

            <form action="pages/editar_assunto.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_lista" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="id" id="editar-id">
                <fieldset>
                    <legend>Termo</legend>
                    <input type="text" name="titulo" placeholder="Digite o que deseja aprender" id="editar-titulo">
                </fieldset>
                <fieldset>
                    <legend>Definição</legend>
                    <textarea class="textarea" id="editor2" name="descricao__editar" placeholder="Informe a resposta"></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="alerta-add-licao-btn alerta-editar-licao-finalizar">Cancelar</button>
                    <button type="submit" class="alerta-add-licao-btn alerta-add-licao-concluir">Editar</button>
                </fieldset>
            </form>
        </div>
    </section>
    <section id="alerta-card-visualizar" class="alerta-card-visualizar">
        <div class="alerta-card-visualizar-content">
            <div class="alerta-card-visualizar-container">
                <div class="loading"><img class="loading-img" src="./assets/IMG/load-gif.gif" alt="loading"></div>
            </div>
            <div class="alerta-card-visualizar-acao">
                <div class="btn-card-acoes">
                    <button class="alerta-card-visualizar-editar">Editar</button>
                    <button class="alerta-card-visualizar-deletar"><a href="#">Deletar</a></button>
                </div>
                <div class="btn-card-view">
                    <button class="btn-card-view-facil">Fácil</button>
                    <button class="btn-card-view-medio">Médio</button>
                    <button class="btn-card-view-dificio">Difícil</button>
                </div>
            </div>
            <div class="alerta-card-visualizar-btnclose"><i class="fa-solid fa-xmark"></i></div>
            <div class="alerta-card-mover alerta-card-left">
                <i class="fa-solid fa-chevron-left"></i>
            </div>
            <div class="alerta-card-mover alerta-card-right">
                <i class="fa-solid fa-chevron-right"></i>
            </div>
            <div class="alerta-card-visualizar-content-loading">
                <div>
                    <h2>Resposta marcada com sucesso!</h2>
                    <p>Aguarde só um segundo enquanto armazenamos sua resposta</p>
                    <div class="demo-container">
                        <div class="progress-bar">
                            <div class="progress-bar-value"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="alerta-card-visualizar-close"></div>

    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/trumbowyg.min.js" integrity="sha512-t4CFex/T+ioTF5y0QZnCY9r5fkE8bMf9uoNH2HNSwsiTaMQMO0C9KbKPMvwWNdVaEO51nDL3pAzg4ydjWXaqbg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/langs/pt_br.min.js" integrity="sha512-iJ7snbcZfiZbui/K17AYkBONvjRS1F3V/Y/Ph7n84hptyJUDeXO6rCUX05N5yeY53EUyDotiLn+nK4GXoKXyug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/emoji/trumbowyg.emoji.min.js" integrity="sha512-PPEK09bmt7tQg/qdNokvbckNVB4EqXTu+qi4X/j9XoFag6YspjU5xO/FXXCEjBxo1+Z41oOFvIyz5QkjSuTNsQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/fontsize/trumbowyg.fontsize.min.js" integrity="sha512-eYBhHjpFi6wk8wWyuXYYu54CRcXA3bCFSkcrco4SR1nGtGSedgAXbMbm3l5X4IVEWD8U7Pur9yNjzYu8n4aIMA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/fontfamily/trumbowyg.fontfamily.min.js" integrity="sha512-ha/jXUX4sZMHEvpHLtYOIvMDK8/a8ncRhAPSmQVUx/to+04w+zUBWWZHaPQMPt6qjx94V/lbE9ZEsTsb7F+sTw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.25.1/plugins/giphy/trumbowyg.giphy.min.js" integrity="sha512-1auqiu0UbFhtGEDnCosTHjToHy9oouydu0tlLmMMVCpMSoBiZlmOEXXVmsaIfN05Tlb+w60XBz8HR7Lh7dWAYQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/licao.js"></script>
    <script src="./assets/JS/cartoes.js"></script>
    <script>
        $('.textarea').trumbowyg({
            lang: 'pt-BR'
        });
    </script>
</body>

</html>