-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2024 at 07:59 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- Database: `elearning`

-- --------------------------------------------------------
-- Table for Users (Students, Instructors, Admins)

CREATE TABLE `USER` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `PASSWORD` varchar(255) NOT NULL,
  `USERNAME` varchar(100) DEFAULT NULL,
  `PHONE_NUMBER` VARCHAR(15) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `AUTH_KEY` varchar(100) DEFAULT NULL,
  `ACCESS_TOKEN` varchar(100) DEFAULT NULL,
  `PASSWORD_RESET_TOKEN` varchar(100) DEFAULT NULL,
  `STATUS` smallint(6) DEFAULT NULL,
  `CREATED_AT` int(11) DEFAULT NULL,
  `UPDATED_AT` int(11) DEFAULT NULL,
  `VERIFICATION_TOKEN` varchar(100) DEFAULT NULL,
  `USER_ROLE` int(10) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Table for Courses
CREATE TABLE `COURSES` (
  `COURSE_ID` int(11) NOT NULL,
  `COURSE_NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `INSTRUCTOR_ID` int(11) DEFAULT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
    CONSTRAINT `FK_INSTRUCTOR` FOREIGN KEY (`INSTRUCTOR_ID`) REFERENCES `USER`(`ID`) ON DELETE SET NULL
);

-- Table for Lessons within a Course
CREATE TABLE `LESSONS` (
    `LESSON_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `COURSE_ID` INT,
    `TITLE` VARCHAR(255) NOT NULL,
    `CONTENT` TEXT,
    `VIDEO_URL` VARCHAR(255),
    `CREATED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `UPDATED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `COURSES`(`COURSE_ID`) ON DELETE CASCADE
);

-- Table for Course Enrollments (Students enrolled in courses)
CREATE TABLE `ENROLLMENTS` (
    `ENROLLMENT_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `USER_ID` INT,
    `COURSE_ID` INT,
    `ENROLLED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `FK_STUDENT` FOREIGN KEY (`USER_ID`) REFERENCES `USER`(`ID`) ON DELETE CASCADE,
    CONSTRAINT `FK_ENROLL_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `COURSES`(`COURSE_ID`) ON DELETE CASCADE
);

-- Table for Assignments or Quizzes in a Course
CREATE TABLE `ASSIGNMENTS` (
    `ASSIGNMENT_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `COURSE_ID` INT,
    `TITLE` VARCHAR(255) NOT NULL,
    `DESCRIPTION` TEXT,
    `DUE_DATE` DATE,
    `CREATED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `UPDATED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT `FK_ASSIGNMENT_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `COURSES`(`COURSE_ID`) ON DELETE CASCADE
);

-- Table for Student Submissions for Assignments
CREATE TABLE `SUBMISSIONS` (
    `SUBMISSION_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `ASSIGNMENT_ID` INT,
    `USER_ID` INT,
    `FILE_URL` VARCHAR(255),
    `SUBMITTED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `FK_SUBMISSION_ASSIGNMENT` FOREIGN KEY (`ASSIGNMENT_ID`) REFERENCES `ASSIGNMENTS`(`ASSIGNMENT_ID`) ON DELETE CASCADE,
    CONSTRAINT `FK_SUBMISSION_STUDENT` FOREIGN KEY (`USER_ID`) REFERENCES `USER`(`ID`) ON DELETE CASCADE
);

-- Table for Grades for Submissions
CREATE TABLE `GRADES` (
    `GRADE_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `SUBMISSION_ID` INT,
    `GRADE` FLOAT NOT NULL,
    `GRADED_AT` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `FK_GRADE_SUBMISSION` FOREIGN KEY (`SUBMISSION_ID`) REFERENCES `SUBMISSIONS`(`SUBMISSION_ID`) ON DELETE CASCADE
);

-- Table for Course Categories (e.g., Mathematics, Science)
CREATE TABLE `CATEGORIES` (
    `CATEGORY_ID` INT PRIMARY KEY AUTO_INCREMENT,
    `CATEGORY_NAME` VARCHAR(255) NOT NULL
);

-- Table for Many-to-Many Relationship between Courses and Categories
CREATE TABLE `COURSE_CATEGORIES` (
    `COURSE_ID` INT,
    `CATEGORY_ID` INT,
    PRIMARY KEY (`COURSE_ID`, `CATEGORY_ID`),
    CONSTRAINT `FK_COURSE_CATEGORIES_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `COURSES`(`COURSE_ID`) ON DELETE CASCADE,
    CONSTRAINT `FK_COURSE_CATEGORIES_CATEGORY` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `CATEGORIES`(`CATEGORY_ID`) ON DELETE CASCADE
);

COMMIT;