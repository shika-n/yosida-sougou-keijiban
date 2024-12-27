-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2024-12-16 04:17:09
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `laa1618031-mydb`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `author` varchar(50) NOT NULL DEFAULT '匿名者',
  `title` varchar(100) NOT NULL,
  `posted_at` datetime NOT NULL DEFAULT current_timestamp(),
  `message` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `author`, `title`, `posted_at`, `message`, `password`) VALUES
(1, '匿名者', 'Hello world!', '2024-12-03 11:23:16', 'First post', 'dummy'),
(2, '匿名者', 'Hello world!', '2024-12-03 11:26:06', 'Second post', 'dummy'),
(3, '匿名者', 'test', '2024-12-03 11:51:58', 'B', '$argon2i$v=19$m=65536,t=4,p=1$OUJ4NkUzMDlTRlJwQnFZZA$a/tNjp+Tqz7MLAN+gdxHxiQEykeZkHpzXzn83IMzbBc'),
(4, '匿名者', 'Test no author', '2024-12-03 12:16:34', 'content', '$argon2i$v=19$m=65536,t=4,p=1$THo4ejlKaHNIajR4T3Nvdg$yT2gBJZlPQ0J3tzpBD0N/TPdMNoFgLbh6DgKlekgGDc'),
(5, 'Author', 'Test with author', '2024-12-03 12:16:35', 'content', '$argon2i$v=19$m=65536,t=4,p=1$NWZqdXBjaUllY1cwa0N2RA$Y8XU1P1fwyB4y/eFj3+gPcIrg0yJDlSFvSB9NMQR7rc'),
(6, '匿名者', 'No Author', '2024-12-09 11:04:43', '', '$argon2i$v=19$m=65536,t=4,p=1$LlYyUUliQmRFTkJGUW9KSQ$0H5T2V6TTCKpHWDq1uQoYNh3Zz88/aR3IV/NLgjzbmA'),
(9, 'itsame', 'With Author 2', '2024-12-09 11:09:37', 'Test from site 4', '$argon2i$v=19$m=65536,t=4,p=1$ODBpdmhnTHZSeXJHa0RZWg$FtCfHKw3jSZvtE5+Y4cD4efwe96ik/DqyarC8U80Jrc'),
(10, '拙者', 'タイトル', '2024-12-09 11:40:37', 'メッセージです！', '$argon2i$v=19$m=65536,t=4,p=1$cndobFRwWWZTdFY0eDV1Zw$TfVGJ4woe3TpTGbv4mdqNgZGu2YWBlyR0A3I0xjxJ2U'),
(12, 'test', 'test', '2024-12-10 10:53:58', 'test', '$argon2i$v=19$m=65536,t=4,p=1$VWNVRG5RT2pCNWF5T1EzcA$xfHOPrkAg5WLkuheJ4HNyYZb1YQwXo/QfxuEZr76ZUQ'),
(15, 'shaaa', 'author long', '2024-12-10 12:11:30', 'upds', '$argon2i$v=19$m=65536,t=4,p=1$cjVWdG5meGloanh0MlFoUQ$8fNq2ebQAlih6EBksG4VGw1bDEHXLy5AEEWBQxWECaA'),
(17, 'ひらがな', 'あいうえお', '2024-12-16 11:25:11', 'あいうえお', '$argon2i$v=19$m=65536,t=4,p=1$U1dpVFc3YjAwTFRlWldNaA$IsIuMMnw+fi0pUqu28lBzQD7rXdjEweP3BwcbduDsmg'),
(18, '匿名者', 'パス', '2024-12-16 11:25:36', '大体：asd', '$argon2i$v=19$m=65536,t=4,p=1$MjdDZzBOOFExTVRlWEJFcw$4Zkod3R+x2mMjyZJPnT8hvYYplQKhovKr632VmkwfSg'),
(19, '匿名者', 'test', '2024-12-16 11:45:24', 'qwe >>15 asd', '$argon2i$v=19$m=65536,t=4,p=1$d3VUVUNteW5FVk0vQ2djaA$CHDyCKpAkkjGTICH7kZE+Sb0pRiL7OsOyXVkEq3y6QQ'),
(20, '匿名者', 'only', '2024-12-16 11:59:42', '>>12', '$argon2i$v=19$m=65536,t=4,p=1$VERtMDdjT0tSaHFBTEp3OQ$dbwDnNL4BuAzwuWlsb02i9MJ+rik11qUdGJT+FCZSKo'),
(21, '匿名者', 'start', '2024-12-16 11:59:57', '>>10 start!', '$argon2i$v=19$m=65536,t=4,p=1$Y1VVYk5ieFBMNDh2Y01FVQ$JejDTsWjndO1rCHyVc6Jh3QOqG5HY2S+1BJegLgi4Wk'),
(22, '匿名者', 'end', '2024-12-16 12:00:11', 'end! >>9', '$argon2i$v=19$m=65536,t=4,p=1$YW9mMVNpbFB1azFMRWd3dg$1740d/EzPxSibQgrGTrAn4yPrB8rI+FreXiyDFRgRLk'),
(23, '匿名者', 'test 2', '2024-12-16 12:00:39', 'a >>22 aa', '$argon2i$v=19$m=65536,t=4,p=1$SmZIam9KUnJDMS9XSXRsTw$7epn5+baRdKL+lqZ7Ni5ZmuHxg8Wj/htWac9ddn9zLE'),
(24, '匿名者', 'jjjj', '2024-12-16 12:11:06', '>>5 >>10', '$argon2i$v=19$m=65536,t=4,p=1$UUYuZm8ueDRGQkRSVmZZag$CIoyJ6aIUJZIsJPD2eLpgXiVxf1ZlJ6sGwmxZoXAxbQ');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
