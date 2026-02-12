-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 12-Fev-2026 às 21:27
-- Versão do servidor: 10.4.32-MariaDB
-- versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `pax`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `camaras`
--

CREATE TABLE `camaras` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `location` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `camaras`
--

INSERT INTO `camaras` (`id`, `name`, `location`, `created_at`, `updated_at`) VALUES
(1, 'Câmara Sala', 'Sala', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(2, 'Câmara Cozinha', 'Cozinha', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(3, 'Câmara Quarto', 'Quarto', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(4, 'Câmara Corredor', 'Corredor', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(5, 'Câmara Porta Principal', 'Entrada', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(6, 'Câmara Pátio Exterior', 'Exterior', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(7, 'Câmara Estacionamento', 'Estacionamento', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(8, 'Câmara Armazém', 'Armazém', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(9, 'Câmara Receção', 'Receção', '2026-02-12 08:51:10', '2026-02-12 08:51:10'),
(10, 'Câmara Sala Reuniões', 'Sala de Reuniões', '2026-02-12 08:51:10', '2026-02-12 08:51:10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `contas_utilizador`
--

CREATE TABLE `contas_utilizador` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `contas_utilizador`
--

INSERT INTO `contas_utilizador` (`user_id`, `username`, `email`, `password_hash`, `status`, `created_at`, `updated_at`) VALUES
(1, 'OsmarMRG', 'osmar@pax.com', '$2y$12$rQs9vChW4Xmvc573hzkVOeHD9FNID3VzK.kQaM01fh8BYyALMi93.', 'active', '2026-02-12 08:26:32', '2026-02-12 08:39:25'),
(2, 'DiogoS', 'diogo@pax.com', '$2y$12$E9ZXmZgSHuZAYZdqK3wrH.ynKM4bNzT6VVCFNgsxfmsZzf3mSOekC', 'active', '2026-02-12 17:35:16', '2026-02-12 17:35:16');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user_camaras`
--

CREATE TABLE `user_camaras` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `camera_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Extraindo dados da tabela `user_camaras`
--

INSERT INTO `user_camaras` (`user_id`, `camera_id`, `created_at`, `updated_at`) VALUES
(1, 6, '2026-02-12 17:52:33', '2026-02-12 17:52:33'),
(2, 2, '2026-02-12 17:37:42', '2026-02-12 17:37:42'),
(2, 5, '2026-02-12 17:37:42', '2026-02-12 17:37:42'),
(2, 7, '2026-02-12 17:37:42', '2026-02-12 17:37:42'),
(2, 9, '2026-02-12 17:37:42', '2026-02-12 17:37:42');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `camaras`
--
ALTER TABLE `camaras`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `contas_utilizador`
--
ALTER TABLE `contas_utilizador`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD KEY `idx_tokenable` (`tokenable_type`,`tokenable_id`);

--
-- Índices para tabela `user_camaras`
--
ALTER TABLE `user_camaras`
  ADD PRIMARY KEY (`user_id`,`camera_id`),
  ADD KEY `camera_id` (`camera_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `camaras`
--
ALTER TABLE `camaras`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `contas_utilizador`
--
ALTER TABLE `contas_utilizador`
  MODIFY `user_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `user_camaras`
--
ALTER TABLE `user_camaras`
  ADD CONSTRAINT `user_camaras_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `contas_utilizador` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_camaras_ibfk_2` FOREIGN KEY (`camera_id`) REFERENCES `camaras` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
