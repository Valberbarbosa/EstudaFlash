<?php
session_start();
require_once('pages/conexao.php');
require_once('pages/validar_sessao.php');

$sessionCookie = isset($_COOKIE['session'])? $_COOKIE['session']:null;
$hashCookie = isset($_COOKIE['hash'])? $_COOKIE['hash']:null;
$session = new ValidarSessao($sessionCookie, $hashCookie);

echo "<pre>";
print_r($session->validar());
echo "</pre>";
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
    <link rel="stylesheet" href="./assets/CSS/style.css">
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
                        </ul>
                    </div>
                    <div class="header-cadastro-sistema">
                        <button><a href="cadastro.php">CADASTRAR</a></button>
                    </div>
                </nav>
            </header>
            <div class="banner-container">
                <div class="banner-conteudo">
                    <div class="banner-container-texto">
                        <h2>Fa??a dos seus estudos algo mais produtivo</h2>
                        <p>O EstudaFlash ir?? te guiar para o caminho da aprova????o, memorize seus informa????es b??sicas e
                            importante para o seu conhecimento</p>
                        <button><a href="cadastro.php">Cadastre-se</a></button>
                    </div>
                    <div class="banner-container-card">
                        <div class="card-container">
                            <div class="card-container-titulo">
                                <h2>Diferen??a entre eu e mim</h2>
                            </div>
                            <div class="card-container-descricao">
                                <div class="card-container-materia">
                                    <h2>Portugu??s</h2>
                                </div>
                                <div class="card-container-data">
                                    <h2>12/03/2022</h2>
                                </div>
                            </div>
                        </div>
                        <div class="card-container card-container-two">
                            <div class="card-container-titulo">
                                <h2>How are you?</h2>
                            </div>
                            <div class="card-container-descricao">
                                <div class="card-container-materia">
                                    <h2>Ingl??s</h2>
                                </div>
                                <div class="card-container-data">
                                    <h2>12 do junho de 2022</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="sobreprojeto">
            <div class="sobreprojeto-container">
                <div class="sobreprojeto-texto">
                    <h3>Divirta-se aprendendo</h3>
                    <h2>Crie cart??es e organize em grupos, revise quando quiser</h2>
                    <p>Com cart??es criados, voc?? pode revisar todos os dias de forma gratuita. Al??m disso, poder??
                        personalizar seus cart??es da forma que voc?? bem quiser</p>
                    <button><a href="entrar.php">Criar flashcard</a></button>
                </div>
                <div class="sobreprojeto-imagem">
                    <img draggable="false" src="./assets/IMG/boy-sobrenos.svg"
                        alt="Representa????o para explicar sobre o projeto">
                </div>
            </div>
        </section>
        <section id="etapa">
            <div class="etapa-container">
                <div class="etapa-card">
                    <div class="etapa-card-conteudo">
                        <div class="etapa-card-square">
                            <div class="etapa-card-square-icon">
                                <div class="square-icon-container square-icon-1">
                                    <img draggable="false" src="./assets/IMG/icons8-question-mark-90.png" alt="icone">
                                </div>
                            </div>
                            <div class="etapa-card-square-texto">
                                <h2>Como funciona</h2>
                                <p>Nam molestie ante quis orci elementum, vel fermentum mi venenatis. Integer ac turpis
                                    neque.</p>
                            </div>
                        </div>
                        <div class="etapa-card-square">
                            <div class="etapa-card-square-icon">
                                <div class="square-icon-container square-icon-2">
                                    <img draggable="false" src="./assets/IMG/icons8-book-90.png" alt="icone">
                                </div>
                            </div>
                            <div class="etapa-card-square-texto">
                                <h2>Pra que serve</h2>
                                <p>Nam molestie ante quis orci elementum, vel fermentum mi venenatis. Integer ac turpis
                                    neque.</p>
                            </div>
                        </div>
                        <div class="etapa-card-square">
                            <div class="etapa-card-square-icon">
                                <div class="square-icon-container square-icon-3">
                                    <img draggable="false" src="./assets/IMG/icons8-connectivity-and-help-90.png"
                                        alt="icone">
                                </div>
                            </div>
                            <div class="etapa-card-square-texto">
                                <h2>Quero participar</h2>
                                <p>Nam molestie ante quis orci elementum, vel fermentum mi venenatis. Integer ac turpis
                                    neque.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="etapa-texto">
                    <h2>A maneira mais inteligente de alavancar seu conhecimento</h2>
                    <p>EstudaFlash ?? a ferramenta perfeita de aprendizado para ajud??-lo a reter informa????es essenciais,
                        n??o importa qual seja o seu assunto, n??vel ou campo de estudo.</p>
                    <button><a href="dashboard.php">Conhe??a a plataforma</a></button>
                </div>
            </div>
        </section>
        <section id="resumo">
            <div class="resumo-texto">
                <div class="resumo-line"></div>
                <h3>Tudo o que voc?? precisa</h3>
                <h2>Os recursos necess??rios pra voc?? alcan??ar <span>seu pr??ximo n??vel</span></h2>
                <p>Os Flashcards s??o pequenos cart??es que auxiliam no resumo e memoriza????o da mat??ria. Na ??rea
                    educacional traduzimos o termo flashcard como um termo de aprendizagem r??pida, atrav??s da repeti????o,
                    associa????o e memoriza????o.</p>
            </div>
        </section>
        <section id="card">
            <div class="card-container">
                <h3>A maneira inteligente de lidar com os detalhes</h3>
                <h2 class="card-titulo">Simples de criar e f??cil de usar</h2>
                <div class="card-conteudo">
                    <div class="card-estrutura">
                        <div class="card-estrutura-icon">
                            <img src="/assets/IMG/ICONE/icon-criar.svg" alt="criar">
                        </div>
                        <h2>Crie seus flashcards</h2>
                        <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    </div>
                    <div class="card-estrutura">
                        <div class="card-estrutura-icon">
                            <img src="/assets/IMG/ICONE/icon-revisar.svg" alt="criar">
                        </div>
                        <h2>Revise quando quiser</h2>
                        <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    </div>
                    <div class="card-estrutura">
                        <div class="card-estrutura-icon">
                            <img src="/assets/IMG/ICONE/icon-organizar.svg" alt="criar">
                        </div>
                        <h2>Organize do seu jeito</h2>
                        <p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
                    </div>
                </div>
            </div>
        </section>
        <section id="alerta">
            <div class="alerta-texto">
                <h3>N??o perca tempo</h3>
                <h2><span>Inscreva-se</span> para aproveitar todos os recursos dispon??veis</h2>
                <div class="alerta-texto-btn">
                    <button><a href="cadastro.php">Inscreva-se</a></button>
                    <span>aproveite, ?? gr??tis </span>
                </div>
            </div>
        </section>
        <footer>
            <div id="footer">
                <div class="footer-conteudo">
                    <div class="footer-logo">
                        <img src="./assets/IMG/logo-2-website.svg" alt="logo EstudaFlash">
                    </div>
                    <div class="footer-diretorio">
                        <ul>
                            <li><a href="index.php">Home</a></li>
                            <li><a href="entrar.php">Login</a></li>
                            <li><a href="cadastro.php">Cadastro</a></li>
                            <li><a href="#">Contato</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-baixo">
                    <p>Todos os direitos resevados. Veja nossa <a href="#">Pol??tica de privacidade</a> e <a href="#">Termos de Uso</a></p>
                    <div class="footer-baixo-siga">
                        <ul>
                            <li>Siga em</li>
                            <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
                            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </main>
    <script src="/assets/JS/main.js"></script>
</body>

</html>