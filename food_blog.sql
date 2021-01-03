-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 03, 2021 at 09:23 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `food_blog`
--

-- --------------------------------------------------------

--
-- Table structure for table `counter`
--

CREATE TABLE `counter` (
  `post_id` int(11) NOT NULL,
  `up` int(11) NOT NULL DEFAULT 0,
  `down` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `counter`
--

INSERT INTO `counter` (`post_id`, `up`, `down`) VALUES
(9, 2, 0),
(10, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `ingredients`
--

CREATE TABLE `ingredients` (
  `ing_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ingredients`
--

INSERT INTO `ingredients` (`ing_id`, `name`) VALUES
(1, 'cheese'),
(2, 'milk'),
(3, 'egg'),
(4, 'corn_flour'),
(5, 'wheat'),
(6, 'potato');

-- --------------------------------------------------------

--
-- Table structure for table `pi_relation`
--

CREATE TABLE `pi_relation` (
  `post_id` int(11) NOT NULL,
  `ingredient_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pi_relation`
--

INSERT INTO `pi_relation` (`post_id`, `ingredient_id`) VALUES
(9, 1),
(9, 4),
(9, 5),
(10, 1),
(10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `description` varchar(1024) NOT NULL,
  `views` int(11) NOT NULL DEFAULT 0,
  `body` varchar(10000) NOT NULL,
  `featured_img` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `user_id`, `title`, `description`, `views`, `body`, `featured_img`, `created_at`) VALUES
(9, 1, 'Dal Makhani', 'Ever go to an Indian restaurant and wonder how they make those lentils? I hated lentils before I discovered Indian food. Then I scoured the internet to figure out how they achieved them, and through mixing and matching recipes and methods on videos, I have arrived at this recipe, which I think is pretty close.', 2, ' Step 1:\r\nPlace lentils and kidney beans in a large bowl; cover with plenty of water. Soak for at least 2 hours or overnight. Drain.\r\n\r\nStep 2\r\nCook lentils, kidney beans, 5 cups water, and salt in a pot over medium heat until tender, stirring occasionally, about 1 hour. Remove from heat and set aside. Keep the lentils, kidney beans, and any excess cooking water in the pot.\r\n\r\nStep 3\r\nHeat vegetable oil in a saucepan over medium-high heat. Cook cumin seeds in the hot oil until they begin to pop, 1 to 2 minutes. Add cardamom pods, cinnamon stick, bay leaves, and cloves; cook until bay leaves turn brown, about 1 minute. Reduce heat to medium-low; add ginger paste, garlic paste, turmeric, and cayenne pepper. Stir to coat.\r\n\r\nStep 4\r\nStir tomato puree into spice mixture; cook over medium heat until slightly reduced, about 5 minutes. Add chili powder, coriander, and butter; cook and stir until butter is melted.\r\n\r\nStep 5\r\nStir lentils, kidney beans and any leftover cooking water into tomato mixture; bring to a boil, reduce heat to low. Stir fenugreek into lentil mixture. Cover saucepan and simmer until heated through, stirring occasionally, about 45 minutes. Add cream and cook until heated through, 2 to 4 minutes.    \r\n\r\nhshhs', 'http://localhost/food_blog/includes/uploads/daal_makhani.jpeg', '2021-01-03 19:44:19'),
(10, 3, 'Palak Paneer', 'Traditional pure vegetarian recipe, without onions or garlic! 100% made from scratch and absolutely delicious.', 1, ' Line a colander with a cheesecloth and place in the sink.\r\n\r\nStep 2\r\nBring milk to a boil in a large pot; add lemon juice. Stir until milk separates into curds and whey. Transfer curds with a large slotted spoon to the prepared colander and allow curds to drain. Whey can be saved for another use.\r\n\r\nStep 3\r\nGather cheesecloth around curds to squeeze out excess liquid and to form a ball. Return wrapped curd ball to the colander and place the whey-filled pot (or another weight) over the curd ball to press and drain completely, about 20 minutes.\r\n\r\nStep 4\r\nBring a large pot of water to a boil; add spinach. Simmer until spinach is wilted, 1 to 2 minutes. Transfer spinach to a bowl with a slotted spoon. Drop tomatoes into the same pot of boiling water; simmer until tomato skins begin to split, 3 to 5 minutes. Drain. Peel tomato skins when cool enough to handle.\r\n\r\nStep 5\r\nPlace spinach in a blender or food processor; puree until smooth and remove spinach to a bowl.\r\n\r\nStep 6\r\nPlace peeled tomatoes in a blender or food processor; puree until smooth and remove tomatoes to another bowl.\r\n\r\nStep 7\r\nUnwrap curd ball from cheesecloth; paneer should now be a solid block. Cut paneer into small cubes.\r\n\r\nStep 8\r\nHeat ghee in a large skillet over medium-low heat; cook and stir turmeric, ground red chile powder, and asafoetida powder in hot ghee until fragrant, about 20 seconds. Stir in tomato puree into ghee and spices and increase heat to medium. Cover and simmer until ghee rises to the top, about 10 minutes.\r\n\r\nStep 9\r\nStir spinach puree and salt into tomato mixture. Continue to simmer until fragrant, 5 to 10 minutes more. Add cubed paneer to skillet; cook until paneer is softened, 2 to 3 minutes. Stir cream into spinach-tomato mixture, cover, and simmer until hot, 2 to 3 minutes more.\r\n\r\nStep 10\r\nRemove skillet from heat and sprinkle with ground fenugreek. Cool for a few minutes before serving.', 'http://localhost/food_blog/includes/uploads/palak_panner.jpeg', '2021-01-03 20:21:31');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'meet', 'onimeet5@gmail.com', 'ea16f6597913ed751d4bd8f503ec4ff1', '2021-01-03 19:41:28', '2021-01-03 19:41:28'),
(2, 'atul', 'atul@gmail.com', 'af8f9dffa5d420fbc249141645b962ee', '2021-01-03 20:19:55', '2021-01-03 20:19:55'),
(3, 'parth', 'parth@gmail.com', '5e70978f884a79cbd890a75d32b0121f', '2021-01-03 20:20:22', '2021-01-03 20:20:22');

-- --------------------------------------------------------

--
-- Table structure for table `views`
--

CREATE TABLE `views` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `views`
--

INSERT INTO `views` (`post_id`, `user_id`) VALUES
(9, 1),
(9, 3),
(10, 3);

-- --------------------------------------------------------

--
-- Table structure for table `vote`
--

CREATE TABLE `vote` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vote`
--

INSERT INTO `vote` (`post_id`, `user_id`) VALUES
(9, 1),
(9, 3),
(10, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `counter`
--
ALTER TABLE `counter`
  ADD UNIQUE KEY `post_id` (`post_id`);

--
-- Indexes for table `ingredients`
--
ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`ing_id`);

--
-- Indexes for table `pi_relation`
--
ALTER TABLE `pi_relation`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `ingredient_id` (`ingredient_id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `views`
--
ALTER TABLE `views`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `vote`
--
ALTER TABLE `vote`
  ADD KEY `post_id` (`post_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `counter`
--
ALTER TABLE `counter`
  ADD CONSTRAINT `counter_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pi_relation`
--
ALTER TABLE `pi_relation`
  ADD CONSTRAINT `pi_relation_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `pi_relation_ibfk_2` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients` (`ing_id`) ON DELETE CASCADE;

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `views`
--
ALTER TABLE `views`
  ADD CONSTRAINT `views_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `views_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `vote`
--
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `post` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
