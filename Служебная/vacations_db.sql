-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Май 16 2020 г., 01:37
-- Версия сервера: 8.0.12
-- Версия PHP: 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vacations_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'board'),
(2, 'worker');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `tab_nom` varchar(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `auth_key`, `surname`, `name`, `patronymic`, `tab_nom`, `role_id`) VALUES
(1, 'user1', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', 'lMsWzuP_BlgjslYedawtYCz5Zp7QMLtR', 'Иванов', 'Иван', 'Иванович', '12345678912', 1),
(2, 'user2', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', 'XkhVV1KuP2guTjM9fXpPEwXkjdWn-_Df', 'Петров', 'Петр', 'Петрович', '12345678913', 2),
(3, 'user3', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Сидорова', 'Елена', 'Семеновна', '12345678914', 2),
(4, 'user4', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Сергеев', 'Сергей', 'Сергеевич', '12345678915', 2),
(5, 'user5', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Антонова', 'Татьяна', 'Алексеевна', '12345678916', 2),
(6, 'user6', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Грибов', 'Сергей', 'Михайлович', '12345678917', 2),
(7, 'user7', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Соколова', 'Анна', 'Викторовна', '12345678918', 2),
(8, 'user8', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Николаев', 'Иван', 'Викторович', '12345678919', 2),
(9, 'user9', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Котов', 'Глеб', 'Валерьевич', '12345678921', 2),
(10, 'user10', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Тепличная', 'Оксана', 'Михайловна', '12345678922', 2),
(11, 'user11', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Смирнова', 'Татьяна', 'Григорьевна', '12345678923', 2),
(12, 'user12', '$2y$13$RDLbYv0GfMlq7niRe1Mq..TC/Zl5AdveeG/BoQmlz71OSn62wpTD6', NULL, 'Макаров', 'Петр', 'Иванович', '12345678924', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `vacations`
--

CREATE TABLE `vacations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `update_user_id` int(11) DEFAULT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `confirmation` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `vacations`
--

INSERT INTO `vacations` (`id`, `user_id`, `created_at`, `updated_at`, `update_user_id`, `start_date`, `end_date`, `confirmation`) VALUES
(1, 2, '2020-10-05 00:00:00', '2020-05-15 01:29:50', 1, '2020-07-01', '2020-07-08', 1),
(2, 3, '2020-10-05 00:00:00', '2020-05-15 16:44:58', 1, '2020-07-15', '2020-07-29', 0),
(3, 4, '2020-10-05 00:00:00', '2020-05-16 00:44:47', 1, '2020-08-01', '2020-08-08', 1),
(4, 5, '2020-10-05 00:00:00', '2020-05-15 16:45:17', 1, '2020-07-01', '2020-07-08', 1),
(5, 6, '2020-10-05 00:00:00', '2020-05-15 16:52:55', 1, '2020-06-01', '2020-06-08', 1),
(6, 6, '2020-10-05 00:00:00', '2020-05-15 23:41:19', 1, '2020-07-01', '2020-07-08', 1),
(7, 7, '2020-10-05 00:00:00', '2020-05-15 16:46:57', 1, '2020-06-10', '2020-06-24', 1),
(8, 8, '2020-10-05 00:00:00', '2020-05-15 16:52:55', 1, '2020-07-01', '2020-07-08', 1),
(9, 8, '2020-10-05 00:00:00', '2020-10-05 00:00:00', NULL, '2020-09-21', '2020-10-28', 1),
(10, 9, '2020-10-05 00:00:00', '2020-10-05 00:00:00', 1, '2020-07-01', '2020-07-08', 1),
(86, 2, '2020-05-16 01:36:41', '2020-05-16 01:36:41', 2, '2020-05-13', '2020-05-22', 0),
(87, 2, '2020-05-16 01:36:52', '2020-05-16 01:36:52', 2, '2020-06-05', '2020-06-19', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `role_Id` (`role_id`);

--
-- Индексы таблицы `vacations`
--
ALTER TABLE `vacations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `vacations`
--
ALTER TABLE `vacations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
