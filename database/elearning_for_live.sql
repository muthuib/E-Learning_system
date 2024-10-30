-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 29, 2024 at 02:46 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `elearning`
--

-- --------------------------------------------------------

--
-- Table structure for table `assignments`
--

CREATE TABLE `assignments` (
  `ASSIGNMENT_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `DUE_DATE` date DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assignments`
--

INSERT INTO `assignments` (`ASSIGNMENT_ID`, `COURSE_ID`, `TITLE`, `DESCRIPTION`, `DUE_DATE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 4, 'define web design', 'give brief description', NULL, '2024-10-24 12:32:04', '2024-10-24 12:33:49'),
(2, 4, 'assignment 2', 'sd', NULL, '2024-10-25 11:23:51', '2024-10-25 11:23:51');

-- --------------------------------------------------------

--
-- Table structure for table `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) NOT NULL,
  `user_id` varchar(64) NOT NULL,
  `created_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_assignment`
--

INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
('admin', '1', 1729669439),
('admin', '5', 1729670179),
('instructor', '2', 1729669439),
('instructor', '8', 1729756430),
('student', '3', 1729669439),
('student', '34', 1730113756),
('student', '9', 1729858949);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) NOT NULL,
  `type` smallint(6) NOT NULL,
  `description` text DEFAULT NULL,
  `rule_name` varchar(64) DEFAULT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, NULL, NULL, NULL, 1729669382, 1729669382),
('createPost', 2, 'Create a post', NULL, NULL, 1729669382, 1729669382),
('deletePost', 2, 'delete a post', NULL, NULL, 1729669382, 1729669382),
('instructor', 1, NULL, NULL, NULL, 1729669383, 1729669383),
('manageUsers', 2, 'manage Users', NULL, NULL, 1729669382, 1729669382),
('manageUsersPermission', 2, NULL, NULL, NULL, 1729669382, 1729669382),
('student', 1, NULL, NULL, NULL, 1729669383, 1729669383),
('updatePost', 2, 'Update a post', NULL, NULL, 1729669382, 1729669382),
('viewPost', 2, 'view a post', NULL, NULL, 1729669382, 1729669382);

-- --------------------------------------------------------

--
-- Table structure for table `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `auth_item_child`
--

INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('admin', 'createPost'),
('admin', 'deletePost'),
('admin', 'manageUsers'),
('admin', 'manageUsersPermission'),
('admin', 'updatePost'),
('admin', 'viewPost'),
('instructor', 'createPost'),
('instructor', 'deletePost'),
('instructor', 'updatePost'),
('instructor', 'viewPost'),
('student', 'createPost'),
('student', 'viewPost');

-- --------------------------------------------------------

--
-- Table structure for table `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) NOT NULL,
  `data` blob DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `CATEGORY_ID` int(11) NOT NULL,
  `CATEGORY_NAME` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`CATEGORY_ID`, `CATEGORY_NAME`) VALUES
(1, 'Web design and Development'),
(2, 'Android app development');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `COURSE_ID` int(11) NOT NULL,
  `COURSE_NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text DEFAULT NULL,
  `INSTRUCTOR_ID` int(11) DEFAULT NULL,
  `IMAGE` varchar(255) NOT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`COURSE_ID`, `COURSE_NAME`, `DESCRIPTION`, `INSTRUCTOR_ID`, `IMAGE`, `CREATED_AT`, `UPDATED_AT`) VALUES
(4, 'Software development', 'software', 8, '', '2024-10-23 12:41:42', '2024-10-24 05:47:23'),
(5, 'Networking', 'networking is the best', 8, '', '2024-10-24 05:23:59', '2024-10-25 11:21:50');

-- --------------------------------------------------------

--
-- Table structure for table `course_categories`
--

CREATE TABLE `course_categories` (
  `COURSE_ID` int(11) NOT NULL,
  `CATEGORY_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `ENROLLMENT_ID` int(11) NOT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `ENROLLED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`ENROLLMENT_ID`, `USER_ID`, `COURSE_ID`, `ENROLLED_AT`) VALUES
(2, 5, 5, '2024-10-24 07:04:12'),
(6, 9, 4, '2024-10-24 10:24:22'),
(7, 9, 5, '2024-10-24 11:06:27'),
(11, 34, 4, '2024-10-28 10:57:29');

-- --------------------------------------------------------

--
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `GRADE_ID` int(11) NOT NULL,
  `SUBMISSION_ID` int(11) DEFAULT NULL,
  `GRADE` float NOT NULL,
  `GRADED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`GRADE_ID`, `SUBMISSION_ID`, `GRADE`, `GRADED_AT`) VALUES
(40, 4, 13, '2024-10-29 08:31:22'),
(41, 5, 12, '2024-10-29 08:31:23'),
(42, 6, 14, '2024-10-29 08:31:23'),
(44, 3, 15, '2024-10-29 08:53:50');

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

CREATE TABLE `lessons` (
  `LESSON_ID` int(11) NOT NULL,
  `COURSE_ID` int(11) DEFAULT NULL,
  `TITLE` varchar(255) NOT NULL,
  `CONTENT` text DEFAULT NULL,
  `VIDEO_URL` varchar(255) DEFAULT NULL,
  `CREATED_AT` timestamp NOT NULL DEFAULT current_timestamp(),
  `UPDATED_AT` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lessons`
--

INSERT INTO `lessons` (`LESSON_ID`, `COURSE_ID`, `TITLE`, `CONTENT`, `VIDEO_URL`, `CREATED_AT`, `UPDATED_AT`) VALUES
(1, 4, 'Introduction to web development: lesson 1.', 'Web development refers to the creating, building, and maintaining of websites. It includes aspects such as web design, web publishing, web programming, and database management. It is the creation of an application that works over the internet i.e. websites.\r\n\r\nWeb Development\r\nWeb Development\r\n\r\nThe word Web Development is made up of two words, that is:\r\n\r\nWeb: It refers to websites, web pages or anything that works over the internet.\r\nDevelopment: It refers to building the application from scratch.\r\nWeb Development can be classified into two ways:\r\n\r\nFrontend Development\r\nBackend Development\r\nFrontend Development\r\nThe part of a website where the user interacts directly is termed as front end. It is also referred to as the ‘client side’ of the application.\r\n\r\n\r\n\r\nFrontend Roadmap\r\nFrontend Development Roadmap\r\nFrontend Development Roadmap\r\n\r\nPopular Frontend Technologies\r\nHTML: HTML stands for HyperText Markup Language. It is used to design the front end portion of web pages using markup language. It acts as a skeleton for a website since it is used to make the structure of a website.\r\nCSS: Cascading Style Sheets fondly referred to as CSS is a simply designed language intended to simplify the process of making web pages presentable. It is used to style our website.\r\nJavaScript: JavaScript is a scripting language used to provide a dynamic behavior to our website.\r\nBootstrap: Bootstrap is a free and open-source tool collection for creating responsive websites and web applications. It is the most popular CSS framework for developing responsive, mobile-first websites. Nowadays, the websites are perfect for all browsers (IE, Firefox, and Chrome) and for all sizes of screens (Desktop, Tablets, Phablets, and Phones).\r\nBootstrap 4\r\nBootstrap 5\r\nFrontend Libraries and Frameworks\r\nBackend Development\r\nBackend is the server side of a website. It is part of the website that users cannot see and interact with. It is the portion of software that does not come in direct contact with the users. It is used to store and arrange data.\r\n\r\nBackend Roadmap\r\nBackend Development Roadmap\r\nBackend Development Roadmap\r\n\r\nPopular Backend Technologies\r\nPHP: PHP is a server-side scripting language designed specifically for web development.\r\nJava: Java is one of the most popular and widely used programming languages. It is highly scalable.\r\nPython: Python is a programming language that lets you work quickly and integrate systems more efficiently.\r\nNode.js: Node.js is an open source and cross-platform runtime environment for executing JavaScript code outside a browser.\r\nBack End Frameworks and Technology\r\nPHP\r\nFramework: Laravel\r\nCMS: WordPress\r\nNodeJS\r\n\r\nFramework: Express\r\nPython\r\n\r\nFramework: Django, Flask\r\nPackage Manager: Python PIP\r\nRuby\r\n\r\nFramework: Ruby on Rails\r\nJava\r\nFramework: Spring, Hibernate\r\nC#\r\n\r\nFramework: .NET\r\nDatabase:\r\n\r\nRelation Database\r\nPostgre SQL\r\nMariaDB\r\nMySQL\r\nNoSql Database\r\nMongoDB\r\nDatabases\r\nIn web technology, a database is a structured collection of data that is stored electronically and accessed via a web application. It serves as the backend component where data is stored, managed, and retrieved. Databases can be relational (like MySQL, PostgreSQL) using structured tables and SQL for queries, or non-relational (like MongoDB, CouchDB) which store data in flexible, document-oriented formats. They enable web applications to handle dynamic content, user data, transactions, and more by providing efficient storage, retrieval, and manipulation capabilities. Database management systems (DBMS) are used to interact with the database, ensuring data integrity, security, and performance.\r\n\r\nRelational Database\r\nA relational database stores data in tables, similar to a spreadsheet, where each table has rows and columns. The rows hold individual records, and the columns define the data attributes. Tables can be linked to each other through special keys, allowing related data to be connected.\r\n\r\nPostgre SQL: PostgreSQL is a powerful, open-source relational database that supports advanced SQL features and complex queries. It handles structured data, ensures ACID compliance, and is known for its reliability and extensibility.\r\nMariaDB: MariaDB is an open-source relational database that evolved from MySQL, offering improved performance, security, and features. It supports SQL queries, ACID compliance, and is highly compatible with MySQL.\r\nMySQL: MySQL is an open-source relational database management system that uses SQL for managing structured data. It’s known for its reliability, ease of use, and performance, widely used in web applications.\r\nNoSql Database\r\nA NoSQL database stores data in a flexible, non-tabular format, unlike traditional relational databases. Instead of using tables with rows and columns, NoSQL databases might use documents, key-value pairs, wide-columns, or graphs to store data. This allows them to handle large amounts of unstructured or semi-structured data efficiently. They are designed to scale easily and manage big data applications.\r\n\r\nMongodb: MongoDB is a NoSQL database storing data in JSON-like documents. It handles unstructured data, supports powerful queries, and scales easily across servers, making it popular for flexible, scalable applications.\r\nCassandra: Apache Cassandra is an open-source NoSQL database that is used for handling big data. It has the capability to handle structure, semi-structured, and unstructured data.\r\nRedis: Redis is an in-memory NoSQL database known for its speed. It supports various data structures like strings, hashes, and lists, making it ideal for caching, real-time analytics, and messaging.\r\nWeb Development Tutorials\r\nHTML\r\nCSS\r\nJavaScript\r\njQuery\r\nBootstrap\r\nReact JS\r\nAngularJS\r\nPHP\r\nNode.js\r\nDjango\r\nFlask\r\nSome Important Links on Web Development\r\nBegin Web Development with a Head Start\r\nWhy do you need a Responsive Website\r\nTop 10 Frameworks for Web Applications\r\nWeb 1.0, Web 2.0 and Web 3.0 with their difference\r\n10 Web Development and Web Design Facts That You Should Know\r\nHow can I start to learn Web Development ?\r\nThe Future Of Web Development\r\nBest Books to Learn Front-End Web Development\r\nBest Books to Learn Back-End Web Development\r\n10 Things You Should Know As a Web Developer\r\nHow to choose a Technology Stack for Web Application Development ?\r\nTop 10 Tools That Every Web Developer Must Try Once\r\n', 'https://www.youtube.com/watch?v=F8xa9NSThn0', '2024-10-24 07:38:40', '2024-10-24 11:54:09');

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1729669286),
('m140506_102106_rbac_init', 1729669340),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1729669340),
('m180523_151638_rbac_updates_indexes_without_prefix', 1729669341),
('m200409_110543_rbac_update_mssql_trigger', 1729669341);

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE `submissions` (
  `SUBMISSION_ID` int(11) NOT NULL,
  `ASSIGNMENT_ID` int(11) DEFAULT NULL,
  `USER_ID` int(11) DEFAULT NULL,
  `CONTENT` text NOT NULL,
  `FILE_URL` varchar(255) DEFAULT NULL,
  `SUBMITTED_AT` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`SUBMISSION_ID`, `ASSIGNMENT_ID`, `USER_ID`, `CONTENT`, `FILE_URL`, `SUBMITTED_AT`) VALUES
(3, 1, 9, 'Web development refers to the creating, building, and maintaining of websites. It includes aspects such as web design, web publishing, web programming, and database management. It is the creation of an application that works over the internet i.e. websites.\r\n\r\nWeb Development\r\nWeb Development\r\n\r\nThe word Web Development is made up of two words, that is:\r\n\r\nWeb: It refers to websites, web pages or anything that works over the internet.\r\nDevelopment: It refers to building the application from scratch.\r\nWeb Development can be classified into two ways:\r\n\r\nFrontend Development\r\nBackend Development\r\nFrontend Development\r\nThe part of a website where the user interacts directly is termed as front end. It is also referred to as the ‘client side’ of the application.\r\n\r\n\r\n\r\nFrontend Roadmap\r\nFrontend Development Roadmap\r\nFrontend Development Roadmap\r\n\r\nPopular Frontend Technologies\r\nHTML: HTML stands for HyperText Markup Language. It is used to design the front end portion of web pages using markup language. It acts as a skeleton for a website since it is used to make the structure of a website.\r\nCSS: Cascading Style Sheets fondly referred to as CSS is a simply designed language intended to simplify the process of making web pages presentable. It is used to style our website.\r\nJavaScript: JavaScript is a scripting language used to provide a dynamic behavior to our website.\r\nBootstrap: Bootstrap is a free and open-source tool collection for creating responsive websites and web applications. It is the most popular CSS framework for developing responsive, mobile-first websites. Nowadays, the websites are perfect for all browsers (IE, Firefox, and Chrome) and for all sizes of screens (Desktop, Tablets, Phablets, and Phones).\r\nBootstrap 4\r\nBootstrap 5\r\nFrontend Libraries and Frameworks\r\nBackend Development\r\nBackend is the server side of a website. It is part of the website that users cannot see and interact with. It is the portion of software that does not come in direct contact with the users. It is used to store and arrange data.\r\n\r\nBackend Roadmap\r\nBackend Development Roadmap\r\nBackend Development Roadmap\r\n\r\nPopular Backend Technologies\r\nPHP: PHP is a server-side scripting language designed specifically for web development.\r\nJava: Java is one of the most popular and widely used programming languages. It is highly scalable.\r\nPython: Python is a programming language that lets you work quickly and integrate systems more efficiently.\r\nNode.js: Node.js is an open source and cross-platform runtime environment for executing JavaScript code outside a browser.\r\nBack End Frameworks and Technology\r\nPHP\r\nFramework: Laravel\r\nCMS: WordPress\r\nNodeJS\r\n\r\nFramework: Express\r\nPython\r\n\r\nFramework: Django, Flask\r\nPackage Manager: Python PIP\r\nRuby\r\n\r\nFramework: Ruby on Rails\r\nJava\r\nFramework: Spring, Hibernate\r\nC#\r\n\r\nFramework: .NET\r\nDatabase:\r\n\r\nRelation Database\r\nPostgre SQL\r\nMariaDB\r\nMySQL\r\nNoSql Database\r\nMongoDB\r\nDatabases\r\nIn web technology, a database is a structured collection of data that is stored electronically and accessed via a web application. It serves as the backend component where data is stored, managed, and retrieved. Databases can be relational (like MySQL, PostgreSQL) using structured tables and SQL for queries, or non-relational (like MongoDB, CouchDB) which store data in flexible, document-oriented formats. They enable web applications to handle dynamic content, user data, transactions, and more by providing efficient storage, retrieval, and manipulation capabilities. Database management systems (DBMS) are used to interact with the database, ensuring data integrity, security, and performance.\r\n\r\nRelational Database\r\nA relational database stores data in tables, similar to a spreadsheet, where each table has rows and columns. The rows hold individual records, and the columns define the data attributes. Tables can be linked to each other through special keys, allowing related data to be connected.\r\n\r\nPostgre SQL: PostgreSQL is a powerful, open-source relational database that supports advanced SQL features and complex queries. It handles structured data, ensures ACID compliance, and is known for its reliability and extensibility.\r\nMariaDB: MariaDB is an open-source relational database that evolved from MySQL, offering improved performance, security, and features. It supports SQL queries, ACID compliance, and is highly compatible with MySQL.\r\nMySQL: MySQL is an open-source relational database management system that uses SQL for managing structured data. It’s known for its reliability, ease of use, and performance, widely used in web applications.\r\nNoSql Database\r\nA NoSQL database stores data in a flexible, non-tabular format, unlike traditional relational databases. Instead of using tables with rows and columns, NoSQL databases might use documents, key-value pairs, wide-columns, or graphs to store data. This allows them to handle large amounts of unstructured or semi-structured data efficiently. They are designed to scale easily and manage big data applications.\r\n\r\nMongodb: MongoDB is a NoSQL database storing data in JSON-like documents. It handles unstructured data, supports powerful queries, and scales easily across servers, making it popular for flexible, scalable applications.\r\nCassandra: Apache Cassandra is an open-source NoSQL database that is used for handling big data. It has the capability to handle structure, semi-structured, and unstructured data.\r\nRedis: Redis is an in-memory NoSQL database known for its speed. It supports various data structures like strings, hashes, and lists, making it ideal for caching, real-time analytics, and messaging.\r\nWeb Development Tutorials\r\nHTML\r\nCSS\r\nJavaScript\r\njQuery\r\nBootstrap\r\nReact JS\r\nAngularJS\r\nPHP\r\nNode.js\r\nDjango\r\nFlask\r\nSome Important Links on Web Development\r\nBegin Web Development with a Head Start\r\nWhy do you need a Responsive Website\r\nTop 10 Frameworks for Web Applications\r\nWeb 1.0, Web 2.0 and Web 3.0 with their difference\r\n10 Web Development and Web Design Facts That You Should Know\r\nHow can I start to learn Web Development ?\r\nThe Future Of Web Development\r\nBest Books to Learn Front-End Web Development\r\nBest Books to Learn Back-End Web Development\r\n10 Things You Should Know As a Web Developer\r\nHow to choose a Technology Stack for Web Application Development ?\r\nTop 10 Tools That Every Web Developer Must Try Once\r\n', '', '2024-10-25 05:58:21'),
(4, 1, 8, 'dfrt', '', '2024-10-25 07:20:04'),
(5, 2, 8, 'szs', '', '2024-10-25 10:41:19'),
(6, 1, 34, 'fdfdgggg', '', '2024-10-28 09:37:55');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `PASSWORD` varchar(255) NOT NULL,
  `USERNAME` varchar(100) DEFAULT NULL,
  `FIRST_NAME` varchar(100) NOT NULL,
  `LAST_NAME` varchar(100) NOT NULL,
  `PHONE_NUMBER` varchar(15) DEFAULT NULL,
  `EMAIL` varchar(100) DEFAULT NULL,
  `AUTH_KEY` varchar(100) DEFAULT NULL,
  `ACCESS_TOKEN` varchar(100) DEFAULT NULL,
  `PASSWORD_RESET_TOKEN` varchar(100) DEFAULT NULL,
  `STATUS` smallint(6) DEFAULT NULL,
  `CREATED_AT` int(11) DEFAULT NULL,
  `UPDATED_AT` int(11) DEFAULT NULL,
  `VERIFICATION_TOKEN` varchar(100) DEFAULT NULL,
  `USER_ROLE` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`ID`, `PASSWORD`, `USERNAME`, `FIRST_NAME`, `LAST_NAME`, `PHONE_NUMBER`, `EMAIL`, `AUTH_KEY`, `ACCESS_TOKEN`, `PASSWORD_RESET_TOKEN`, `STATUS`, `CREATED_AT`, `UPDATED_AT`, `VERIFICATION_TOKEN`, `USER_ROLE`) VALUES
(5, '$2y$13$nuJyqJY0y6mCminoivT4AO72tquEsH.1cKVvg0CHJpOyZT6zgJVdS', NULL, 'System', 'Admin', NULL, 'benmuthui98@gmail.com', 'CuI5Gt0Dz5z_XUXwqYUEK5LJJ3Jxn2gg', 'vEHJJ5k0a1X7eQwWhAhvCb1eBlkWXBlx', 'ixmksZPO2cuvGHdFgpfAmM6GQF3HBkms_1729671743', 10, 1729668697, 1729671743, NULL, 20),
(8, '$2y$13$eLMZNx2wIZnjiVVWZjqLNeRrcyaQHauXXSrC7G/VWOuVxXbaorObq', NULL, 'James', 'Musyoka', NULL, 'muthuib220@gmail.com', 'sntVqSIIAS1bGb3QVpvz7N_y3t_QnjqE', 'uVrn1JsL-2Q1C3-NuhotsiChBxe8ipcw', NULL, 10, 1729671580, 1729671821, NULL, 20),
(9, '$2y$13$V4TehCdQFUKjGOJ8sHkAiOQR7Ay36L9xYGl9xM6T/blSl5KwweMT6', NULL, 'Benjamin ', 'Muthui', NULL, 'muthui@ext.uonbi.ac.ke', 'VSNXZZvMmMc849Hp-DGibDzWBshHmAmM', '_PrcZWiMcK_f9caM55hjEOxk-iPCR8Ut', NULL, 10, 1729756248, 1729756265, NULL, 20),
(34, '$2y$13$JepemAAMudmDGUMTpwDiPO1hjIIdVEolBwUozHgBww/c4LW0aEm8u', NULL, 'Ann', 'David', '0799937896', 'anniekasyoka1@gmail.com', 'LR6Gd8ciIr_4EfN2R-thUA1-Y2XGVe14', 'x2f0_Vznt8SL57uO3n5IswBgxF5c-48l', NULL, 10, 1730111659, 1730111682, NULL, 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assignments`
--
ALTER TABLE `assignments`
  ADD PRIMARY KEY (`ASSIGNMENT_ID`),
  ADD KEY `FK_ASSIGNMENT_COURSE` (`COURSE_ID`);

--
-- Indexes for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Indexes for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Indexes for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Indexes for table `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`CATEGORY_ID`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`COURSE_ID`),
  ADD KEY `FK_INSTRUCTOR` (`INSTRUCTOR_ID`);

--
-- Indexes for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD PRIMARY KEY (`COURSE_ID`,`CATEGORY_ID`),
  ADD KEY `FK_COURSE_CATEGORIES_CATEGORY` (`CATEGORY_ID`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`ENROLLMENT_ID`),
  ADD KEY `FK_STUDENT` (`USER_ID`),
  ADD KEY `FK_ENROLL_COURSE` (`COURSE_ID`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`GRADE_ID`),
  ADD KEY `FK_GRADE_SUBMISSION` (`SUBMISSION_ID`);

--
-- Indexes for table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`LESSON_ID`),
  ADD KEY `FK_COURSE` (`COURSE_ID`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `submissions`
--
ALTER TABLE `submissions`
  ADD PRIMARY KEY (`SUBMISSION_ID`),
  ADD KEY `FK_SUBMISSION_ASSIGNMENT` (`ASSIGNMENT_ID`),
  ADD KEY `FK_SUBMISSION_STUDENT` (`USER_ID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assignments`
--
ALTER TABLE `assignments`
  MODIFY `ASSIGNMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `CATEGORY_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `COURSE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `ENROLLMENT_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `GRADE_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `LESSON_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `submissions`
--
ALTER TABLE `submissions`
  MODIFY `SUBMISSION_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `assignments`
--
ALTER TABLE `assignments`
  ADD CONSTRAINT `FK_ASSIGNMENT_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `courses` (`COURSE_ID`) ON DELETE CASCADE;

--
-- Constraints for table `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `FK_INSTRUCTOR` FOREIGN KEY (`INSTRUCTOR_ID`) REFERENCES `user` (`ID`) ON DELETE SET NULL;

--
-- Constraints for table `course_categories`
--
ALTER TABLE `course_categories`
  ADD CONSTRAINT `FK_COURSE_CATEGORIES_CATEGORY` FOREIGN KEY (`CATEGORY_ID`) REFERENCES `categories` (`CATEGORY_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_COURSE_CATEGORIES_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `courses` (`COURSE_ID`) ON DELETE CASCADE;

--
-- Constraints for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD CONSTRAINT `FK_ENROLL_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `courses` (`COURSE_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_STUDENT` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `grades`
--
ALTER TABLE `grades`
  ADD CONSTRAINT `FK_GRADE_SUBMISSION` FOREIGN KEY (`SUBMISSION_ID`) REFERENCES `submissions` (`SUBMISSION_ID`) ON DELETE CASCADE;

--
-- Constraints for table `lessons`
--
ALTER TABLE `lessons`
  ADD CONSTRAINT `FK_COURSE` FOREIGN KEY (`COURSE_ID`) REFERENCES `courses` (`COURSE_ID`) ON DELETE CASCADE;

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `FK_SUBMISSION_ASSIGNMENT` FOREIGN KEY (`ASSIGNMENT_ID`) REFERENCES `assignments` (`ASSIGNMENT_ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_SUBMISSION_STUDENT` FOREIGN KEY (`USER_ID`) REFERENCES `user` (`ID`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
