<?php

//checking if eoi table is already created
$sql ="CREATE TABLE IF NOT EXISTS `eoi` (
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
    
  ";
$rest=mysqli_query($conn,$sql);
//add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `eoi`
    ADD PRIMARY KEY (`EOInumber`);
    
    ");
    mysqli_query($conn,"ALTER TABLE `eoi`
    MODIFY `EOInumber` int(6) NOT NULL AUTO_INCREMENT;");
    
//checking if hr-manager table is already created
$sql1 ="CREATE TABLE IF NOT EXISTS  `hr-manager` (
    `id` int(10) NOT NULL,
    `manager_username` varchar(100) NOT NULL,
    `encrypted_password` varchar(100) NOT NULL,
    `email` varchar(100) NOT NULL,
    `full_name` varchar(70) NOT NULL,
    `status` varchar(30) NOT NULL DEFAULT 'Active',
    `date_added` datetime NOT NULL DEFAULT current_timestamp(),
    `modified_date` datetime DEFAULT NULL ON UPDATE current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  
  ";
  $rest1=mysqli_query($conn,$sql1);

//add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `hr-manager`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `manager_username` (`manager_username`);
    ");
    mysqli_query($conn,"ALTER TABLE `hr-manager`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;");
    //insert record
    $insert=mysqli_query($conn,"INSERT INTO `hr-manager` (`id`, `manager_username`, `encrypted_password`, `email`, `full_name`, `status`, `date_added`, `modified_date`) VALUES
    (2, 'admin', 'e10adc3949ba59abbe56e057f20f883e', 'hr@gmail.com', 'HR Manager', 'Active', '2022-07-02 12:11:03', NULL);
    ");
    

//checking if jobs table is already created
$sql2 ="CREATE TABLE IF NOT EXISTS  `jobs` (
    `id` int(100) NOT NULL,
    `Job_Reference_number` varchar(100) NOT NULL,
    `job_title` varchar(200) NOT NULL,
    `job_description` text NOT NULL,
    `job_status` varchar(100) NOT NULL,
    `date` datetime NOT NULL DEFAULT current_timestamp()
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  
  
  ";
  $rest2=mysqli_query($conn,$sql2);
  //add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `jobs`
    ADD PRIMARY KEY (`id`),
    ADD UNIQUE KEY `Job_Reference_number` (`Job_Reference_number`);
    ");
    mysqli_query($conn,"ALTER TABLE `jobs`
    MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;");
  

//checking if skills table is already created
$sql3 ="CREATE TABLE IF NOT EXISTS  `skills` (
    `id` int(10) NOT NULL,
    `EOInumber` varchar(100) NOT NULL,
    `skillCheckboxes` varchar(200) NOT NULL,
    `Other_skills` text NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  
  
  ";
  $rest3=mysqli_query($conn,$sql3);
//add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `skills`
    ADD PRIMARY KEY (`id`),
    ADD KEY `EOInumber` (`EOInumber`);
    ");
    mysqli_query($conn,"ALTER TABLE `skills`
    MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;");

//checking if Accesslogs table is already created
$sql4 ="CREATE TABLE IF NOT EXISTS  `tbl_accesslog` (
    `id` int(3) NOT NULL,
    `ip` varchar(100) NOT NULL,
    `user` varchar(100) NOT NULL,
    `pass` varchar(100) NOT NULL,
    `date` datetime NOT NULL,
    `attempt` int(3) NOT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
  
  ";

  $rest4=mysqli_query($conn,$sql4);
//add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `tbl_accesslog`
  ADD PRIMARY KEY (`id`);
  ");
  mysqli_query($conn,"ALTER TABLE `tbl_accesslog`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;");

//checking if lockaccount table is already created
$sql5 ="CREATE TABLE IF NOT EXISTS  `tbl_lockaccount` (
  `id` int(100) NOT NULL,
  `user` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

  
  ";
  $rest5=mysqli_query($conn,$sql5);
//add primary key and auto-increment
    mysqli_query($conn,"ALTER TABLE `tbl_lockaccount`
    ADD PRIMARY KEY (`id`);
    "); 
    mysqli_query($conn,"ALTER TABLE `tbl_lockaccount`
    MODIFY `id` int(100) NOT NULL AUTO_INCREMENT;");

?>