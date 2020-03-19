-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 02, 2018 at 02:29 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `phrs`
--

-- --------------------------------------------------------

--
-- Table structure for table `allergies`
--

CREATE TABLE IF NOT EXISTS `allergies` (
  `allergy_id` int(11) NOT NULL AUTO_INCREMENT,
  `allergy_description` varchar(255) NOT NULL,
  PRIMARY KEY (`allergy_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `birth_history`
--

CREATE TABLE IF NOT EXISTS `birth_history` (
  `birth_history_id` int(11) NOT NULL AUTO_INCREMENT,
  `preterm` varchar(3) DEFAULT NULL,
  `full_term` varchar(3) DEFAULT NULL,
  `type_of_delivery` varchar(255) DEFAULT NULL,
  `nsd` varchar(3) DEFAULT NULL,
  `cs` varchar(3) DEFAULT NULL,
  `birth_weight` varchar(50) DEFAULT NULL,
  `bw_percentile` varchar(10) DEFAULT NULL,
  `birth_head_circumference` varchar(50) DEFAULT NULL,
  `bhc_percentile` varchar(10) DEFAULT NULL,
  `birth_length` varchar(50) DEFAULT NULL,
  `bl_percentile` varchar(10) DEFAULT NULL,
  `birth_chest_circumference` varchar(50) DEFAULT NULL,
  `bcc_percentile` varchar(10) DEFAULT NULL,
  `blood_type` varchar(30) DEFAULT NULL,
  `birth_abdominal_circumference` varchar(50) DEFAULT NULL,
  `patient_patient_id` int(11) NOT NULL,
  PRIMARY KEY (`birth_history_id`,`patient_patient_id`),
  KEY `fk_birth_history_patient1` (`patient_patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


--
-- Table structure for table `blood_types`
--

CREATE TABLE IF NOT EXISTS `blood_types` (
  `blood_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `blood_type` varchar(10) NOT NULL,
  PRIMARY KEY (`blood_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `blood_types`
--

INSERT INTO `blood_types` (`blood_type_id`, `blood_type`) VALUES
(1, 'O+'),
(2, 'O-'),
(3, 'A+'),
(4, 'A+'),
(5, 'B+'),
(6, 'B+'),
(7, 'AB+'),
(8, 'AB+');

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE IF NOT EXISTS `chat` (
  `chat_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `date_sent` int(11) DEFAULT NULL,
  PRIMARY KEY (`chat_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;



-- --------------------------------------------------------

--
-- Table structure for table `immunization_record`
--

CREATE TABLE IF NOT EXISTS `immunization_record` (
  `immunization_record_id` int(11) NOT NULL AUTO_INCREMENT,
  `vaccines` varchar(255) DEFAULT NULL,
  `first` date DEFAULT NULL,
  `second` date DEFAULT NULL,
  `third` date DEFAULT NULL,
  `booster_one` date DEFAULT NULL,
  `booster_two` date DEFAULT NULL,
  `booster_three` date DEFAULT NULL,
  `other_vaccine` varchar(255) DEFAULT NULL,
  `reaction` varchar(255) DEFAULT NULL,
  `patient_patient_id` int(11) NOT NULL,
  PRIMARY KEY (`immunization_record_id`,`patient_patient_id`),
  KEY `fk_immunization_record_patient1` (`patient_patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4126 ;


-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `from` varchar(45) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `users_user_id` int(11) NOT NULL,
  PRIMARY KEY (`message_id`,`users_user_id`),
  KEY `fk_messages_users1` (`users_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `sex` varchar(10) NOT NULL,
  `birth_date` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `school` varchar(100) DEFAULT NULL,
  `father_name` varchar(100) NOT NULL,
  `father_age` int(11) NOT NULL,
  `father_contact_no` varchar(50) DEFAULT NULL,
  `mother_name` varchar(100) NOT NULL,
  `mother_age` int(11) NOT NULL,
  `mother_contact_no` varchar(50) DEFAULT NULL,
  `picture` varchar(50) DEFAULT NULL,
  `date_entered` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8341 ;

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE IF NOT EXISTS `reservations` (
  `reservation_id` int(11) NOT NULL AUTO_INCREMENT,
  `priority` varchar(4) DEFAULT NULL,
  `date_reserved` date DEFAULT NULL,
  `status` varchar(10) DEFAULT NULL,
  `total` float DEFAULT NULL,
  `patient_patient_id` int(11) NOT NULL,
  PRIMARY KEY (`reservation_id`,`patient_patient_id`),
  KEY `fk_reservations_patient1` (`patient_patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25127 ;


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `admin` varchar(1) DEFAULT NULL,
  `logged` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `admin`, `logged`) VALUES
(1, 'admin', 'abb154a24de57a71fa65d6be11992662174877cd', 'Y', 'N')

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE IF NOT EXISTS `vaccines` (
  `vaccine_id` int(11) NOT NULL AUTO_INCREMENT,
  `vaccine_description` varchar(255) NOT NULL,
  PRIMARY KEY (`vaccine_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`vaccine_id`, `vaccine_description`) VALUES
(1, 'BCG'),
(2, 'Hepatitis B'),
(3, 'DTwP / DTap'),
(4, 'OPV / IPV'),
(5, 'H. Influenza type B'),
(6, 'Rotavirus'),
(7, 'Pneumococcal Conjugate Vaccine'),
(8, 'Measles'),
(9, 'Influenza'),
(10, 'Varicella'),
(11, 'MMR'),
(12, 'Hepatitis A'),
(13, 'Typhoid'),
(14, 'Meningococcal'),
(15, 'HPV'),
(16, 'Others'),
(17, 'ALLERGIES');

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE IF NOT EXISTS `visits` (
  `visit_id` int(11) NOT NULL AUTO_INCREMENT,
  `date_of_visit` date DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `temperature` varchar(10) DEFAULT NULL,
  `weight` varchar(10) DEFAULT NULL,
  `height` varchar(10) DEFAULT NULL,
  `complaints` varchar(255) DEFAULT NULL,
  `physician_findings` varchar(255) DEFAULT NULL,
  `treatment` varchar(255) DEFAULT NULL,
  `charge` float DEFAULT NULL,
  `insurance` varchar(20) DEFAULT NULL,
  `patient_patient_id` int(11) NOT NULL,
  PRIMARY KEY (`visit_id`,`patient_patient_id`),
  KEY `fk_patient_visits_patient1` (`patient_patient_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=28768 ;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `birth_history`
--
ALTER TABLE `birth_history`
  ADD CONSTRAINT `fk_birth_history_patient1` FOREIGN KEY (`patient_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `immunization_record`
--
ALTER TABLE `immunization_record`
  ADD CONSTRAINT `fk_immunization_record_patient1` FOREIGN KEY (`patient_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `fk_messages_users1` FOREIGN KEY (`users_user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `fk_reservations_patient1` FOREIGN KEY (`patient_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `fk_patient_visits_patient1` FOREIGN KEY (`patient_patient_id`) REFERENCES `patient` (`patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
