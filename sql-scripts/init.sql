-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3307
-- Время создания: Апр 01 2024 г., 16:47
-- Версия сервера: 5.7.39
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: tweetter feed
--

-- --------------------------------------------------------

--
-- Структура таблицы comments
--

CREATE TABLE comments (
  id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  content varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  post_id int(11) NOT NULL,
  user_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы comments
--

INSERT INTO comments (id, content, created_at, post_id, user_id) VALUES
(1, 'axaxaxaxax', '2024-03-31 18:43:45', 1, 2),
(2, 'xaxaxax', '2024-03-31 18:59:03', 6, 2),
(5, 'axaxaxaxaxaxaxaxaaxaxaxaxaxaxaxaxaaxaxaxaxaxaxaxaxaaxaxaxaxaxaxaxaxa', '2024-04-01 01:17:02', 9, 2),
(6, 'фчфчфчфчфчсывфсауцкамфквсц234234235424', '2024-04-01 01:32:10', 9, 2),
(7, 'ывммртпгииртиортмвыоштлривамодшгритлмвогтрлшмвывмтролвысмтловымсотлмвыолтмвытолвымтолвымтловымтолвым', '2024-04-01 01:34:28', 9, 2),
(8, 'ывммртпгииртиортмвыоштлривамодшгритлмвогтрлшмвывмтролвысмтловымсотлмвыолтмвытолвымтолвымтловымтолвымывммртпгииртиортмвыоштлривамодшгритлмвогтрлшмвывмтролвысмтловымсотлмвыолтмвытолвымтолвымтловымтолвым', '2024-04-01 01:39:10', 9, 2),
(9, 'фысмфыфыс', '2024-04-01 02:37:14', 4, 2),
(10, '321321231321313', '2024-04-01 02:51:20', 6, 4),
(11, 'sdadsadsadasdasd', '2024-04-01 02:54:10', 8, 4);

-- --------------------------------------------------------

--
-- Структура таблицы follow
--

CREATE TABLE follow (
  follower_id int(11) DEFAULT NULL,
  following_id int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы follow
--

INSERT INTO follow (follower_id, following_id) VALUES
(6, 3);

-- --------------------------------------------------------

--
-- Структура таблицы likes
--

CREATE TABLE likes (
  post_id int(11) NOT NULL,
  user_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы likes
--

INSERT INTO likes (post_id, user_id) VALUES
(1, 1),
(3, 2);

-- --------------------------------------------------------

--
-- Структура таблицы posts
--

CREATE TABLE posts (
  id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  content varchar(512) COLLATE utf8mb4_unicode_ci NOT NULL,
  created_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  likes int(11) NOT NULL DEFAULT '0',
  user_id int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы posts
--
INSERT INTO posts (id, content, created_at, likes, user_id) VALUES
(1, '123123123123000000', '2024-03-31 04:00:42', 1, 1),
(3, 'Снусмумрик — лучший друг Муми-тролля, который каждую зиму отправляется на юг и возвращается весной. Он является сыном Мюмлы-мамы и Юксаре, а также сводным братом Мюмлы и Малышки Мюю', '2024-03-31 18:49:44', 1, 2),
(4, 'Снусмумрик — философский скиталец, который бродит по миру, ловя рыбу и играя на губной гармошке. Он носит всё, что ему нужно, в своем рюкзаке, так как он считает, что слишком много вещей делает жизнь слишком сложной.', '2024-03-31 18:50:24', 0, 2),
(6, 'Снусмумрик встречает каждого нового человека с событием любопытства и тёплым сердцем. Ему нравится проводить время с муми-троллями в Муми-доле, но в ноябре он всегда уходит на юг на зиму, возвращаясь в Муми-дол только весной.', '2024-03-31 18:50:53', 0, 2),
(8, 'Малышка Мю (швед. Lilla My) — одна из персонажей серии книг про муми-троллей Туве Янссон, впервые появляющаяся в книге «Мемуары Муми-папы».', '2024-03-31 22:26:40', 0, 3),
(9, 'Малышка Мю — сводная сестра Снусмумрика и младшая сестра Мюмлы, однако большую часть времени проводит в Муми-доме с муми-троллями, которые считают её частью своей семьи.', '2024-03-31 22:26:53', 0, 3),
(11, 'avcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvcavcfdsacvwdscvwsdefvc', '2024-04-01 02:54:24', 0, 4),
(12, 'Мюмла — сестра Малышки Мю и сводная сестра Снусмумрика. Их маму также называют Мюмлой, но, будучи дружелюбной и полезной старшей сестрой, Мюмла вскоре взяла на себя ответственность за заботу обо всех младших братьях и сёстрах.', '2024-04-01 03:09:28', 0, 6),
(13, 'Несмотря на то, что у них одни и те же родители и одинаковый внешний вид, Мюмла и Малышка Мю отличаются друг от друга во многом. Мюмла гораздо спокойнее, чем Малышка Мю, и часто мечтает найти любовь всей своей жизни', '2024-04-01 03:09:46', 0, 6);

-- --------------------------------------------------------

--
-- Структура таблицы users
--

CREATE TABLE users (
  id int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
  login varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  password varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  email varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы users
--

INSERT INTO users (id, login, password, email) VALUES
(1, '123', '123', '123@123'),
(2, 'test', 'test', 'test@test'),
(3, 'login', 'login', 'login@login'),
(4, '321', '321', '321@321'),
(5, 'qwe', '$2y$10$11io3D4PO3yJDF2jyh4thu2qXV3SH4MXQ5z8GrPs/m0egxwoVK0W.', 'qwe@ewq'),
(6, 'ewq', '$2y$10$asgSDhPwfQsx3c7OzjRfh.JP.ShwXtqLn4gR18.XBVaU8kzSZWAEC', 'ewq@qwe');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы comments
--
ALTER TABLE comments
  ADD PRIMARY KEY (id),
  ADD KEY post_id (post_id),
  ADD KEY user_id (user_id);

--
-- Индексы таблицы follow
--
ALTER TABLE follow
  ADD KEY follower_id (follower_id),
  ADD KEY following_id (following_id);

--
-- Индексы таблицы likes
--
ALTER TABLE likes
  ADD KEY post_id (post_id),
  ADD KEY user_id (user_id);

--
-- Индексы таблицы posts
--
ALTER TABLE posts
  ADD PRIMARY KEY (id),
  ADD KEY fk_user_id (user_id);

--
-- Индексы таблицы users
--
ALTER TABLE users
  ADD PRIMARY KEY (id),
  ADD UNIQUE KEY login (login,email),
  ADD UNIQUE KEY login_2 (login,email),
  ADD UNIQUE KEY email (email),
  ADD UNIQUE KEY login_3 (login);

ALTER TABLE comments
  ADD CONSTRAINT post_id FOREIGN KEY (post_id) REFERENCES posts (id),
  ADD CONSTRAINT user_id FOREIGN KEY (user_id) REFERENCES users (id);

--
-- Ограничения внешнего ключа таблицы follow
--
ALTER TABLE follow
  ADD CONSTRAINT follow_ibfk_1 FOREIGN KEY (follower_id) REFERENCES users (id),
  ADD CONSTRAINT follow_ibfk_2 FOREIGN KEY (following_id) REFERENCES users (id);

--
-- Ограничения внешнего ключа таблицы likes
--
ALTER TABLE likes
  ADD CONSTRAINT fk_post_id FOREIGN KEY (post_id) REFERENCES posts (id) ON DELETE CASCADE,
  ADD CONSTRAINT likes_ibfk_1 FOREIGN KEY (post_id) REFERENCES posts (id),
  ADD CONSTRAINT likes_ibfk_2 FOREIGN KEY (user_id) REFERENCES users (id);

--
-- Ограничения внешнего ключа таблицы posts
--
ALTER TABLE posts
  ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (id);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

