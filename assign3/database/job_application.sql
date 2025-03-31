-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 05, 2022 at 02:52 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `job_application`
--

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(6) NOT NULL,
  `Job_Reference_number` varchar(6) NOT NULL,
  `First_name` varchar(20) NOT NULL,
  `Last_name` varchar(20) NOT NULL,
  `gender` enum('Male','Female','Other','') NOT NULL,
  `dob` date NOT NULL,
  `Street_address` varchar(40) NOT NULL,
  `Suburb` varchar(40) NOT NULL,
  `State` varchar(40) NOT NULL,
  `Postcode` varchar(4) NOT NULL,
  `Email_address` varchar(40) NOT NULL,
  `Phone_number` varchar(15) NOT NULL,
  `status` enum('New','Current','Final','') NOT NULL DEFAULT 'New',
  `date` date NOT NULL DEFAULT current_timestamp(),
  `addeddate` datetime NOT NULL DEFAULT current_timestamp(),
  `modifieddate` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `Job_Reference_number`, `First_name`, `Last_name`, `gender`, `dob`, `Street_address`, `Suburb`, `State`, `Postcode`, `Email_address`, `Phone_number`, `status`, `date`, `addeddate`, `modifieddate`) VALUES
(1, 'J202', 'fd', 'sdf', 'Male', '2022-07-04', 'gfh', 'gj', 'QLD', '4576', 'dfg@dg.com', '476457645', 'Current', '2022-07-04', '2022-07-04 16:18:27', '2022-07-04 16:45:17');

-- --------------------------------------------------------

--
-- Table structure for table `hr-manager`
--

CREATE TABLE `hr-manager` (
  `id` int(10) NOT NULL,
  `manager_username` varchar(100) NOT NULL,
  `encrypted_password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `full_name` varchar(70) NOT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Active',
  `date_added` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hr-manager`
--

INSERT INTO `hr-manager` (`id`, `manager_username`, `encrypted_password`, `email`, `full_name`, `status`, `date_added`, `modified_date`) VALUES
(2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'hr@gmail.com', 'HR Manager', 'Active', '2022-07-02 12:11:03', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(100) NOT NULL,
  `Job_Reference_number` varchar(100) NOT NULL,
  `job_title` varchar(200) NOT NULL,
  `job_description` text NOT NULL,
  `job_status` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `Job_Reference_number`, `job_title`, `job_description`, `job_status`, `date`) VALUES
(1, 'J202', 'Title Here', 'Job description here', 'Active', '2022-07-04 16:17:38');

-- --------------------------------------------------------

--
-- Table structure for table `skills`
--

CREATE TABLE `skills` (
  `id` int(10) NOT NULL,
  `EOInumber` varchar(100) NOT NULL,
  `skillCheckboxes` varchar(200) NOT NULL,
  `Other_skills` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `skills`
--

INSERT INTO `skills` (`id`, `EOInumber`, `skillCheckboxes`, `Other_skills`) VALUES
(1, '1', '/Responsible/Reliable/Restitude/Teamwork', 'other skills');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_accesslog`
--

CREATE TABLE `tbl_accesslog` (
  `id` int(3) NOT NULL,
  `ip` varchar(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `attempt` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_lockaccount`
--

CREATE TABLE `tbl_lockaccount` (
  `id` int(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `hr-manager`
--
ALTER TABLE `hr-manager`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `manager_username` (`manager_username`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `Job_Reference_number` (`Job_Reference_number`);

--
-- Indexes for table `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`),
  ADD KEY `EOInumber` (`EOInumber`);

--
-- Indexes for table `tbl_accesslog`
--
ALTER TABLE `tbl_accesslog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_lockaccount`
--
ALTER TABLE `tbl_lockaccount`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hr-manager`
--
ALTER TABLE `hr-manager`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_accesslog`
--
ALTER TABLE `tbl_accesslog`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_lockaccount`
--
ALTER TABLE `tbl_lockaccount`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
