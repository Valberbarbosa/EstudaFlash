CREATE TABLE
  `usuario` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `nome` varchar(200) NOT NULL,
    `email` varchar(200) NOT NULL,
    `senha` varchar(255) NOT NULL,
    `foto` varchar(250) NOT NULL,
    `data_nascimento` date NOT NULL,
    `hash` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4

CREATE TABLE
  `lista` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_criador` int(11) NOT NULL,
    `titulo` varchar(250) NOT NULL,
    `descricao` varchar(250) NOT NULL,
    `publico` int(1) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 3 DEFAULT CHARSET = utf8mb4

CREATE TABLE
  `assunto` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_lista` int(11) NOT NULL,
    `id_criador` int(11) NOT NULL,
    `titulo` varchar(200) NOT NULL,
    `descricao` varchar(250) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4