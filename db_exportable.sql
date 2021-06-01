-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 02, 2021 at 05:29 PM
-- Server version: 5.7.33-0ubuntu0.18.04.1
-- PHP Version: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u_190145026_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adoption_requests`
--

CREATE TABLE `adoption_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `animal_id` bigint(20) UNSIGNED NOT NULL,
  `status` enum('pending','approved','denied') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adoption_requests`
--

INSERT INTO `adoption_requests` (`id`, `user_id`, `animal_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 'denied', '2021-04-29 21:21:23', '2021-04-29 21:27:20'),
(2, 2, 2, 'denied', '2021-04-29 21:22:03', '2021-04-29 21:23:07'),
(3, 3, 1, 'approved', '2021-04-29 21:22:16', '2021-04-29 21:27:20'),
(4, 3, 2, 'pending', '2021-04-29 21:22:21', '2021-04-29 21:22:21'),
(5, 2, 6, 'pending', '2021-05-01 18:19:10', '2021-05-01 18:19:10'),
(6, 2, 7, 'pending', '2021-05-01 18:23:42', '2021-05-01 18:23:42'),
(7, 2, 3, 'pending', '2021-05-01 18:23:46', '2021-05-01 18:23:46'),
(8, 3, 3, 'pending', '2021-05-01 18:24:00', '2021-05-01 18:24:00');

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `birth_date` date NOT NULL,
  `description` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(256) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `adopter_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `birth_date`, `description`, `image`, `adopter_id`, `created_at`, `updated_at`) VALUES
(1, 'Bottlenose Dolphin', '2021-06-09', 'The bottlenose dolphin weighs an average of 300 kg (660 pounds). It can reach a length of just over 4 meters (13 feet). Its color varies considerably, is usually dark gray on the back and lighter gray on the flanks, but it can be bluish-grey as well.', '_31_1619738200.jpg', 3, '2021-04-29 21:16:40', '2021-04-30 18:54:33'),
(2, 'European Rabbit', '2019-06-11', 'The European rabbit is well known for digging networks of burrows, called warrens, where it spends most of its time when not feeding. Unlike the related hares (Lepus spp.), rabbits are altricial, the young being born blind and furless, in a fur-lined nest', '220px-Oryctolagus_cuniculus_Tasmania_2_1619738437.jpg', NULL, '2021-04-29 21:20:37', '2021-04-29 21:20:37'),
(3, 'Bahamian raccoon', '2019-06-12', 'Medium-sized mammal native to North America', 'procione2-400x234_1619898984.jpg', NULL, '2021-05-01 17:56:24', '2021-05-01 17:56:24'),
(4, 'Rhesus macaque', '2018-05-15', 'The rhesus macaque is brown or grey in color and has a pink face, which is bereft of fur. It has, on average, 50 vertebrae, a dorsal scapulae and a wide rib cage.', 'DSCN0504crop best 800600_0_1619899312.jpg', NULL, '2021-05-01 18:01:52', '2021-05-01 18:01:52'),
(5, 'Nile hippopotamus', '2010-12-02', 'The Nile hippopotamus is a large, mostly herbivorous, semiaquatic mammal and ungulate native to sub-Saharan Africa.', 'hippo_1619970976.jpg', NULL, '2021-05-01 18:04:22', '2021-05-02 14:56:16'),
(6, 'Bengal tiger', '2014-08-23', 'The Bengal tiger\'s coat is yellow to light orange, with stripes ranging from dark brown to black; the belly and the interior parts of the limbs are white, and the tail is orange with black rings.', '1280px-Bengal_tiger_(Panthera_tigris_tigris)_female_3_crop_1619899803.jpg', NULL, '2021-05-01 18:10:03', '2021-05-01 18:10:03'),
(7, 'Emperor penguin', '2019-10-30', 'The emperor penguin (Aptenodytes forsteri) is the tallest and heaviest of all living penguin species and is endemic to Antarctica.', 'emperor-penguin_1619899946.jpg', NULL, '2021-05-01 18:12:26', '2021-05-01 18:12:26'),
(8, 'King Penguin', '2020-05-14', 'The king penguin is the second largest species of penguin, smaller, but somewhat similar in appearance to the emperor penguin. King penguins mainly eat lanternfish, squid and krill. On foraging trips, king penguins repeatedly dive to over 100 metres.', 'King_Penguin_1619900261.jpg', NULL, '2021-05-01 18:17:41', '2021-05-02 12:17:34'),
(9, 'Red Fox', '2018-09-14', 'The red fox is the largest of the true foxes and one of the most widely distributed members of the order Carnivora, being present across the entire Northern Hemisphere including most of North America, Europe and Asia, plus parts of North Africa.', 'Red-fox-Vulpes-vulpes_1619970893.jpg', NULL, '2021-05-02 12:36:53', '2021-05-02 14:54:53');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2021_04_03_143017_create_animals_table', 1),
(5, '2021_04_03_144158_create_adoption_requests_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('parmi799@gmail.com', '$2y$10$sCDp5J7XKBviJviW8cMNVeqbw4IhUsqQ2l2tw/ISaqzZagyxF07x.', '2021-04-23 11:02:03');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` tinyint(1) NOT NULL DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@astonsanctuary.com', NULL, 1, '$2y$10$4G0SXYQ8vUjEQHhTfMqcy./sAy/7W0d97dRuEY4qkprrfGTxfZUCW', NULL, '2021-04-03 16:06:52', '2021-04-03 16:06:52'),
(2, 'Alice', 'alice@gmail.com', NULL, 0, '$2y$10$/YOa3HKX7txfAMNEXGmEbeoHwI6AUEfX.X526YE7zc39S/fDOyUue', NULL, '2021-04-05 14:51:24', '2021-04-05 14:51:24'),
(3, 'Bob', 'bob@gmail.com', NULL, 0, '$2y$10$HtbzcnvIcxlxf.pGY4Kx5uA3ErhXWbvVGy/TFOhxOpOnVEErILXIG', NULL, '2021-04-20 07:32:08', '2021-04-20 07:32:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `adoption_requests_user_id_foreign` (`user_id`),
  ADD KEY `adoption_requests_animal_id_foreign` (`animal_id`);

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animals_adopter_id_foreign` (`adopter_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adoption_requests`
--
ALTER TABLE `adoption_requests`
  ADD CONSTRAINT `adoption_requests_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`),
  ADD CONSTRAINT `adoption_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_adopter_id_foreign` FOREIGN KEY (`adopter_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
