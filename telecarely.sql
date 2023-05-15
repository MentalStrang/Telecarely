-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 12, 2023 at 10:12 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `telecarely`
--

-- --------------------------------------------------------

--
-- Table structure for table `inquiries`
--

CREATE TABLE `inquiries` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `message` text DEFAULT NULL,
  `doctor_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `inquiries`
--

INSERT INTO `inquiries` (`id`, `patient_id`, `message`, `doctor_id`) VALUES
(10, 21, 'iam the patient number 21', 17),
(18, 21, 'hello im patient num 21 and you num 18', 18),
(19, 21, 'hello im a num 21 and you 19', 19),
(21, 22, 'hello doctor mohamed im patient num 22 and you num 17', 17),
(22, 23, 'hello doctor iam nadia and my id = 18', 18);

-- --------------------------------------------------------

--
-- Table structure for table `prescriptions`
--

CREATE TABLE `prescriptions` (
  `id` int(10) UNSIGNED NOT NULL,
  `patient_id` int(10) UNSIGNED NOT NULL,
  `doctor_id` int(10) UNSIGNED NOT NULL,
  `drug_name` text DEFAULT NULL,
  `drug_amount` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `prescriptions`
--

INSERT INTO `prescriptions` (`id`, `patient_id`, `doctor_id`, `drug_name`, `drug_amount`) VALUES
(4, 21, 17, 'you need to be relaxed just make It', 2),
(5, 21, 17, 'how are you today mohamed ahmed', 100),
(6, 23, 18, 'hello nadia iam doctor hesham and your id = 23 and my id = 18', 100000000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL,
  `age` int(11) NOT NULL,
  `phone` int(11) NOT NULL,
  `image` text NOT NULL,
  `specialty` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `age`, `phone`, `image`, `specialty`) VALUES
(17, 'Mohamed Ramadan', 'mohamed.ramadan23963@gmail.com', '$2y$10$O/jEuw/b84OSZCO1Kx.IoOqM3aspBdv5LR/.EOh1/MSMhV.7zHIyS', 'doctor', 12, 1015775920, '', 'ff'),
(18, 'hesham rehan', 'hesham22@gmail.com', '$2y$10$IIL774HVUfoeT8/8MCcNOOIYGdYHNgmJ5RiK5u1ZR96AfLtf7dYRK', 'doctor', 22, 1003515686, '', 'mohamed'),
(19, 'Ahmed Wageh Abdelmohsen Tawfeq', 'ahmed.wageh@gmail.com', '$2y$10$e7IW88g.sHIhJqZM.9RRS.TYGykvD4kQjwW9C2.jompjYlPcE89xq', 'doctor', 1, 2147483647, '0', 'very bad'),
(20, 'Mohamed Ramadan', 'mohamed.ramadan2393@gmail.com', '$2y$10$I.98dFJxZTx6pvNNszvlA.MQmn4baQeI2.ispw6sA5PFGheukMqXq', 'patient', 12, 1015775920, '0', NULL),
(21, 'mohamed ahmed ', 'mohamed.ahmed@gmail.com', '$2y$10$MbuS9yEp71ALM0UOYKnI2e4JzjmoIvMW.k.uKPdMbnAF6nVu39kQe', 'patient', 22, 1003515686, '0', NULL),
(22, 'ahmed mahmoud', 'ahmed.mahmoud@gmail.com', '$2y$10$.lIKQumJdsGIGazT60XFSuILInwtInWEBCdf.D8t9jldHaZjYAsme', 'patient', 11, 1281166863, '0', NULL),
(23, 'Nadia Hosny', 'nadia.hosny@gmail.com', '$2y$10$D9y6UPRLTGDWHXmxb1.xBOKibW4qqx2WD/LRPwbFlXt370yMc6/CO', 'patient', 12, 1015775920, '0', NULL),
(25, 'ahmed mah', 'ahmedra@gmail.com', '$2y$10$/PGkfv8n1s0lRF/cr65I0uHYBlmBHiasIoK0S2WOScnrNelpwdNvq', 'doctor', 22, 1003515686, 'IMG_20230425_153340 copy.jpg', 'vvv');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inquiries_ibfk_1` (`patient_id`);

--
-- Indexes for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `inquiries`
--
ALTER TABLE `inquiries`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `prescriptions`
--
ALTER TABLE `prescriptions`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `inquiries`
--
ALTER TABLE `inquiries`
  ADD CONSTRAINT `inquiries_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `prescriptions`
--
ALTER TABLE `prescriptions`
  ADD CONSTRAINT `prescriptions_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `prescriptions_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
