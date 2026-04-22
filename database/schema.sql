-- ============================================================
-- Schema completo — Sistema de Descontaminação
-- Gerado em: 2026-04-22
-- Banco de dados: MySQL / MariaDB
-- ============================================================

SET FOREIGN_KEY_CHECKS = 0;
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- ------------------------------------------------------------
-- users
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`              VARCHAR(255)    NOT NULL,
    `email`             VARCHAR(255)    NOT NULL,
    `email_verified_at` TIMESTAMP       NULL DEFAULT NULL,
    `password`          VARCHAR(255)    NOT NULL,
    `is_admin`          TINYINT(1)      NOT NULL DEFAULT 0,
    `remember_token`    VARCHAR(100)    NULL DEFAULT NULL,
    `created_at`        TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`        TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- password_reset_tokens
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
    `email`      VARCHAR(255) NOT NULL,
    `token`      VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP    NULL DEFAULT NULL,
    PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- sessions
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions` (
    `id`            VARCHAR(255) NOT NULL,
    `user_id`       BIGINT UNSIGNED NULL DEFAULT NULL,
    `ip_address`    VARCHAR(45)  NULL DEFAULT NULL,
    `user_agent`    TEXT         NULL,
    `payload`       LONGTEXT     NOT NULL,
    `last_activity` INT          NOT NULL,
    PRIMARY KEY (`id`),
    KEY `sessions_user_id_index` (`user_id`),
    KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- clientes
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clientes` (
    `id`               BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `tipo_pessoa`      VARCHAR(2)      NOT NULL,
    `nome_razao_social` VARCHAR(255)   NOT NULL,
    `cpf_cnpj`         VARCHAR(14)     NOT NULL,
    `endereco`         VARCHAR(255)    NULL DEFAULT NULL,
    `cidade`           VARCHAR(255)    NULL DEFAULT NULL,
    `estado`           VARCHAR(2)      NULL DEFAULT NULL,
    `telefone`         VARCHAR(20)     NULL DEFAULT NULL,
    `email`            VARCHAR(255)    NULL DEFAULT NULL,
    `ativo`            TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`       TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`       TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `clientes_cpf_cnpj_unique` (`cpf_cnpj`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- produtos_transportados
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `produtos_transportados` (
    `id`          BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome`        VARCHAR(255)    NOT NULL,
    `classe_risco` VARCHAR(255)   NULL DEFAULT NULL,
    `numero_onu`  VARCHAR(255)    NULL DEFAULT NULL,
    `ativo`       TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`  TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`  TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `produtos_transportados_nome_unique` (`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- veiculos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `veiculos` (
    `id`                   BIGINT UNSIGNED       NOT NULL AUTO_INCREMENT,
    `placa`                VARCHAR(10)           NOT NULL,
    `modelo`               VARCHAR(255)          NOT NULL,
    `marca`                VARCHAR(255)          NOT NULL,
    `ano`                  INT                   NULL DEFAULT NULL,
    `tipo_veiculo`         VARCHAR(255)          NULL DEFAULT NULL,
    `numero_compartimentos` SMALLINT UNSIGNED    NOT NULL DEFAULT 1,
    `numero_equipamento`   VARCHAR(255)          NULL DEFAULT NULL,
    `proprietario_id`      BIGINT UNSIGNED       NULL DEFAULT NULL,
    `ativo`                TINYINT(1)            NOT NULL DEFAULT 1,
    `created_at`           TIMESTAMP             NULL DEFAULT NULL,
    `updated_at`           TIMESTAMP             NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `veiculos_placa_unique` (`placa`),
    KEY `veiculos_proprietario_id_foreign` (`proprietario_id`),
    CONSTRAINT `veiculos_proprietario_id_foreign`
        FOREIGN KEY (`proprietario_id`) REFERENCES `clientes` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- veiculo_compartimentos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `veiculo_compartimentos` (
    `id`                BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `veiculo_id`        BIGINT UNSIGNED  NOT NULL,
    `numero`            INT UNSIGNED     NOT NULL,
    `capacidade_litros` DECIMAL(12,2)   NOT NULL,
    `produto_atual_id`  BIGINT UNSIGNED  NULL DEFAULT NULL,
    `created_at`        TIMESTAMP        NULL DEFAULT NULL,
    `updated_at`        TIMESTAMP        NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `veiculo_compartimentos_veiculo_id_numero_unique` (`veiculo_id`, `numero`),
    KEY `veiculo_compartimentos_produto_atual_id_foreign` (`produto_atual_id`),
    CONSTRAINT `veiculo_compartimentos_veiculo_id_foreign`
        FOREIGN KEY (`veiculo_id`) REFERENCES `veiculos` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `veiculo_compartimentos_produto_atual_id_foreign`
        FOREIGN KEY (`produto_atual_id`) REFERENCES `produtos_transportados` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- equipamentos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `equipamentos` (
    `id`         BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome`       VARCHAR(255)    NOT NULL,
    `tipo`       VARCHAR(20)     NOT NULL,
    `descricao`  TEXT            NULL DEFAULT NULL,
    `ativo`      TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP       NULL DEFAULT NULL,
    `updated_at` TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- equipamentos_medicao
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `equipamentos_medicao` (
    `id`               BIGINT UNSIGNED                              NOT NULL AUTO_INCREMENT,
    `tipo`             ENUM('detector','explosimetro','oximetro')   NOT NULL,
    `numero_serie`     VARCHAR(255)                                 NOT NULL,
    `data_calibracao`  DATE                                         NULL DEFAULT NULL,
    `observacao`       TEXT                                         NULL DEFAULT NULL,
    `ativo`            TINYINT(1)                                   NOT NULL DEFAULT 1,
    `created_at`       TIMESTAMP                                    NULL DEFAULT NULL,
    `updated_at`       TIMESTAMP                                    NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `equipamentos_medicao_numero_serie_unique` (`numero_serie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- user_profiles
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_profiles` (
    `id`                    BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`               BIGINT UNSIGNED NOT NULL,
    `cargo`                 VARCHAR(255)    NULL DEFAULT NULL,
    `registro_profissional` VARCHAR(255)    NULL DEFAULT NULL,
    `telefone`              VARCHAR(20)     NULL DEFAULT NULL,
    `assinatura_digital`    TEXT            NULL DEFAULT NULL,
    `ativo`                 TINYINT(1)      NOT NULL DEFAULT 1,
    `created_at`            TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`            TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `user_profiles_user_id_unique` (`user_id`),
    CONSTRAINT `user_profiles_user_id_foreign`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_descontaminacoes
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_descontaminacoes` (
    `id`                     BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `numero_relatorio`       BIGINT UNSIGNED NOT NULL,
    `status`                 VARCHAR(20)     NOT NULL DEFAULT 'RASCUNHO',
    `data_servico`           DATE            NOT NULL,
    `responsavel_tecnico_id` BIGINT UNSIGNED NOT NULL,
    `processo`               VARCHAR(20)     NOT NULL,
    `observacoes`            TEXT            NULL DEFAULT NULL,
    `lacre_entrada`          VARCHAR(255)    NULL DEFAULT NULL,
    `lacre_saida`            VARCHAR(255)    NULL DEFAULT NULL,
    `criado_por_id`          BIGINT UNSIGNED NULL DEFAULT NULL,
    `emitido_em`             TIMESTAMP       NULL DEFAULT NULL,
    `cancelado_em`           TIMESTAMP       NULL DEFAULT NULL,
    `motivo_cancelamento`    TEXT            NULL DEFAULT NULL,
    `created_at`             TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`             TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relatorio_descontaminacoes_numero_relatorio_unique` (`numero_relatorio`),
    KEY `relatorio_descontaminacoes_responsavel_tecnico_id_foreign` (`responsavel_tecnico_id`),
    KEY `relatorio_descontaminacoes_criado_por_id_foreign` (`criado_por_id`),
    CONSTRAINT `relatorio_descontaminacoes_responsavel_tecnico_id_foreign`
        FOREIGN KEY (`responsavel_tecnico_id`) REFERENCES `users` (`id`)
        ON DELETE RESTRICT,
    CONSTRAINT `relatorio_descontaminacoes_criado_por_id_foreign`
        FOREIGN KEY (`criado_por_id`) REFERENCES `users` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_cliente_snapshots
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_cliente_snapshots` (
    `id`                BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `relatorio_id`      BIGINT UNSIGNED NOT NULL,
    `cliente_origem_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `tipo_pessoa`       VARCHAR(2)      NOT NULL,
    `nome_razao_social` VARCHAR(255)    NOT NULL,
    `cpf_cnpj`          VARCHAR(14)     NOT NULL,
    `endereco`          VARCHAR(255)    NULL DEFAULT NULL,
    `cidade`            VARCHAR(255)    NULL DEFAULT NULL,
    `estado`            VARCHAR(2)      NULL DEFAULT NULL,
    `telefone`          VARCHAR(20)     NULL DEFAULT NULL,
    `email`             VARCHAR(255)    NULL DEFAULT NULL,
    `created_at`        TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`        TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relatorio_cliente_snapshots_relatorio_id_unique` (`relatorio_id`),
    KEY `relatorio_cliente_snapshots_cliente_origem_id_foreign` (`cliente_origem_id`),
    CONSTRAINT `relatorio_cliente_snapshots_relatorio_id_foreign`
        FOREIGN KEY (`relatorio_id`) REFERENCES `relatorio_descontaminacoes` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `relatorio_cliente_snapshots_cliente_origem_id_foreign`
        FOREIGN KEY (`cliente_origem_id`) REFERENCES `clientes` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_veiculo_snapshots
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_veiculo_snapshots` (
    `id`                 BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `relatorio_id`       BIGINT UNSIGNED NOT NULL,
    `veiculo_origem_id`  BIGINT UNSIGNED NULL DEFAULT NULL,
    `placa`              VARCHAR(10)     NOT NULL,
    `modelo`             VARCHAR(255)    NOT NULL,
    `marca`              VARCHAR(255)    NOT NULL,
    `ano`                INT             NULL DEFAULT NULL,
    `tipo_veiculo`       VARCHAR(255)    NULL DEFAULT NULL,
    `numero_equipamento` VARCHAR(255)    NULL DEFAULT NULL,
    `created_at`         TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`         TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relatorio_veiculo_snapshots_relatorio_id_unique` (`relatorio_id`),
    KEY `relatorio_veiculo_snapshots_veiculo_origem_id_foreign` (`veiculo_origem_id`),
    CONSTRAINT `relatorio_veiculo_snapshots_relatorio_id_foreign`
        FOREIGN KEY (`relatorio_id`) REFERENCES `relatorio_descontaminacoes` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `relatorio_veiculo_snapshots_veiculo_origem_id_foreign`
        FOREIGN KEY (`veiculo_origem_id`) REFERENCES `veiculos` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_finalidades
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_finalidades` (
    `id`                  BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `relatorio_id`        BIGINT UNSIGNED NOT NULL,
    `finalidade`          VARCHAR(30)     NOT NULL,
    `descricao_outros`    VARCHAR(255)    NULL DEFAULT NULL,
    `created_at`          TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`          TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relatorio_finalidades_relatorio_id_finalidade_unique` (`relatorio_id`, `finalidade`),
    CONSTRAINT `relatorio_finalidades_relatorio_id_foreign`
        FOREIGN KEY (`relatorio_id`) REFERENCES `relatorio_descontaminacoes` (`id`)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_compartimentos
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_compartimentos` (
    `id`                     BIGINT UNSIGNED  NOT NULL AUTO_INCREMENT,
    `relatorio_id`           BIGINT UNSIGNED  NOT NULL,
    `compartimento_origem_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `numero`                 INT UNSIGNED     NOT NULL,
    `capacidade_litros`      DECIMAL(12,2)    NULL DEFAULT NULL,
    `produto_anterior_nome`  VARCHAR(255)     NULL DEFAULT NULL,
    `numero_onu`             VARCHAR(50)      NULL DEFAULT NULL,
    `classe_risco`           VARCHAR(100)     NULL DEFAULT NULL,
    `pressao_vapor`          DECIMAL(10,4)    NULL DEFAULT NULL,
    `tempo_minutos`          INT UNSIGNED     NULL DEFAULT NULL,
    `massa_vapor`            DECIMAL(14,4)    NULL DEFAULT NULL,
    `volume_ar`              DECIMAL(14,4)    NULL DEFAULT NULL,
    `neutralizante`          VARCHAR(255)     NULL DEFAULT NULL,
    `lacre_entrada_numero`   VARCHAR(255)     NULL DEFAULT NULL,
    `lacre_saida_numero`     VARCHAR(255)     NULL DEFAULT NULL,
    `observacao`             TEXT             NULL DEFAULT NULL,
    `created_at`             TIMESTAMP        NULL DEFAULT NULL,
    `updated_at`             TIMESTAMP        NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `relatorio_compartimentos_relatorio_id_numero_unique` (`relatorio_id`, `numero`),
    KEY `relatorio_compartimentos_compartimento_origem_id_foreign` (`compartimento_origem_id`),
    CONSTRAINT `relatorio_compartimentos_relatorio_id_foreign`
        FOREIGN KEY (`relatorio_id`) REFERENCES `relatorio_descontaminacoes` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `relatorio_compartimentos_compartimento_origem_id_foreign`
        FOREIGN KEY (`compartimento_origem_id`) REFERENCES `veiculo_compartimentos` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- relatorio_equipamento_utilizados
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `relatorio_equipamento_utilizados` (
    `id`                   BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    `relatorio_id`         BIGINT UNSIGNED NOT NULL,
    `equipamento_origem_id` BIGINT UNSIGNED NULL DEFAULT NULL,
    `nome_snapshot`        VARCHAR(255)    NOT NULL,
    `tipo_snapshot`        VARCHAR(20)     NOT NULL,
    `quantidade`           INT UNSIGNED    NOT NULL DEFAULT 1,
    `numero_serie`         VARCHAR(255)    NULL DEFAULT NULL,
    `observacao`           TEXT            NULL DEFAULT NULL,
    `created_at`           TIMESTAMP       NULL DEFAULT NULL,
    `updated_at`           TIMESTAMP       NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `relatorio_equipamento_utilizados_relatorio_id_foreign` (`relatorio_id`),
    KEY `relatorio_equipamento_utilizados_equipamento_origem_id_foreign` (`equipamento_origem_id`),
    CONSTRAINT `relatorio_equipamento_utilizados_relatorio_id_foreign`
        FOREIGN KEY (`relatorio_id`) REFERENCES `relatorio_descontaminacoes` (`id`)
        ON DELETE CASCADE,
    CONSTRAINT `relatorio_equipamento_utilizados_equipamento_origem_id_foreign`
        FOREIGN KEY (`equipamento_origem_id`) REFERENCES `equipamentos` (`id`)
        ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- migrations (tabela de controle do Laravel)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
    `id`        INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `migration` VARCHAR(255) NOT NULL,
    `batch`     INT          NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('0001_01_01_000000_create_users_table', 1),
('2024_01_01_000001_create_clientes_table', 1),
('2024_01_01_000002_create_produtos_transportados_table', 1),
('2024_01_01_000003_create_veiculos_table', 1),
('2024_01_01_000004_create_veiculo_compartimentos_table', 1),
('2024_01_01_000005_create_equipamentos_table', 1),
('2024_01_01_000006_create_user_profiles_table', 1),
('2024_01_01_000007_create_relatorio_descontaminacoes_table', 1),
('2024_01_01_000008_create_relatorio_cliente_snapshots_table', 1),
('2024_01_01_000009_create_relatorio_veiculo_snapshots_table', 1),
('2024_01_01_000010_create_relatorio_finalidades_table', 1),
('2024_01_01_000011_create_relatorio_compartimentos_table', 1),
('2024_01_01_000012_create_relatorio_equipamento_utilizados_table', 1),
('2024_01_01_100001_add_numero_equipamento_to_veiculos_table', 1),
('2024_01_01_100002_add_numero_equipamento_to_relatorio_veiculo_snapshots_table', 1),
('2024_01_01_100003_create_equipamentos_medicao_table', 1),
('2024_01_01_200001_add_is_admin_to_users_table', 1),
('2024_01_02_000001_alter_numero_relatorio_to_integer', 1),
('2026_04_13_000001_add_numero_compartimentos_to_veiculos_table', 1),
('2026_04_13_000002_add_srd_fields_to_relatorio_compartimentos_table', 1);

SET FOREIGN_KEY_CHECKS = 1;
