-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 12, 2024 at 08:35 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ematbooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `Admin_id` int(11) NOT NULL,
  `Admin_name` varchar(255) NOT NULL,
  `Admin_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`Admin_id`, `Admin_name`, `Admin_password`) VALUES
(1998, 'Arnele', 'Theypevacere123#');

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `BookingID` int(11) NOT NULL,
  `Cust_email` int(11) DEFAULT NULL,
  `SeatID` int(11) DEFAULT NULL,
  `BookingDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `Route` varchar(50) NOT NULL,
  `Booking_status` varchar(255) NOT NULL DEFAULT 'Booked',
  `departure_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`BookingID`, `Cust_email`, `SeatID`, `BookingDate`, `Route`, `Booking_status`, `departure_time`) VALUES
(1, 0, NULL, '2024-08-12 06:12:45', 'CBD', 'confirmed', '2024-08-12 11:30:00');

-- --------------------------------------------------------

--
-- Table structure for table `buses`
--

CREATE TABLE `buses` (
  `BusID` int(11) NOT NULL,
  `BusNumber` varchar(50) DEFAULT NULL,
  `TotalSeats` int(11) DEFAULT NULL,
  `Route_name` varchar(255) NOT NULL,
  `Driver_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buses`
--

INSERT INTO `buses` (`BusID`, `BusNumber`, `TotalSeats`, `Route_name`, `Driver_id`) VALUES
(185, 'KDK417B', 20, 'cbd', 1090920),
(186, 'KDK417C', 20, 'ngong\'', 1090950),
(187, 'KDK417D', 20, 'rongai', 1090980);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `Cust_id` int(11) NOT NULL,
  `Cust_name` varchar(255) NOT NULL,
  `Cust_email` varchar(255) NOT NULL,
  `Cust_phone` varchar(25) DEFAULT NULL,
  `Cust_image` varchar(255) DEFAULT NULL,
  `Cust_pass` varchar(255) NOT NULL,
  `Cust_status` varchar(25) NOT NULL DEFAULT 'unverified'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`Cust_id`, `Cust_name`, `Cust_email`, `Cust_phone`, `Cust_image`, `Cust_pass`, `Cust_status`) VALUES
(10, 'arnele', 'alsinaarnele@gmail.com', '254741898829', 'Sad.jpg', '$2y$10$gtKhxGyMMHwWaEpH4/Wqz.OsmLbZ.qv1UpQi.xi5b6X6kK/Yw1Ws6', 'verified');

-- --------------------------------------------------------

--
-- Table structure for table `customerverification`
--

CREATE TABLE `customerverification` (
  `verification_id` int(11) NOT NULL,
  `Cust_email` varchar(255) NOT NULL,
  `Cust_code` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `drivers`
--

CREATE TABLE `drivers` (
  `Driver_id` int(11) NOT NULL,
  `Driver_email` varchar(255) NOT NULL,
  `Driver_name` varchar(255) NOT NULL,
  `Driver_password` varchar(255) NOT NULL,
  `Driver_url` varchar(255) DEFAULT NULL,
  `Driver_status` varchar(255) NOT NULL DEFAULT 'Inactive'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `drivers`
--

INSERT INTO `drivers` (`Driver_id`, `Driver_email`, `Driver_name`, `Driver_password`, `Driver_url`, `Driver_status`) VALUES
(1090920, 'bernardOch@gmail.com', 'Bernard Ochieng\'', 'Theypevacere123#', NULL, 'Inactive');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `Driver_id` int(11) DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `comment` varchar(255) NOT NULL,
  `Feedback_status` varchar(255) NOT NULL DEFAULT 'Unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `student_id`, `Driver_id`, `rating`, `comment`, `Feedback_status`) VALUES
(1998, 9, NULL, 5, 'I was safely delivered, highly recommended.', 'Unread'),
(1999, 10, NULL, 3, 'Good job!', 'Unread');

-- --------------------------------------------------------

--
-- Table structure for table `routes`
--

CREATE TABLE `routes` (
  `Route_ID` int(11) NOT NULL,
  `Route_name` varchar(255) NOT NULL,
  `start_location` varchar(255) NOT NULL,
  `end_location` varchar(255) NOT NULL,
  `distance` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `routes`
--

INSERT INTO `routes` (`Route_ID`, `Route_name`, `start_location`, `end_location`, `distance`) VALUES
(989, 'CBD', 'Catholic University Main Campus', 'Central Business District', 40),
(990, 'Ngong\'', 'Catholic University Main Campus', 'Ngong\'', 40),
(991, 'Rongai', 'Catholic University Main Campus', 'Ongata Rongai', 40);

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `Route_ID` int(11) NOT NULL,
  `schedule_id` int(11) NOT NULL,
  `departure_time` datetime NOT NULL,
  `arrival_time` datetime NOT NULL,
  `BusID` int(11) NOT NULL,
  `Schedule_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`Route_ID`, `schedule_id`, `departure_time`, `arrival_time`, `BusID`, `Schedule_status`) VALUES
(989, 14, '2024-08-12 11:30:00', '2024-08-12 12:30:00', 185, 'Scheduled');

-- --------------------------------------------------------

--
-- Table structure for table `seats`
--

CREATE TABLE `seats` (
  `SeatID` int(11) NOT NULL,
  `BusID` int(11) DEFAULT NULL,
  `SeatRow` int(11) DEFAULT NULL,
  `SeatColumn` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `seats`
--

INSERT INTO `seats` (`SeatID`, `BusID`, `SeatRow`, `SeatColumn`) VALUES
(1, 185, 1, '1'),
(2, 185, 1, '2'),
(3, 185, 1, '3'),
(4, 185, 1, '4'),
(5, 185, 2, '1'),
(6, 185, 2, '2'),
(7, 185, 2, '3'),
(8, 185, 2, '4'),
(9, 185, 3, '1'),
(10, 185, 3, '2'),
(11, 185, 3, '3'),
(12, 185, 3, '4'),
(13, 185, 4, '1'),
(14, 185, 4, '2'),
(15, 185, 4, '3'),
(16, 185, 4, '4'),
(17, 185, 5, '1'),
(18, 185, 5, '2'),
(19, 185, 5, '3'),
(20, 185, 5, '4'),
(21, 186, 1, '1'),
(22, 186, 1, '2'),
(23, 186, 1, '3'),
(24, 186, 1, '4'),
(25, 186, 2, '1'),
(26, 186, 2, '2'),
(27, 186, 2, '3'),
(28, 186, 2, '4'),
(29, 186, 3, '1'),
(30, 186, 3, '2'),
(31, 186, 3, '3'),
(32, 186, 3, '4'),
(33, 186, 4, '1'),
(34, 186, 4, '2'),
(35, 186, 4, '3'),
(36, 186, 4, '4'),
(37, 186, 5, '1'),
(38, 186, 5, '2'),
(39, 186, 5, '3'),
(40, 186, 5, '4'),
(41, 187, 1, '1'),
(42, 187, 1, '2'),
(43, 187, 1, '3'),
(44, 187, 1, '4'),
(45, 187, 2, '1'),
(46, 187, 2, '2'),
(47, 187, 2, '3'),
(48, 187, 2, '4'),
(49, 187, 3, '1'),
(50, 187, 3, '2'),
(51, 187, 3, '3'),
(52, 187, 3, '4'),
(53, 187, 4, '1'),
(54, 187, 4, '2'),
(55, 187, 4, '3'),
(56, 187, 4, '4'),
(57, 187, 5, '1'),
(58, 187, 5, '2'),
(59, 187, 5, '3'),
(60, 187, 5, '4');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `SeatID` (`SeatID`);

--
-- Indexes for table `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`BusID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`Cust_id`);

--
-- Indexes for table `customerverification`
--
ALTER TABLE `customerverification`
  ADD PRIMARY KEY (`verification_id`),
  ADD KEY `Cust_email` (`Cust_email`);

--
-- Indexes for table `drivers`
--
ALTER TABLE `drivers`
  ADD PRIMARY KEY (`Driver_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`Route_ID`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`schedule_id`);

--
-- Indexes for table `seats`
--
ALTER TABLE `seats`
  ADD PRIMARY KEY (`SeatID`),
  ADD KEY `BusID` (`BusID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1999;

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `Cust_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `customerverification`
--
ALTER TABLE `customerverification`
  MODIFY `verification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `drivers`
--
ALTER TABLE `drivers`
  MODIFY `Driver_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1090921;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2000;

--
-- AUTO_INCREMENT for table `routes`
--
ALTER TABLE `routes`
  MODIFY `Route_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=992;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `schedule_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `seats`
--
ALTER TABLE `seats`
  MODIFY `SeatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`SeatID`) REFERENCES `seats` (`SeatID`);

--
-- Constraints for table `seats`
--
ALTER TABLE `seats`
  ADD CONSTRAINT `seats_ibfk_1` FOREIGN KEY (`BusID`) REFERENCES `buses` (`BusID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
