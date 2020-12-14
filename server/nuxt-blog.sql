-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 14 2020 г., 17:10
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
-- База данных: `nuxt-blog`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `comment` varchar(1000) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_post` tinyint(3) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `name`, `comment`, `date`, `id_post`) VALUES
(1, 'Роман', 'Комментарий. Держись Лёха!', '2020-12-13 13:22:14', 2),
(2, 'Анатолий', 'Ребята привет!!!', '2020-12-13 13:24:59', 2),
(3, 'Тамара', 'Этот комментарий самый лучший', '2020-12-13 13:26:25', 2),
(4, 'Роман', 'Девушки пушка!!!', '2020-12-13 13:43:31', 1),
(5, 'Анатолий', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa', '2020-12-13 13:46:08', 1),
(6, 'Тамара', 'asasaas eeeeeeff wwwwwwwwwwwww', '2020-12-13 13:47:50', 1),
(7, 'Роман', 'wdwd\nwdwdw\nwdwdwd\n11111111111', '2020-12-13 13:49:07', 1),
(8, 'Роман', 'Сууууууууууууууууууууууууууууууууууууууууууууууупер!!!', '2020-12-13 13:58:10', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `imageUrl` varchar(255) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `views` tinyint(3) UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `text`, `imageUrl`, `date`, `views`) VALUES
(2, 'Запись 2', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur dignissimos dolore eligendi explicabo fuga id impedit ipsum qui quos saepe similique, velit vero? Atque beatae, blanditiis consequuntur corporis cupiditate dolorem ea eum fugit ipsa ipsam ipsum laborum libero minima nesciunt pariatur praesentium qui quisquam ratione, rem saepe totam ullam.', 'http://server.loc/images/navalnii1607846336.jpg', '2020-12-13 07:58:56', 71),
(3, 'Запись 3', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. At consectetur dignissimos dolore eligendi explicabo fuga id impedit ipsum qui quos saepe similique, velit vero?', 'http://server.loc/images/мустанг_фон_jpg1607846361.jpg', '2020-12-13 07:59:21', 20);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `login` varchar(100) NOT NULL,
  `password` varchar(60) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `token` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `password`, `token`) VALUES
(1, 'Роман', '$2y$10$lhD3Ash9H1OG94O03SIM7.cKtxQIVF2YGIqYvyGPi9JK/J3mT6r7e', '');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
