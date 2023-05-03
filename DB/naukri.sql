-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jul 11, 2021 at 07:13 AM
-- Server version: 5.7.31
-- PHP Version: 7.3.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `naukri`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(191) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` varchar(191) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `firstname`, `lastname`, `email`, `password`, `created_at`, `updated_at`) VALUES
(3, 'Debraz', 'Goswami', 'debraz@gmail.com', '$2y$10$moCry3Pe.odNu93mPnlFOOs1iAuI/CFA2soWk0ExEY4yz7B2.zV0O', 'May 14, 21', 'July 02, 21');

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

DROP TABLE IF EXISTS `blogs`;
CREATE TABLE IF NOT EXISTS `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `slug`, `category_id`, `image`, `description`, `created_at`, `updated_at`) VALUES
(5, '6 inspirational Jack Ma quotes for entrepreneurs and startups', '6-inspirational-jack-ma-quotes-for-entrepreneurs-and-startups', 6, 'international_youth_day.jpg', '&lt;p&gt;Ma is a trubiggest e rags-to-riches story . One off the IPO in history, Alibaba founder and chairman Jack Ma is now the richest man in china, worth an estimated $29.7 billion, which includes his 7.8% stake in Alibaba and a nearly 50% stake in payment processing service Alipay. Jack Ma (a.k.a. Ma Yun) was born on October 15, 1964, in Hangzhou, located in the southeastern part of China. He grew up poor in communist China and knew that without money or connections, the only way he could get ahead was through education. He failed his college entrance exam twice, and was rejected from dozens of jobs, including one at KFC, before finding success with his third internet company, Alibaba.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Here are some of his favourite quotes:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ol&gt;\r\n	&lt;li&gt;Never give up. Today is hard, tomorrow will be worse, but the day after tomorrow will be sunshine - The secret to success is to keep your dream alive. You must keep your dream alive because it might come true someday.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;I try to make myself happy, not because I know that if I&amp;#39;m not happy, my colleagues are not happy and my shareholders are not happy and my customers are not happy- CUSTOMERS ARE NUMBER, Jack Ma always puts his customers first and he has a very interesting motto: &amp;ldquo;Customers first, Employees second, Shareholders third.&amp;rdquo;&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;I want to change history, do something important in my life, and influence individuals like we have with millions of small businesses on Alibaba. Then they love and respect you because you made their life important- As a CEO, Jack Ma has to say no to thousands of opportunities every day. However, he always stays focused because he only considers opportunities that are aligned with the mission of his business.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;The lessons I learned from the dark days at Alibaba are that you&amp;#39;ve got to make your team have value, innovation, and vision. Also, if you don&amp;#39;t give up, you still have a chance. And, when you are small, you have to be very focused and rely on your brain,not your strength - Don&amp;rsquo;t complain, look for opportunities.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;Before I left China, I was educated that China was the richest, happiest country in the world. So when I arrived Australia, I thought, &amp;#39;Oh my God, everything is different from what I was told.&amp;#39; Since then, I started to think differently- Have passion, right from day 1.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;I got my story, my dream, from America. The hero I had is Forrest Gump... I like that guy. I&amp;#39;ve been watching that movie about 10 times. Every time I get frustrated, I watch the movie. I watched the movie before I came here again to New York. I watched the movie again telling me that no matter whatever changed, you are you- Stay focused, the need to say no.&lt;/li&gt;\r\n&lt;/ol&gt;\r\n', 'July 08, 2021', 'July 08, 2021'),
(7, 'How to Answer: Why did you Leave Your Last Job?', 'how-to-answer:-why-did-you-leave-your-last-job?', 7, 'stressnew.jpg', '&lt;p&gt;Whether you are leaving a job or searching for a new one, there are a few common interview questions which you must know how to answer.&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;lsquo;Why did you leave your last job?&amp;rsquo; is one such question you&amp;rsquo;ll find being asked in almost every interview. In fact, according to a Monster Poll, interviewing is 2&lt;sup&gt;nd&lt;/sup&gt; hardest part of changing a job.&lt;/p&gt;\r\n\r\n&lt;p&gt;So, what&amp;rsquo;s the motive behind asking this question?&lt;/p&gt;\r\n\r\n&lt;p&gt;Although, most recruiters know what the probable answer will be but the sole purpose to ask this is to understand your area of motivation.&lt;/p&gt;\r\n\r\n&lt;p&gt;Recruiters usually try to test your personality in order to check whether you are a good fit as per company&amp;rsquo;s culture or not and this question helps them understand what inspires you to leave your previous organization.&lt;/p&gt;\r\n\r\n&lt;p&gt;So, the moment you make up your mind to leave your organisation and try for a new job you must make a quick list of your reasons why you would like to leave your job and take up a new one.&lt;/p&gt;\r\n\r\n&lt;p&gt;The interviewer may not ask this question directly or maybe he does but whatever is the situation you must be prepared to handle this question.&lt;/p&gt;\r\n\r\n&lt;p&gt;There are a few variations that the recruiters might use to ask this question from you. Some of the possible variations are listed as follows.&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Variations of this question:&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;What interests you to look for a new job now?&lt;/li&gt;\r\n	&lt;li&gt;What are your reasons to search for a new job?&lt;/li&gt;\r\n	&lt;li&gt;Why would you like to move in a new job role?&lt;/li&gt;\r\n	&lt;li&gt;What made you resign from your last job role?&lt;/li&gt;\r\n	&lt;li&gt;Why you made your mind to leave your job?&lt;/li&gt;\r\n	&lt;li&gt;Why do you want to opt for a new job?&lt;/li&gt;\r\n	&lt;li&gt;Why did you leave your recent position?&lt;/li&gt;\r\n	&lt;li&gt;Why would you like to move from your present organization?&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;Tips to answer: Why did you leave your last job? &lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;&lt;strong&gt;Try to be positive: &lt;/strong&gt;You must keep your focus on being positive while you answer this question. No matter how strong the urge to bad mouth your last organisation or any of its employees, never ever do it.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n\r\n&lt;p&gt;Instead talk about:&lt;/p&gt;\r\n\r\n&lt;p&gt;You are looking for challenges&lt;/p&gt;\r\n\r\n&lt;p&gt;You are stuck in the same job role and want to grow&lt;/p&gt;\r\n\r\n&lt;p&gt;You were hired for a certain role but over time that changed&lt;/p&gt;\r\n\r\n&lt;p&gt;Your learning has stopped&lt;/p&gt;\r\n\r\n&lt;p&gt;You are not enjoying your work (and explain the why)&lt;br /&gt;\r\nYou re-evaluated your career goals decided a change is required&lt;/p&gt;\r\n\r\n&lt;p&gt;There&amp;rsquo;s no opportunity to advance my career in the current role&lt;br /&gt;\r\nMy abilities are not being used to the fullest&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;&lt;em&gt;Examples:&lt;/em&gt;&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&amp;ldquo;The client in my last organization went off with business due to which the company had to switch the role of a few employees. I wanted to work in a similar job role and as per the job description sent by your organization, I find myself fit for the job role hence I want to take-up this new opportunity.&amp;rdquo;&lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;em&gt;&amp;ldquo;It&amp;rsquo;s almost been three years with the organization and I have devoted and work on good projects gave more than my 100% and learned a lot so, now I am ready for a senior role and I want to change for better career growth.&amp;rdquo; &lt;/em&gt;&lt;/p&gt;\r\n\r\n&lt;ul&gt;\r\n	&lt;li&gt;&lt;strong&gt;Don&amp;rsquo;t make it personal: &lt;/strong&gt;The recruiters want to know your professional reasons which made you leave the job so, try to keep this conversation professional. No matter how much the recruiter makes you comfortable or starts to share a good rapport during the interview, you must maintain professionalism.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;&lt;strong&gt;Highlight how the new role is exciting: &lt;/strong&gt;One of the best ways to wriggle out of this question is to focus on the new job role and conclude using the advanced responsibilities you will be entrusted within new role. While focusing on this role you must not dilute the essence of the last role completely as this might create a negative impression about you in the mind of the recruiter.&lt;br /&gt;\r\n	&amp;nbsp;&lt;/li&gt;\r\n	&lt;li&gt;&lt;strong&gt;Keep it short and simple: &lt;/strong&gt;Keep the answer short and to the point, as stretching the answer may land you in hot waters.&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 'July 08, 2021', 'July 08, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `category`, `slug`, `created_at`, `updated_at`) VALUES
(6, 'StartUps', 'startups', 'July 07, 2021', NULL),
(7, 'Interview Tips', 'interview-tips', 'July 07, 2021', NULL),
(8, 'Job Search Strategy', 'job-search-strategy', 'July 07, 2021', 'July 07, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `candidates`
--

DROP TABLE IF EXISTS `candidates`;
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `fathername` varchar(100) DEFAULT NULL,
  `dob` varchar(100) DEFAULT NULL,
  `marital_status` varchar(100) DEFAULT NULL,
  `nationality` varchar(100) DEFAULT NULL,
  `expected_salary` int(11) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `job_experience_id` int(11) NOT NULL,
  `functional_area_id` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `summary` text,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `candidates`
--

INSERT INTO `candidates` (`id`, `firstname`, `lastname`, `email`, `password`, `phone`, `fathername`, `dob`, `marital_status`, `nationality`, `expected_salary`, `country`, `state_id`, `city_id`, `industry_id`, `job_experience_id`, `functional_area_id`, `gender`, `resume`, `photo`, `summary`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Diksha', 'Sandilya', 'diksha@gmail.com', '$2y$10$boMQSKyaJFx.TrV2HEeEg.doymt8jDnfJw3IWlxAzwpgs04TkqdCu', 9101001201, 'Nitul Sarma', '1997-11-08', 'Single', 'Indian', 25000, 'India', 5, 3, 6, 4, 3, 'Female', 'RESUME.doc', 'IMG-20200521-WA0007.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec pretium odio non mollis vulputate. Proin ac interdum lectus. Suspendisse potenti. Duis rhoncus leo arcu, euismod imperdiet est lobortis sit amet. Sed pretium aliquet augue nec dictum. Cras non rhoncus quam. Vivamus scelerisque tellus sapien, nec congue sapien congue eu. Aenean non nisi ligula. ', 1, 'June 26, 21', 'July 11, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

DROP TABLE IF EXISTS `cities`;
CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `city`, `slug`, `state_id`, `country`, `created_at`, `updated_at`) VALUES
(3, 'Golaghat', 'golaghat', 5, 'India', 'May 18, 21', NULL),
(4, 'Jorhat', 'jorhat', 5, 'India', 'May 18, 21', NULL),
(5, 'Balijan', 'balijan', 6, 'India', 'May 18, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

DROP TABLE IF EXISTS `companies`;
CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` bigint(20) NOT NULL,
  `companyname` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(4) DEFAULT '0',
  `is_featured` tinyint(4) DEFAULT '0',
  `verified` tinyint(4) DEFAULT '0',
  `featured_start_date` varchar(100) DEFAULT NULL,
  `featured_end_date` varchar(100) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `package_start_date` varchar(100) DEFAULT NULL,
  `package_end_date` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `firstname`, `lastname`, `email`, `phone`, `companyname`, `slug`, `industry_id`, `country`, `state_id`, `city_id`, `logo`, `description`, `status`, `is_featured`, `verified`, `featured_start_date`, `featured_end_date`, `package_id`, `package_start_date`, `package_end_date`, `password`, `created_at`, `updated_at`) VALUES
(25, 'Debraz', 'Goswami', 'debraz@gmail.com', 9101301002, 'TCS', 'tcs', 1, 'India', 5, 3, '45-458741_transparent-tcs-logo-png-tata-consultancy-services-logo.jpg', 'TCS, one of the fastest-growing digital, business consulting &amp; technology services providers, is a $500 million firm based in New York. Since inception in 2001, Synechron has been on a steep growth trajectory. With 8,000+ professionals operating in 18 countries across the world, it has presence across USA, Canada, UK, France, The Netherlands, Switzerland, Luxembourg, Serbia, Germany, Italy, UAE, Singapore, Hong Kong, Japan, Australia and Development Centers in India.', 1, 1, 1, '2021-06-28', '2022-06-28', 1, '2021-06-30', '2021-07-28', '$2y$10$Y95e.BmA8IswWEPUB6bLgeHSjRlNmV8LSz6fSECCG9SY7Xo30A/3G', 'May 19, 21', 'June 30, 21');

-- --------------------------------------------------------

--
-- Table structure for table `featuring_amount`
--

DROP TABLE IF EXISTS `featuring_amount`;
CREATE TABLE IF NOT EXISTS `featuring_amount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_amount` int(11) DEFAULT NULL,
  `company_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `featuring_amount`
--

INSERT INTO `featuring_amount` (`id`, `job_amount`, `company_amount`) VALUES
(8, 350, 999);

-- --------------------------------------------------------

--
-- Table structure for table `functional_areas`
--

DROP TABLE IF EXISTS `functional_areas`;
CREATE TABLE IF NOT EXISTS `functional_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `functional_area` varchar(200) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `functional_areas`
--

INSERT INTO `functional_areas` (`id`, `functional_area`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Accountant', 'accountant', 1, 'May 14, 21', NULL),
(11, 'Admin', 'admin', 1, 'May 15, 21', NULL),
(13, 'Software Engineer/Programmer', 'software-engineer/programmer', 1, 'May 15, 21', 'June 23, 21');

-- --------------------------------------------------------

--
-- Table structure for table `industries`
--

DROP TABLE IF EXISTS `industries`;
CREATE TABLE IF NOT EXISTS `industries` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `industry` varchar(150) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `industries`
--

INSERT INTO `industries` (`id`, `industry`, `slug`, `icon`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Human Resource', 'human-resource', 'group-46244.png', 1, 'May 15, 21', 'May 15, 21'),
(2, 'Textiles', 'textiles', 'building-44534.png', 0, 'May 15, 21', 'May 16, 21'),
(4, 'Health', 'health', 'ambulance-44410.png', 1, 'May 15, 21', NULL),
(5, 'Agriculture', 'agriculture', 'amazon-44447.png', 1, 'June 17, 21', NULL),
(6, 'Banking', 'banking', 'building-44534.png', 1, 'June 17, 21', NULL),
(7, 'Automobile', 'automobile', 'automobile-44407.png', 1, 'June 17, 21', NULL),
(8, 'Teaching', 'teaching', 'comments-44609.png', 1, 'June 17, 21', NULL),
(9, 'Engineering', 'engineering', 'anchor-44448.png', 1, 'June 17, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE IF NOT EXISTS `jobs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` mediumint(9) NOT NULL,
  `job_title` varchar(150) NOT NULL,
  `slug` varchar(150) NOT NULL,
  `industry_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `functional_area_id` int(11) NOT NULL,
  `job_type_id` int(11) NOT NULL,
  `country` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL,
  `salary_from` int(11) NOT NULL,
  `salary_to` int(11) NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `job_experience_id` int(11) NOT NULL,
  `job_expiry_date` varchar(100) NOT NULL,
  `num_of_posts` int(11) NOT NULL,
  `description` text NOT NULL,
  `hide_salary` tinyint(4) NOT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `is_featured` tinyint(4) DEFAULT NULL,
  `verified` tinyint(4) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`id`, `job_id`, `job_title`, `slug`, `industry_id`, `company_id`, `functional_area_id`, `job_type_id`, `country`, `state_id`, `city_id`, `gender`, `salary_from`, `salary_to`, `qualification_id`, `job_experience_id`, `job_expiry_date`, `num_of_posts`, `description`, `hide_salary`, `status`, `is_featured`, `verified`, `created_at`, `updated_at`) VALUES
(2, 7774, 'Chura Liya Hein Tumne', 'chura-liya-hein-tumne', 1, 25, 13, 4, 'India', 6, 5, 'Male', 400000, 600000, 3, 4, '2021-05-31', 1, '&lt;p&gt;Job Description Key Objective of the Job: Responsible for achieving the collections target in the assigned area while ensuring that SOPs and legal norms are followed as per process and organizational policy&lt;/p&gt;\r\n', 0, 1, 1, 1, '2021-05-24', '2021-07-05'),
(52, 2524, 'Chura Liya', 'chura-liya', 1, 25, 13, 3, 'India', 6, 5, 'Male', 25000, 32000, 4, 3, '2021-07-28', 11, '&lt;p&gt;Responsible for activities which in turn help the organization in making strategic decisions, would require efficiency to complete the work in dedicated time frame. Maintaining cross functional contacts to be&lt;/p&gt;\r\n', 0, 1, 1, 1, '2021-06-10', '2021-06-23'),
(53, 1343, 'Dil Diya hain', 'dil-diya-hain', 1, 25, 3, 3, 'India', 6, 5, 'Both', 12000, 15000, 3, 4, '2021-07-30', 11, '&lt;p&gt;dil dil dil dil dil dil dil dil deewana deewana&lt;/p&gt;\r\n\r\n&lt;p&gt;ho gaya ho gaya ho gaya ho gaya ree eee e ee&lt;/p&gt;\r\n', 1, 1, NULL, 1, '2021-06-16', 'June 29, 21'),
(54, 2522, 'Java Developer', 'java-developer', 1, 25, 13, 3, 'India', 5, 3, 'Male', 45000, 60000, 4, 4, '2021-06-28', 2, '&lt;ul&gt;\r\n	&lt;li&gt;Well versed in Core Java, OOPs concepts, collections, multi-threading, concurrency, lambdas, and streams.&lt;/li&gt;\r\n	&lt;li&gt;Hands-on knowledge of Spring Core, MVC, JPA, Security, transaction&lt;/li&gt;\r\n	&lt;li&gt;Working knowledge of REST API designing as well as development, using Spring.&lt;/li&gt;\r\n	&lt;li&gt;Exposure to Spring Boot, Docker, Kubernetes, OpenShift for the microservices environment.&lt;/li&gt;\r\n	&lt;li&gt;Savvy with SQL and database concepts.&lt;/li&gt;\r\n	&lt;li&gt;Ability to use frameworks like JUnit, Mockito, etc., for implementing unit testing.&lt;/li&gt;\r\n	&lt;li&gt;Sound understanding of code versioning tools, such as Git/bit bucket with Maven.&lt;/li&gt;\r\n	&lt;li&gt;Should have worked in a CI/CD environment with TeamCity/Jenkins&amp;quot;&lt;br /&gt;\r\n	CTC: As Per Industry Standard&lt;br /&gt;\r\n	Industry:Investment Banking&lt;/li&gt;\r\n&lt;/ul&gt;\r\n', 0, 1, 1, 1, '2021-06-10', '2021-06-23'),
(55, 1346, 'Dil Diya hain', 'dil-diya-hain', 1, 25, 3, 3, 'India', 6, 5, 'Both', 12000, 15000, 3, 4, '2021-06-30', 11, 'namanaman mamaman jjsnxjsnxsjx', 0, NULL, NULL, NULL, '2021-06-16', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_applied`
--

DROP TABLE IF EXISTS `job_applied`;
CREATE TABLE IF NOT EXISTS `job_applied` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'Applied',
  `applied_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `job_applied`
--

INSERT INTO `job_applied` (`id`, `candidate_id`, `job_id`, `company_id`, `status`, `applied_at`, `updated_at`) VALUES
(15, 1, 1343, 25, 'Applied', 'June 29, 2021', NULL),
(18, 1, 2524, 25, 'Applied', 'July 07, 2021', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_experiences`
--

DROP TABLE IF EXISTS `job_experiences`;
CREATE TABLE IF NOT EXISTS `job_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_experience` varchar(200) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `job_experiences`
--

INSERT INTO `job_experiences` (`id`, `job_experience`, `created_at`, `updated_at`) VALUES
(3, 'Fresher', 'May 16, 21', NULL),
(4, '1 Year', 'May 16, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_skills`
--

DROP TABLE IF EXISTS `job_skills`;
CREATE TABLE IF NOT EXISTS `job_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_skill` varchar(200) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `job_skills`
--

INSERT INTO `job_skills` (`id`, `job_skill`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(9, 'PHP', 'php', 1, 'June 10, 21', NULL),
(10, 'Illustrator', 'illustrator', 1, 'June 10, 21', 'June 10, 21'),
(11, 'Photoshop', 'photoshop', 1, 'June 10, 21', NULL),
(12, 'Java', 'java', 1, 'June 23, 21', NULL),
(13, 'Cloud Computing', 'cloud-computing', 1, 'July 07, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `job_types`
--

DROP TABLE IF EXISTS `job_types`;
CREATE TABLE IF NOT EXISTS `job_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_type` varchar(200) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `job_types`
--

INSERT INTO `job_types` (`id`, `job_type`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Contractual', 'contractual', 1, 'May 16, 21', NULL),
(4, 'Permanent', 'permanent', 1, 'May 16, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `manage_candidate_experiences`
--

DROP TABLE IF EXISTS `manage_candidate_experiences`;
CREATE TABLE IF NOT EXISTS `manage_candidate_experiences` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `experience_title` varchar(100) NOT NULL,
  `company` varchar(100) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `start_date` varchar(100) NOT NULL,
  `end_date` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_candidate_experiences`
--

INSERT INTO `manage_candidate_experiences` (`id`, `candidate_id`, `experience_title`, `company`, `state_id`, `city_id`, `start_date`, `end_date`, `description`, `created_at`, `updated_at`) VALUES
(1, 1, 'Operation Manager', 'Jabra Pvt. Ltd.', 6, 5, '2016-07-19', '2018-04-06', 'I was working as a Operation Manager there. In these working years, I have gathered a lot of experience.', 'July 06, 2021', 'July 10, 2021'),
(2, 1, 'Area Sales Manager', 'Peters Surgical India Pvt. Ltd.', 5, 3, '2020-06-01', '2021-06-22', 'Having minimum 2 years successfull managerial experience, exposure to corporate hospitals working.', 'July 06, 2021', 'July 10, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `manage_candidate_languages`
--

DROP TABLE IF EXISTS `manage_candidate_languages`;
CREATE TABLE IF NOT EXISTS `manage_candidate_languages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `language` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_candidate_languages`
--

INSERT INTO `manage_candidate_languages` (`id`, `candidate_id`, `language`, `created_at`, `updated_at`) VALUES
(1, 1, 'Assamese', 'July 10, 2021', NULL),
(2, 1, 'Hindi', 'July 10, 2021', NULL),
(3, 1, 'English', 'July 10, 2021', 'July 10, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `manage_candidate_qualifications`
--

DROP TABLE IF EXISTS `manage_candidate_qualifications`;
CREATE TABLE IF NOT EXISTS `manage_candidate_qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `qualification_id` int(11) NOT NULL,
  `institute` varchar(100) NOT NULL,
  `graduation_year` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `manage_candidate_qualifications`
--

INSERT INTO `manage_candidate_qualifications` (`id`, `candidate_id`, `qualification_id`, `institute`, `graduation_year`, `created_at`, `updated_at`) VALUES
(3, 1, 3, 'Debraj Roy College', 2017, 'July 06, 2021', NULL),
(6, 1, 5, 'Reliance College Jr.', 2014, 'July 10, 2021', 'July 10, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `manage_candidate_skills`
--

DROP TABLE IF EXISTS `manage_candidate_skills`;
CREATE TABLE IF NOT EXISTS `manage_candidate_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` mediumint(9) NOT NULL,
  `candidate_skill_id` int(11) NOT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `manage_candidate_skills`
--

INSERT INTO `manage_candidate_skills` (`id`, `candidate_id`, `candidate_skill_id`, `rating`, `created_at`, `updated_at`) VALUES
(12, 1, 9, 80, 'July 11, 2021', 'July 11, 2021'),
(13, 1, 11, 45, 'July 11, 2021', 'July 11, 2021'),
(14, 1, 12, 20, 'July 11, 2021', 'July 11, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `manage_job_skills`
--

DROP TABLE IF EXISTS `manage_job_skills`;
CREATE TABLE IF NOT EXISTS `manage_job_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `job_id` mediumint(9) NOT NULL,
  `job_skill_id` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=111 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `manage_job_skills`
--

INSERT INTO `manage_job_skills` (`id`, `job_id`, `job_skill_id`, `created_at`, `updated_at`) VALUES
(101, 2524, 10, '2021-06-14', NULL),
(105, 2522, 12, '2021-06-23', NULL),
(107, 2524, 11, '2021-06-23', NULL),
(108, 7774, 9, '2021-06-26', NULL),
(110, 1343, 11, '2021-06-26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `page_visitor`
--

DROP TABLE IF EXISTS `page_visitor`;
CREATE TABLE IF NOT EXISTS `page_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `candidate_id` int(11) NOT NULL,
  `ip_address` varchar(100) NOT NULL,
  `visited_on` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `page_visitor`
--

INSERT INTO `page_visitor` (`id`, `candidate_id`, `ip_address`, `visited_on`) VALUES
(1, 1, '127.0.0.1', 'July 04, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan` varchar(100) NOT NULL,
  `allowed_jobs` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `plan`, `allowed_jobs`, `amount`, `created_at`, `updated_at`) VALUES
(1, 'Basic', 30, 350, 'May 21, 21', 'June 16, 21'),
(2, 'Standard', 60, 550, 'May 21, 21', NULL),
(3, 'Premium', 90, 790, 'May 21, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `qualifications`
--

DROP TABLE IF EXISTS `qualifications`;
CREATE TABLE IF NOT EXISTS `qualifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `qualification` varchar(200) NOT NULL,
  `abbreviation` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `qualifications`
--

INSERT INTO `qualifications` (`id`, `qualification`, `abbreviation`, `slug`, `status`, `created_at`, `updated_at`) VALUES
(3, 'Bachelor Of Computer Applications', 'BCA', 'bca', 1, 'May 16, 21', 'June 10, 21'),
(4, 'Master Of Computer Applications', 'MCA', 'mca', 0, 'May 16, 21', NULL),
(5, 'Class 12', 'HS', 'hs', 1, 'July 10, 21', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `revenue`
--

DROP TABLE IF EXISTS `revenue`;
CREATE TABLE IF NOT EXISTS `revenue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `received_for` varchar(200) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`id`, `company_id`, `amount`, `received_for`, `created_at`) VALUES
(6, 25, 350, 'Featuring Job', 'June 29, 2021'),
(7, 25, 790, 'Premium Package Subscription', 'June 30, 2021'),
(8, 25, 350, 'Basic Package Subscription', 'June 30, 2021');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;
CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `state` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` varchar(100) NOT NULL,
  `updated_at` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `state`, `slug`, `country`, `created_at`, `updated_at`) VALUES
(5, 'Assam', 'assam', 'India', 'May 17, 21', NULL),
(6, 'Arunachal Pradesh', 'arunachal-pradesh', 'India', 'May 17, 21', NULL);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
