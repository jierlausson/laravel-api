--
-- Banco de dados: `neetex`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `agulheiro`
--

CREATE TABLE `agulheiro`
(
    `id`                      int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `quantidade_total`        int(11) DEFAULT NULL,
    `valor_total`             decimal(10, 2) DEFAULT NULL,
    `status_id`               int(11) NOT NULL,
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime       DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime       DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `agulheiro`
--

INSERT INTO `agulheiro` (`id`, `nome`, `quantidade_total`, `valor_total`, `status_id`, `log_cadastro_data`,
                         `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`,
                         `log_excluido_usuario_id`)
VALUES (1, 'NTS581035', 720, '2448.00', 1, '2020-08-02 18:08:01', 2, NULL, NULL, NULL, NULL),
       (2, 'NTS7901007', 790, '5135.00', 2, '2020-08-02 19:08:24', 2, '2020-08-02 20:08:31', 2, NULL, NULL),
       (3, 'NHT56789', 420, '2268.00', 1, '2020-08-02 20:08:02', 2, NULL, NULL, NULL, NULL),
       (4, 'NHT4207', 735, '5512.50', 2, '2020-08-02 20:08:24', 2, '2020-08-02 20:08:36', 2, NULL, NULL),
       (5, 'NHTS485210', 640, '3360.00', 2, '2020-08-02 20:08:31', 2, '2020-08-02 20:08:37', 2, NULL, NULL),
       (6, 'NHTS691032', 6350, '15557.50', 2, '2020-08-02 20:08:31', 2, '2020-08-02 20:08:27', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `agulheiro_agulhas`
--

CREATE TABLE `agulheiro_agulhas`
(
    `id`                      int(11) NOT NULL,
    `agulheiro_id`            int(11) NOT NULL,
    `modelo_agulha_id`        int(11) NOT NULL,
    `valor_unitario`          decimal(10, 2) NOT NULL,
    `quantidade_atual`        int(11) NOT NULL,
    `quantidade_inicial`      int(11) NOT NULL,
    `log_cadastro_data`       datetime       NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `agulheiro_agulhas`
--

INSERT INTO `agulheiro_agulhas` (`id`, `agulheiro_id`, `modelo_agulha_id`, `valor_unitario`, `quantidade_atual`,
                                 `quantidade_inicial`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                                 `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`,
                                 `log_excluido_usuario_id`)
VALUES (1, 1, 2, '3.40', 720, 720, '2020-08-02 18:08:01', 2, NULL, NULL, NULL, NULL),
       (2, 2, 2, '6.50', 580, 790, '2020-08-02 19:08:24', 2, NULL, NULL, NULL, NULL),
       (3, 3, 2, '5.40', 420, 420, '2020-08-02 20:08:02', 2, NULL, NULL, NULL, NULL),
       (4, 4, 2, '7.50', 595, 735, '2020-08-02 20:08:24', 2, NULL, NULL, NULL, NULL),
       (5, 5, 2, '5.25', 270, 640, '2020-08-02 20:08:31', 2, NULL, NULL, NULL, NULL),
       (6, 6, 1, '2.45', 6350, 6350, '2020-08-02 20:08:31', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `agulheiro_status`
--

CREATE TABLE `agulheiro_status`
(
    `id`                      int(11) NOT NULL,
    `nome`                    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `log_cadastro_data`       datetime                                NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `agulheiro_status`
--

INSERT INTO `agulheiro_status` (`id`, `nome`, `log_cadastro_data`, `log_cadastro_usuario_id`, `log_alterado_data`,
                                `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 'EM ESTOQUE', '2020-07-16 10:30:22', 1, NULL, NULL, NULL, NULL),
       (2, 'EM MÁQUINA', '2020-07-16 10:30:22', 1, NULL, NULL, NULL, NULL),
       (3, 'FIM DE VIDA ÚTIL', '2020-07-16 10:30:22', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `artigo`
--

CREATE TABLE `artigo`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `artigo`
--

INSERT INTO `artigo` (`id`, `proprietario_id`, `nome`, `situacao`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                      `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'Meia malha', 'Ativo', '2020-05-12 16:33:20', 1, NULL, NULL, NULL, NULL),
       (2, 1, 'Tricot', 'Ativo', '2020-05-12 16:33:34', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `cliente`
--

CREATE TABLE `cliente`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) DEFAULT NULL,
    `nome`                    varchar(255) NOT NULL,
    `apelido`                 varchar(255) DEFAULT NULL,
    `documento`               varchar(255) DEFAULT NULL,
    `endereco_cidade`         varchar(255) DEFAULT NULL,
    `endereco_uf`             varchar(255) DEFAULT NULL,
    `email`                   varchar(255) DEFAULT NULL,
    `telefone`                varchar(255) DEFAULT NULL,
    `contato_nome`            varchar(255) DEFAULT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL,
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime     DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime     DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cliente`
--

INSERT INTO `cliente` (`id`, `proprietario_id`, `nome`, `apelido`, `documento`, `endereco_cidade`, `endereco_uf`,
                       `email`, `telefone`, `contato_nome`, `situacao`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                       `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'Cliente', 'Apelido', '15.615.656/5645-64', NULL, NULL, 'pedro.morais@w2o.com.br', '(47) 3041-3635',
        'Contato nome', 'Ativo', '2020-05-13 09:27:50', 1, '2020-05-13 09:40:14', 1, NULL, NULL),
       (2, 1, 'Demervaldo Batista da Silva', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ativo', '2020-06-19 14:06:46',
        2, '2020-07-06 19:07:34', 2, '2020-07-06 19:07:34', 2),
       (3, 1, 'Teste', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Ativo', '2020-07-06 19:07:33', 2, NULL, NULL, NULL,
        NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `email_modelo`
--

CREATE TABLE `email_modelo`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) DEFAULT NULL,
    `assunto`                 varchar(255) NOT NULL,
    `texto`                   longtext     NOT NULL,
    `macro`                   longtext     NOT NULL,
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `email_modelo`
--

INSERT INTO `email_modelo` (`id`, `proprietario_id`, `assunto`, `texto`, `macro`, `log_cadastro_data`,
                            `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`,
                            `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'Senha de acesso ao sistema',
        '<p>Ol&aacute; <strong>{NOME}</strong>.</p>\r\n\r\n<p>Seguem seus dados de acesso ao sistema:</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p>Login/Endere&ccedil;o de e-mail: <strong>{EMAIL}</strong></p>\r\n\r\n<p>Senha: <strong>{SENHA}</strong></p>\r\n\r\n<p>Link para acesso: <strong>{URL}</strong></p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<p><strong>Aten&ccedil;&atilde;o!</strong></p>\r\n\r\n<p>Por quest&otilde;es de seguran&ccedil;a, &eacute; recomendado que voc&ecirc; altere sua senha ao acessar o sistema.</p>\r\n',
        '{NOME}\r\n{EMAIL}\r\n{SENHA}\r\n{URL}', '2018-01-18 10:03:52', 1, '2018-01-19 10:55:56', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `fio`
--

CREATE TABLE `fio`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = DYNAMIC;

--
-- Despejando dados para a tabela `fio`
--

INSERT INTO `fio` (`id`, `proprietario_id`, `nome`, `situacao`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                   `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'Fio 1', 'Ativo', '2020-05-12 16:57:53', 1, NULL, NULL, NULL, NULL),
       (2, 1, 'Fio 2', 'Ativo', '2020-05-12 16:57:57', 1, '2020-07-06 19:07:45', 2, '2020-07-06 19:07:45', 2),
       (3, 1, 'Fio 3', 'Ativo', '2020-06-19 16:06:13', 2, '2020-07-06 19:07:44', 2, '2020-07-06 19:07:44', 2),
       (4, 1, 'Fio 4', 'Ativo', '2020-07-06 19:07:43', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina`
--

CREATE TABLE `maquina`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) NOT NULL,
    `cliente_id`              int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `marca`                   varchar(255) NOT NULL,
    `modelo`                  varchar(255) DEFAULT NULL,
    `codigo`                  varchar(255) DEFAULT NULL,
    `diametro`                double       DEFAULT NULL,
    `ano` year(4) DEFAULT NULL,
    `alimentadores`           varchar(255) DEFAULT NULL,
    `operacao`                enum ('mono','dupla') NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL,
    `status_id`               int(11) NOT NULL,
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime     DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime     DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `maquina`
--

INSERT INTO `maquina` (`id`, `proprietario_id`, `cliente_id`, `nome`, `marca`, `modelo`, `codigo`, `diametro`, `ano`,
                       `alimentadores`, `operacao`, `situacao`, `status_id`, `log_cadastro_data`,
                       `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`,
                       `log_excluido_usuario_id`)
VALUES (1, 1, 1, 'Tear 01', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T128', 15, 1990, '40', 'mono', 'Ativo', 4,
        '2020-05-27 08:11:39', 1, '2020-08-02 20:08:34', 2, NULL, NULL),
       (2, 1, 1, 'Tear 02', 'Orizio', 'WO1 182.64N 002 ~ 004', '10T59', 20, 2020, '40', 'mono', 'Ativo', 2,
        '2020-06-25 20:06:21', 2, '2020-08-02 20:08:31', 2, NULL, NULL),
       (3, 1, 1, 'Tear 03', 'Orizio', 'WO5 127.31N 003 ~ 006', '10T06', 20, 2020, '40', 'dupla', 'Ativo', 2,
        '2020-06-25 20:06:23', 2, '2020-08-02 20:08:27', 2, NULL, NULL),
       (4, 1, 1, 'Tear 04', 'Orizio', 'WO2 116.42N 001 ~ 004', '10T37', 20, 2020, '40', 'dupla', 'Ativo', 2,
        '2020-06-25 20:06:24', 2, '2020-08-02 20:08:36', 2, NULL, NULL),
       (5, 1, 1, 'Tear 05', 'Orizio', 'WO7 104.93N 006 ~ 009', '10T62', 20, 2020, '40', 'dupla', 'Ativo', 1,
        '2020-06-25 20:06:25', 2, '2020-08-02 18:08:40', 2, NULL, NULL),
       (6, 1, 1, 'Tear 06', 'Orizio', 'WO6 125.17N 007 ~ 012', '10T79', 20, 2020, '40', 'dupla', 'Ativo', 1,
        '2020-06-25 20:06:26', 2, '2020-08-02 18:08:50', 2, NULL, NULL),
       (7, 1, 1, 'Tear 07', 'Orizio', 'WO9 183.95N 001 ~ 002', '10T183', 20, 2020, '40', 'dupla', 'Ativo', 1,
        '2020-06-25 20:06:27', 2, NULL, NULL, NULL, NULL),
       (8, 1, 1, 'Tear 08', 'Orizio', 'WO8 136.79N 010 ~ 013', '10T27', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:27', 2, NULL, NULL, NULL, NULL),
       (9, 1, 1, 'Tear 09', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T510', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:28', 2, NULL, NULL, NULL, NULL),
       (10, 1, 1, 'Tear 10', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T61', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:29', 2, NULL, NULL, NULL, NULL),
       (11, 1, 1, 'Tear 11', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T94', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:30', 2, NULL, NULL, NULL, NULL),
       (12, 1, 1, 'Tear 12', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T28', 20, 2020, '40', 'dupla', 'Ativo', 1,
        '2020-06-25 20:06:31', 2, NULL, NULL, NULL, NULL),
       (13, 1, 1, 'Tear 13', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T56', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:32', 2, NULL, NULL, NULL, NULL),
       (14, 1, 1, 'Tear 14', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T159', 20, 2020, '40', 'dupla', 'Ativo', 1,
        '2020-06-25 20:06:33', 2, NULL, NULL, NULL, NULL),
       (15, 1, 1, 'Tear 15', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T118', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:34', 2, NULL, NULL, NULL, NULL),
       (16, 1, 1, 'Tear 16', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T217', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:44', 2, '2020-06-25 20:06:58', 2, NULL, NULL),
       (17, 1, 1, 'Tear 17', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T274', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-06-25 20:06:45', 2, NULL, NULL, NULL, NULL),
       (18, 1, 1, 'Tear 18', 'Orizio', 'WO3 167.52N 001 ~ 003', '10T461', 20, 2020, '40', 'mono', 'Ativo', 1,
        '2020-07-06 19:07:36', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_instalacao`
--

CREATE TABLE `maquina_instalacao`
(
    `id`                      int(11) NOT NULL,
    `maquina_id`              int(11) NOT NULL,
    `agulheiro_id`            int(11) NOT NULL,
    `artigo_id`               int(11) NOT NULL,
    `fio_id`                  int(11) NOT NULL,
    `lote_agulha`             varchar(255) NOT NULL,
    `tensao_fio`              varchar(255) NOT NULL,
    `comprimento_ponto`       varchar(255) NOT NULL,
    `quantidade_instalada`    int(11) DEFAULT NULL,
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `maquina_instalacao`
--

INSERT INTO `maquina_instalacao` (`id`, `maquina_id`, `agulheiro_id`, `artigo_id`, `fio_id`, `lote_agulha`,
                                  `tensao_fio`, `comprimento_ponto`, `quantidade_instalada`, `log_cadastro_data`,
                                  `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`,
                                  `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 5, 2, 4, 'NTS832017', '3', '200 LFA', 270, '2020-08-02 20:08:37', 2, NULL, NULL, NULL,
        NULL),
       (2, 3, 6, 1, 4, '1', '4', '10', 6350, '2020-08-02 20:08:27', 2, NULL, NULL, NULL, NULL),
       (3, 2, 2, 1, 4, '7', '6', '7', 580, '2020-08-02 20:08:31', 2, NULL, NULL, NULL, NULL),
       (4, 4, 4, 1, 1, '1', '10', '1', 595, '2020-08-02 20:08:36', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_instalacao_rotina`
--

CREATE TABLE `maquina_instalacao_rotina`
(
    `id`                      int(11) NOT NULL,
    `maquina_instalacao_id`   int(11) NOT NULL,
    `volume_quebra`           int(11) DEFAULT NULL,
    `quantidade_produzida`    double   DEFAULT NULL,
    `velocidade`              int(11) DEFAULT NULL,
    `data_atualizacao`        date     NOT NULL,
    `log_cadastro_data`       datetime NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `maquina_instalacao_rotina`
--

INSERT INTO `maquina_instalacao_rotina` (`id`, `maquina_instalacao_id`, `volume_quebra`, `quantidade_produzida`,
                                         `velocidade`, `data_atualizacao`, `log_cadastro_data`,
                                         `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`,
                                         `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 235, 530.7, 30, '2020-08-05', '2020-08-02 20:08:28', 2, NULL, NULL, NULL, NULL),
       (2, 1, 135, 6400.5, 90, '2020-08-07', '2020-08-02 20:08:19', 2, NULL, NULL, NULL, NULL),
       (3, 2, NULL, NULL, NULL, '2020-08-07', '2020-08-02 20:08:27', 2, NULL, NULL, NULL, NULL),
       (4, 3, 210, 654.07, 25, '2020-08-04', '2020-08-04 18:08:59', 2, NULL, NULL, NULL, NULL),
       (5, 4, 140, 540.1, 20, '2020-08-05', '2020-08-04 18:08:42', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `maquina_status`
--

CREATE TABLE `maquina_status`
(
    `id`                      int(11) NOT NULL,
    `nome`                    varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    `log_cadastro_data`       datetime                                NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `maquina_status`
--

INSERT INTO `maquina_status` (`id`, `nome`, `log_cadastro_data`, `log_cadastro_usuario_id`, `log_alterado_data`,
                              `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 'AGUARDANDO INSTALAÇÃO', '2020-07-15 22:37:36', 2, NULL, NULL, NULL, NULL),
       (2, 'EM DIA', '2020-07-15 22:37:36', 2, NULL, NULL, NULL, NULL),
       (3, 'EM ATRASO', '2020-07-15 22:37:36', 2, NULL, NULL, NULL, NULL),
       (4, 'PARADA', '2020-07-15 22:37:36', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `menu`
--

CREATE TABLE `menu`
(
    `id`                int(11) NOT NULL,
    `menu_categoria_id` int(11) DEFAULT NULL,
    `nome`              varchar(255) NOT NULL,
    `URL`               varchar(255) DEFAULT NULL,
    `icone`             varchar(255) DEFAULT NULL,
    `ordem`             int(11) DEFAULT NULL,
    `w2o`               enum ('Sim','Não') NOT NULL DEFAULT 'Não'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `menu`
--

INSERT INTO `menu` (`id`, `menu_categoria_id`, `nome`, `URL`, `icone`, `ordem`, `w2o`)
VALUES (1, NULL, 'Configurações', NULL, 'la la-wrench', 10000, 'Não'),
       (2, 1, 'Modelo de e-mail', 'configuracao/modelo-email/inicio', NULL, 11000, 'Não'),
       (3, 4, 'Usuários', 'cadastro/usuario/inicio', NULL, 30100, 'Não'),
       (4, NULL, 'Cadastros', NULL, 'la la-plus', 30000, 'Não'),
       (5, 4, 'Artigos', 'cadastro/artigo/inicio', NULL, 30200, 'Não'),
       (6, 4, 'Fios', 'cadastro/fio/inicio', NULL, 30300, 'Não'),
       (7, NULL, 'Clientes', 'cliente/lista/inicio', 'la la-users', 40000, 'Não'),
       (8, NULL, 'Máquinas', 'maquina/lista/inicio', 'la la-cogs', 50000, 'Não'),
       (9, 4, 'Modelos de agulha', 'cadastro/modelo-agulha/inicio', NULL, 30400, 'Não');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modelo_agulha`
--

CREATE TABLE `modelo_agulha`
(
    `id`                      int(11) NOT NULL,
    `proprietario_id`         int(11) DEFAULT NULL,
    `nome`                    varchar(255) NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = DYNAMIC;

--
-- Despejando dados para a tabela `modelo_agulha`
--

INSERT INTO `modelo_agulha` (`id`, `proprietario_id`, `nome`, `situacao`, `log_cadastro_data`,
                             `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`,
                             `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'HOFASA 71.70 N001', 'Ativo', '2020-05-12 17:00:06', 1, NULL, NULL, NULL, NULL),
       (2, 1, 'RASCHEL 42.68 N001', 'Ativo', '2020-05-12 17:00:09', 1, NULL, NULL, NULL, NULL),
       (3, 1, 'HOFASA 82.25 N005', 'Ativo', '2020-07-10 01:07:31', 2, '2020-07-10 01:07:11', 2, '2020-07-10 01:07:30',
        2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

CREATE TABLE `proprietario`
(
    `id`                      int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `proprietario`
--

INSERT INTO `proprietario` (`id`, `nome`, `situacao`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                            `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`,
                            `log_excluido_usuario_id`)
VALUES (1, 'Neetex', 'Ativo', '2020-05-11 11:37:29', 1, NULL, NULL, NULL, NULL),
       (2, 'Demervaldo Batista da Silva', 'Ativo', '2020-06-19 14:06:41', 2, '2020-07-06 19:07:31', 2,
        '2020-07-06 19:07:31', 2),
       (3, 'Teste', 'Ativo', '2020-07-06 19:07:31', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo_usuario`
--

CREATE TABLE `tipo_usuario`
(
    `id`                      int(11) NOT NULL,
    `nome`                    varchar(255) NOT NULL,
    `ordem`                   int(11) NOT NULL,
    `situacao`                enum ('Ativo','Inativo') NOT NULL DEFAULT 'Ativo',
    `log_cadastro_data`       datetime     NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `nome`, `ordem`, `situacao`, `log_cadastro_data`, `log_cadastro_usuario_id`,
                            `log_alterado_data`, `log_alterado_usuario_id`, `log_excluido_data`,
                            `log_excluido_usuario_id`)
VALUES (1, 'Administrador', 1, 'Ativo', '2020-05-11 10:17:51', 1, NULL, NULL, NULL, NULL),
       (2, 'Técnico', 10, 'Ativo', '2020-05-11 10:17:51', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario`
(
    `id`                              int(11) NOT NULL,
    `tipo_usuario_id`                 int(11) NOT NULL,
    `email`                           varchar(255) NOT NULL,
    `senha`                           varchar(255) NOT NULL,
    `nome`                            varchar(255) NOT NULL,
    `foto`                            longtext,
    `credenciamento_dispositivo`      varchar(255) DEFAULT NULL,
    `credenciamento_hash_notificacao` varchar(255) DEFAULT NULL,
    `credenciamento_realizado_em`     datetime     DEFAULT NULL,
    `topo`                            enum ('Fixo','Flutuante') NOT NULL DEFAULT 'Fixo',
    `menu_posicao`                    enum ('Vertical','Horizontal') NOT NULL DEFAULT 'Horizontal',
    `menu_tipo`                       enum ('Icones','Texto') NOT NULL DEFAULT 'Icones',
    `modo`                            enum ('Claro','Noturno') NOT NULL DEFAULT 'Claro',
    `usuario_w2o`                     enum ('Sim','Não') NOT NULL DEFAULT 'Não',
    `log_ultimo_acesso_data`          datetime     DEFAULT NULL,
    `log_ultimo_acesso_ip`            varchar(50)  DEFAULT NULL,
    `log_quantidade_acesso`           int(11) DEFAULT NULL,
    `log_cadastro_data`               datetime     NOT NULL,
    `log_cadastro_usuario_id`         int(11) NOT NULL,
    `log_alterado_data`               datetime     DEFAULT NULL,
    `log_alterado_usuario_id`         int(11) DEFAULT NULL,
    `log_excluido_data`               datetime     DEFAULT NULL,
    `log_excluido_usuario_id`         int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`id`, `tipo_usuario_id`, `email`, `senha`, `nome`, `foto`, `credenciamento_dispositivo`,
                       `credenciamento_hash_notificacao`, `credenciamento_realizado_em`, `topo`, `menu_posicao`,
                       `menu_tipo`, `modo`, `usuario_w2o`, `log_ultimo_acesso_data`, `log_ultimo_acesso_ip`,
                       `log_quantidade_acesso`, `log_cadastro_data`, `log_cadastro_usuario_id`, `log_alterado_data`,
                       `log_alterado_usuario_id`, `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 'suporte@w2o.com.br', '8d4e4e087349d663a024979e41f3dfe5', 'Suporte W2O', 'default.png', NULL, NULL, NULL,
        'Fixo', 'Vertical', 'Texto', 'Claro', 'Sim', NULL, NULL, NULL, '2018-01-18 09:51:57', 1, '2019-11-19 11:19:19',
        1, NULL, NULL),
       (2, 1, 'tiago.paza@w2o.com.br', 'e99a18c428cb38d5f260853678922e03', 'Tiago Paza', 'default.png', 'x86_64',
        'dWrjRCpME0emiH6XTELdWg:APA91bFXdXA7bQfaJdDPoU0olbZasLzZmFk4nAlDEm-5RhG53z01iMgXcn9-eFMPz5p0e1QMIs-poXMg-7mi1kvATQXQeI9YTZRYUcHBscZ30X0lDTfwCbvFRoSF6lpUtFbzyXIequ-6',
        '2020-08-07 09:26:13', 'Flutuante', 'Horizontal', 'Icones', 'Noturno', 'Não', NULL, NULL, NULL,
        '2020-06-18 00:00:00', 1, '2020-08-07 12:08:13', 2, NULL, NULL),
       (3, 1, 'teste@w2o.com.br', '123456', 'Teste', NULL, NULL, NULL, NULL, 'Fixo', 'Horizontal', 'Icones', 'Claro',
        'Sim', NULL, NULL, NULL, '2020-08-05 12:08:33', 2, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_acesso`
--

CREATE TABLE `usuario_acesso`
(
    `id`                      int(11) NOT NULL,
    `usuario_id`              int(11) NOT NULL,
    `ip`                      varchar(50) NOT NULL,
    `log_cadastro_data`       datetime    NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_menu`
--

CREATE TABLE `usuario_menu`
(
    `id`         int(11) NOT NULL,
    `usuario_id` int(11) DEFAULT NULL,
    `menu_id`    int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario_proprietario`
--

CREATE TABLE `usuario_proprietario`
(
    `id`                      int(11) NOT NULL,
    `usuario_id`              int(11) NOT NULL,
    `proprietario_id`         int(11) NOT NULL,
    `log_cadastro_data`       datetime NOT NULL,
    `log_cadastro_usuario_id` int(11) NOT NULL,
    `log_alterado_data`       datetime DEFAULT NULL,
    `log_alterado_usuario_id` int(11) DEFAULT NULL,
    `log_excluido_data`       datetime DEFAULT NULL,
    `log_excluido_usuario_id` int(11) DEFAULT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuario_proprietario`
--

INSERT INTO `usuario_proprietario` (`id`, `usuario_id`, `proprietario_id`, `log_cadastro_data`,
                                    `log_cadastro_usuario_id`, `log_alterado_data`, `log_alterado_usuario_id`,
                                    `log_excluido_data`, `log_excluido_usuario_id`)
VALUES (1, 1, 1, '2020-05-13 09:44:35', 1, NULL, NULL, NULL, NULL),
       (2, 2, 1, '2020-08-05 08:26:26', 1, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `versao`
--

CREATE TABLE `versao`
(
    `id`    int(11) NOT NULL,
    `data`  date     NOT NULL,
    `texto` longtext NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_unicode_ci;

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `agulheiro`
--
ALTER TABLE `agulheiro`
    ADD PRIMARY KEY (`id`),
    ADD KEY `status_id` (`status_id`);

--
-- Índices de tabela `agulheiro_agulhas`
--
ALTER TABLE `agulheiro_agulhas`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_maquina_agulheiro_agulha_modelo_agulha` (`modelo_agulha_id`),
    ADD KEY `agulheiro_id` (`agulheiro_id`);

--
-- Índices de tabela `agulheiro_status`
--
ALTER TABLE `agulheiro_status`
    ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `artigo`
--
ALTER TABLE `artigo`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_artigo_proprietario` (`proprietario_id`);

--
-- Índices de tabela `cliente`
--
ALTER TABLE `cliente`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_cliente_proprietario` (`proprietario_id`);

--
-- Índices de tabela `email_modelo`
--
ALTER TABLE `email_modelo`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_email_modelo_proprietario` (`proprietario_id`);

--
-- Índices de tabela `fio`
--
ALTER TABLE `fio`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_fio_proprietario` (`proprietario_id`);

--
-- Índices de tabela `maquina`
--
ALTER TABLE `maquina`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_maquina_proprietario` (`proprietario_id`),
    ADD KEY `FK_maquina_cliente` (`cliente_id`),
    ADD KEY `status_id` (`status_id`);

--
-- Índices de tabela `maquina_instalacao`
--
ALTER TABLE `maquina_instalacao`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_maquina_instalacao_maquina` (`maquina_id`),
    ADD KEY `agulheiro_id` (`agulheiro_id`) USING BTREE,
    ADD KEY `artigo_id` (`artigo_id`),
    ADD KEY `fio_id` (`fio_id`);

--
-- Índices de tabela `maquina_instalacao_rotina`
--
ALTER TABLE `maquina_instalacao_rotina`
    ADD PRIMARY KEY (`id`),
    ADD KEY `maquina_instalacao_id` (`maquina_instalacao_id`);

--
-- Índices de tabela `maquina_status`
--
ALTER TABLE `maquina_status`
    ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `menu`
--
ALTER TABLE `menu`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_menu_menu` (`menu_categoria_id`);

--
-- Índices de tabela `modelo_agulha`
--
ALTER TABLE `modelo_agulha`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_modelo_agulha_proprietario` (`proprietario_id`);

--
-- Índices de tabela `proprietario`
--
ALTER TABLE `proprietario`
    ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
    ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `UK_usuario_credenciamento_hash_notificacao` (`credenciamento_hash_notificacao`),
    ADD KEY `FK_usuario_tipo_usuario` (`tipo_usuario_id`);

--
-- Índices de tabela `usuario_acesso`
--
ALTER TABLE `usuario_acesso`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_usuario_acesso_usuario` (`usuario_id`);

--
-- Índices de tabela `usuario_menu`
--
ALTER TABLE `usuario_menu`
    ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `usuario_proprietario`
--
ALTER TABLE `usuario_proprietario`
    ADD PRIMARY KEY (`id`),
    ADD KEY `FK_usuario_proprietario_usuario` (`usuario_id`),
    ADD KEY `FK_usuario_proprietario_proprietario` (`proprietario_id`);

--
-- Índices de tabela `versao`
--
ALTER TABLE `versao`
    ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `agulheiro`
--
ALTER TABLE `agulheiro`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de tabela `agulheiro_agulhas`
--
ALTER TABLE `agulheiro_agulhas`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 7;

--
-- AUTO_INCREMENT de tabela `agulheiro_status`
--
ALTER TABLE `agulheiro_status`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de tabela `artigo`
--
ALTER TABLE `artigo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de tabela `cliente`
--
ALTER TABLE `cliente`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de tabela `email_modelo`
--
ALTER TABLE `email_modelo`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 2;

--
-- AUTO_INCREMENT de tabela `fio`
--
ALTER TABLE `fio`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de tabela `maquina`
--
ALTER TABLE `maquina`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 20;

--
-- AUTO_INCREMENT de tabela `maquina_instalacao`
--
ALTER TABLE `maquina_instalacao`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de tabela `maquina_instalacao_rotina`
--
ALTER TABLE `maquina_instalacao_rotina`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT de tabela `maquina_status`
--
ALTER TABLE `maquina_status`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 5;

--
-- AUTO_INCREMENT de tabela `menu`
--
ALTER TABLE `menu`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 10;

-- --
-- -- AUTO_INCREMENT de tabela `migrations`
-- --
-- ALTER TABLE `migrations`
--     MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
--     AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT de tabela `modelo_agulha`
--
ALTER TABLE `modelo_agulha`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de tabela `proprietario`
--
ALTER TABLE `proprietario`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de tabela `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 4;

--
-- AUTO_INCREMENT de tabela `usuario_acesso`
--
ALTER TABLE `usuario_acesso`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_menu`
--
ALTER TABLE `usuario_menu`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuario_proprietario`
--
ALTER TABLE `usuario_proprietario`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT de tabela `versao`
--
ALTER TABLE `versao`
    MODIFY `id` int (11) NOT NULL AUTO_INCREMENT;

--
-- Restrições para dumps de tabelas
--

--
-- Restrições para tabelas `agulheiro`
--
ALTER TABLE `agulheiro`
    ADD CONSTRAINT `agulheiro_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `agulheiro_status` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `agulheiro_agulhas`
--
ALTER TABLE `agulheiro_agulhas`
    ADD CONSTRAINT `FK_cliente_agulheiro_agulha_modelo_agulha` FOREIGN KEY (`modelo_agulha_id`) REFERENCES `modelo_agulha` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `agulheiro_agulhas_ibfk_1` FOREIGN KEY (`agulheiro_id`) REFERENCES `agulheiro` (`id`) ON
DELETE
RESTRICT ON
UPDATE RESTRICT;

--
-- Restrições para tabelas `artigo`
--
ALTER TABLE `artigo`
    ADD CONSTRAINT `FK_artigo_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `cliente`
--
ALTER TABLE `cliente`
    ADD CONSTRAINT `FK_cliente_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `email_modelo`
--
ALTER TABLE `email_modelo`
    ADD CONSTRAINT `FK_email_modelo_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `fio`
--
ALTER TABLE `fio`
    ADD CONSTRAINT `FK_fio_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `maquina`
--
ALTER TABLE `maquina`
    ADD CONSTRAINT `FK_maquina_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `cliente` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_maquina_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON
DELETE
CASCADE ON
UPDATE CASCADE,
    ADD CONSTRAINT `maquina_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `maquina_status` (`id`)
ON
DELETE
RESTRICT ON
UPDATE RESTRICT;

--
-- Restrições para tabelas `maquina_instalacao`
--
ALTER TABLE `maquina_instalacao`
    ADD CONSTRAINT `FK_maquina_instalacao_maquina` FOREIGN KEY (`maquina_id`) REFERENCES `maquina` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `maquina_instalacao_ibfk_1` FOREIGN KEY (`agulheiro_id`) REFERENCES `agulheiro` (`id`) ON
DELETE
RESTRICT ON
UPDATE RESTRICT,
    ADD CONSTRAINT `maquina_instalacao_ibfk_2` FOREIGN KEY (`artigo_id`) REFERENCES `artigo` (`id`)
ON
DELETE
RESTRICT ON
UPDATE RESTRICT,
    ADD CONSTRAINT `maquina_instalacao_ibfk_3` FOREIGN KEY (`fio_id`) REFERENCES `fio` (`id`)
ON
DELETE
RESTRICT ON
UPDATE RESTRICT;

--
-- Restrições para tabelas `maquina_instalacao_rotina`
--
ALTER TABLE `maquina_instalacao_rotina`
    ADD CONSTRAINT `maquina_instalacao_rotina_ibfk_1` FOREIGN KEY (`maquina_instalacao_id`) REFERENCES `maquina_instalacao` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Restrições para tabelas `menu`
--
ALTER TABLE `menu`
    ADD CONSTRAINT `FK_menu_menu` FOREIGN KEY (`menu_categoria_id`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `modelo_agulha`
--
ALTER TABLE `modelo_agulha`
    ADD CONSTRAINT `FK_modelo_agulha_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario`
--
ALTER TABLE `usuario`
    ADD CONSTRAINT `FK_usuario_tipo_usuario` FOREIGN KEY (`tipo_usuario_id`) REFERENCES `tipo_usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_acesso`
--
ALTER TABLE `usuario_acesso`
    ADD CONSTRAINT `FK_usuario_acesso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `usuario_proprietario`
--
ALTER TABLE `usuario_proprietario`
    ADD CONSTRAINT `FK_usuario_proprietario_proprietario` FOREIGN KEY (`proprietario_id`) REFERENCES `proprietario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `FK_usuario_proprietario_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON
DELETE
CASCADE ON
UPDATE CASCADE;
COMMIT;


