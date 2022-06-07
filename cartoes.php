<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');
require_once('pages/exibir_assunto.php');

$session = new ValidarSessao($_COOKIE['session'], $_COOKIE['hash']);

if (!$session->validar()) {
    header("Location: ../index.php");
}

$assunto = new ExibirAssunto();
$assunto2 = new ExibirAssunto();

$idLista = isset($_GET['id']) ? $_GET['id'] : 0;
if ($assunto->listarInformacoesDaSala($idLista)) {
    foreach ($assunto->listarInformacoesDaSala($idLista) as $value_listarInformacoesDaSala) {
        $lista_id = $value_listarInformacoesDaSala['id'];
        $lista_titulo = $value_listarInformacoesDaSala['titulo'];
        $lista_publico = $value_listarInformacoesDaSala['publico'];
    }
} else {
    require_once("404.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./assets/IMG/logo-favicon.svg" type="image/x-icon">
    <title><?= $lista_titulo ?> - EstudaFlash</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/34.1.0/classic/ckeditor.js"></script>
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
                            <div class="dashbord-acoes-opcoes">
                                <button><a href="cartao.php?id=<?= $lista_id ?>">Cartão</a></button>
                                <button><a href="aprender.php?id=<?= $lista_id ?>">Aprender</a></button>
                                <button><a href="exercitar.php?id=<?= $lista_id ?>">Exercitar</a></button>
                            </div>
                            <button class="dashbord-container-btn-add dashbord-container-btn-add-cartoes">Adicionar novo assunto</button>
                        </div>
                        <div class="dashboard-card">
                            <?php if (count($assunto->listar($idLista)) > 0) {
                                foreach ($assunto->listar($idLista) as $valor_exibirAssunto) {
                            ?>
                                    <div class="dashboard-card-conteudo dashboard-card-conteudo-cartoes">
                                        <div data-id="<?= $valor_exibirAssunto['id'] ?>" class="dashboard-card-corpo front">
                                            <h1 data-id="<?= $valor_exibirAssunto['id'] ?>"><?= $valor_exibirAssunto['titulo'] ?></h1>
                                        </div>
                                    </div>
                                <?php }
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
                    <textarea id="editor" name="descricao" id="descricao" placeholder="Informe a resposta"></textarea>
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
            <h2>Adicionar um novo cartão</h2>

            <form action="pages/criar_assunto.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_lista" value="<?= $_GET['id'] ?>">
                <fieldset>
                    <legend>Termo</legend>
                    <input type="text" name="titulo" placeholder="Digite o que deseja aprender" id="editar-titulo">
                </fieldset>
                <fieldset>
                    <legend>Definição</legend>
                    <textarea id="editor2" name="descricao" placeholder="Informe a resposta"></textarea>
                </fieldset>
                <fieldset>
                    <button type="button" class="alerta-add-licao-btn alerta-add-licao-finalizar">Cancelar</button>
                    <button type="submit" class="alerta-add-licao-btn alerta-add-licao-concluir">Adicionar</button>
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
                    <button>Fácil</button>
                    <button>Médio</button>
                    <button>Dificio</button>
                </div>
            </div>
            <div class="alerta-card-visualizar-btnclose"><i class="fa-solid fa-xmark"></i></div>
        </div>
        <div class="alerta-card-visualizar-close"></div>

    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
    <script src="./assets/JS/dashboard.js"></script>
    <script src="./assets/JS/licao.js"></script>
    <script src="./assets/JS/cartoes.js"></script>

    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor => {
                window.editor = editor;
            })
            .catch(err => {
                console.error(err.stack);
            });
        ClassicEditor
            .create(document.querySelector('#editor2'), {
                // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            })
            .then(editor2 => {
                window.editor2 = editor2;
            })
            .catch(err => {
                console.error(err.stack);
            });
    </script>

</body>

</html>