-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 14, 2025 at 06:49 PM
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
-- Database: `edulinkhub`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` enum('Admission','Job Exam','Skill-Based') NOT NULL,
  `description` text DEFAULT NULL,
  `pdf` varchar(255) NOT NULL,
  `uploadDate` date DEFAULT curdate(),
  `suggestedFor` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`suggestedFor`)),
  `isPaid` tinyint(1) DEFAULT 0,
  `price` decimal(10,2) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `image`, `author`, `category`, `description`, `pdf`, `uploadDate`, `suggestedFor`, `isPaid`, `price`, `createdAt`, `updatedAt`) VALUES
(1, 'College Admission Guide', 'https://example.com/images/book1.jpg', 'Dr. Robert Brown', 'Admission', 'Comprehensive guide to college admission process', 'https://example.com/books/book1.pdf', '2025-07-31', '[\"High School Students\", \"Parents\"]', 1, 19.99, '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(2, 'Job Interview Success', 'https://example.com/images/book2.jpg', 'Prof. Emily Davis', 'Job Exam', 'Master the art of job interviews', 'https://example.com/books/book2.pdf', '2025-07-31', '[\"Job Seekers\", \"Career Changers\"]', 1, 14.99, '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(3, 'Advanced Programming Skills', 'https://example.com/images/book3.jpg', 'Tech Expert', 'Skill-Based', 'Learn advanced programming techniques', 'https://example.com/books/book3.pdf', '2025-07-31', '[\"Developers\", \"Computer Science Students\"]', 0, NULL, '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(4, 'MBA Entrance Preparation', 'https://example.com/images/book4.jpg', 'Business Guru', 'Admission', 'Complete preparation for MBA entrance exams', 'https://example.com/books/book4.pdf', '2025-07-31', '[\"MBA Aspirants\", \"Working Professionals\"]', 1, 24.99, '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(5, 'Data Science Fundamentals', 'https://example.com/images/book5.jpg', 'Data Scientist', 'Skill-Based', 'Introduction to data science concepts', 'https://example.com/books/book5.pdf', '2025-07-31', '[\"Students\", \"Professionals\"]', 1, 12.99, '2025-07-31 16:57:07', '2025-07-31 16:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `book_reviews`
--

CREATE TABLE `book_reviews` (
  `id` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  `reviewId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `book_reviews`
--

INSERT INTO `book_reviews` (`id`, `bookId`, `reviewId`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 5, 5);

-- --------------------------------------------------------

--
-- Table structure for table `exam_units`
--

CREATE TABLE `exam_units` (
  `id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_units`
--

INSERT INTO `exam_units` (`id`, `university_id`, `unit`, `date`) VALUES
(1, 1, 'Mathematics', '2024-02-20'),
(2, 1, 'Computer Science Fundamentals', '2024-02-22'),
(3, 1, 'English Proficiency', '2024-02-25'),
(4, 2, 'AI Algorithms', '2024-03-05'),
(5, 2, 'Machine Learning', '2024-03-08'),
(6, 2, 'Neural Networks', '2024-03-12'),
(7, 3, 'Robotics Design', '2024-03-15'),
(8, 3, 'Control Systems', '2024-03-18'),
(9, 3, 'Autonomous Systems', '2024-03-22'),
(10, 4, 'Statistics', '2024-01-20'),
(11, 4, 'Data Analysis', '2024-01-23'),
(12, 4, 'Big Data Technologies', '2024-01-26'),
(13, 5, 'Quantum Mechanics', '2024-02-10'),
(14, 5, 'Quantum Algorithms', '2024-02-13'),
(15, 5, 'Quantum Information Theory', '2024-02-16');

-- --------------------------------------------------------

--
-- Table structure for table `fundings`
--

CREATE TABLE `fundings` (
  `id` int(11) NOT NULL,
  `type` enum('scholarship','professor') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `link` varchar(255) NOT NULL,
  `eligibilityCriteria` text DEFAULT NULL,
  `applyDate` date DEFAULT NULL,
  `applicationDeadline` date DEFAULT NULL,
  `university` varchar(255) DEFAULT NULL,
  `department` varchar(255) DEFAULT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fundings`
--

INSERT INTO `fundings` (`id`, `type`, `title`, `description`, `link`, `eligibilityCriteria`, `applyDate`, `applicationDeadline`, `university`, `department`, `professor_id`, `createdAt`, `updatedAt`) VALUES
(1, 'scholarship', 'Excellence in Computer Science', 'This scholarship supports outstanding students pursuing undergraduate degrees in Computer Science. Provides full tuition and a living stipend.', 'https://university.edu/scholarships/excellence-cs', 'Minimum GPA of 3.8, demonstrated financial need, and strong letters of recommendation.', '2023-09-01', '2024-03-15', 'Harvard University', 'Computer Science', NULL, '2025-07-31 16:51:12', '2025-07-31 16:51:12'),
(2, 'scholarship', 'Global Leaders Program', 'Merit-based scholarship for international students showing exceptional leadership potential. Covers tuition and accommodation.', 'https://university.edu/scholarships/global-leaders', 'International student status, leadership experience, and community involvement.', '2023-10-01', '2024-02-28', 'Stanford University', 'International Programs', NULL, '2025-07-31 16:51:12', '2025-07-31 16:51:12'),
(3, 'scholarship', 'AI Research Grant', 'Funding for professors conducting cutting-edge research in artificial intelligence and machine learning. Provides equipment and research assistant support.', 'https://university.edu/grants/ai-research', 'Tenured or tenure-track faculty position in Computer Science or related field.', '2023-11-01', '2024-04-15', 'MIT', 'Computer Science', NULL, '2025-07-31 16:51:12', '2025-08-14 12:07:21'),
(4, 'scholarship', 'Quantum Computing Initiative', 'Grant program supporting research in quantum computing and quantum information science. Includes funding for lab equipment and travel.', 'https://university.edu/grants/quantum-initiative', 'Faculty position in Physics, Computer Science, or Engineering with focus on quantum technologies.', '2023-12-01', '2024-05-30', 'Princeton University', 'Physics', NULL, '2025-07-31 16:51:12', '2025-08-14 12:07:30'),
(5, 'scholarship', 'Women in STEM Scholarship', 'Supports female students pursuing degrees in science, technology, engineering, and mathematics. Provides mentorship in addition to financial support.', 'https://university.edu/scholarships/women-stem', 'Female student enrolled in STEM program, minimum GPA of 3.5, and demonstrated commitment to community service.', '2023-09-15', '2024-04-01', 'UC Berkeley', 'STEM Programs', NULL, '2025-07-31 16:51:12', '2025-07-31 16:51:12'),
(6, 'scholarship', 'International Innovators Scholarship', 'Awarded to students with groundbreaking project ideas in tech and innovation.', 'https://university.edu/scholarships/innovators', 'Open to all students with a GPA above 3.5 and a proven innovation record.', '2023-09-20', '2024-03-10', 'Harvard University', 'Innovation Lab', 54, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(7, 'professor', 'AI Ethics Research Fund', 'Funding for professors exploring ethical implications of AI.', 'https://university.edu/grants/ai-ethics', 'Tenured faculty in AI-related fields.', '2023-10-10', '2024-05-01', 'Stanford University', 'Ethics in AI', 62, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(8, 'scholarship', 'Global Health Leaders Scholarship', 'Supports students pursuing degrees in public health with a global impact focus.', 'https://university.edu/scholarships/global-health', 'Students with leadership experience in health-related initiatives.', '2023-08-15', '2024-02-25', 'MIT', 'Public Health', 46, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(9, 'scholarship', 'Data Science Excellence Award', 'For students excelling in data science research.', 'https://university.edu/scholarships/data-science', 'GPA above 3.7 and published research in data science.', '2023-09-05', '2024-03-20', 'UC Berkeley', 'Data Science', 44, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(10, 'professor', 'Sustainable Energy Research Grant', 'Supports faculty researching renewable energy solutions.', 'https://university.edu/grants/sustainable-energy', 'Faculty with ongoing renewable energy research projects.', '2023-10-15', '2024-06-10', 'Princeton University', 'Environmental Science', 83, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(11, 'scholarship', 'Entrepreneurial Excellence Scholarship', 'For students launching impactful startups.', 'https://university.edu/scholarships/entrepreneurship', 'Business plan submission and GPA above 3.4.', '2023-09-12', '2024-03-18', 'Harvard University', 'Business Administration', 81, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(12, 'professor', 'Neuroscience Breakthrough Grant', 'Funds research in cutting-edge neuroscience topics.', 'https://university.edu/grants/neuroscience', 'Faculty in neuroscience or related fields.', '2023-11-05', '2024-04-22', 'MIT', 'Neuroscience', 56, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(13, 'scholarship', 'Women in AI Fellowship', 'Empowers female students in artificial intelligence fields.', 'https://university.edu/scholarships/women-ai', 'Female student in AI program with GPA above 3.5.', '2023-09-25', '2024-03-30', 'Stanford University', 'Artificial Intelligence', 36, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(14, 'scholarship', 'Climate Change Advocacy Scholarship', 'For students actively working on climate change projects.', 'https://university.edu/scholarships/climate-change', 'Proven climate activism experience.', '2023-09-18', '2024-04-05', 'UC Berkeley', 'Environmental Policy', 12, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(15, 'professor', 'Advanced Robotics Research Fund', 'Supports faculty developing next-gen robotics systems.', 'https://university.edu/grants/advanced-robotics', 'Faculty in robotics engineering.', '2023-10-28', '2024-06-20', 'Harvard University', 'Robotics', 53, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(16, 'scholarship', 'Cybersecurity Leaders Scholarship', 'For students with exceptional skills in cybersecurity.', 'https://university.edu/scholarships/cybersecurity', 'GPA above 3.6 and practical cybersecurity project experience.', '2023-09-08', '2024-03-25', 'MIT', 'Cybersecurity', 25, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(17, 'professor', 'Biomedical Innovations Grant', 'Funds innovative biomedical engineering research.', 'https://university.edu/grants/biomedical', 'Faculty in biomedical engineering.', '2023-10-12', '2024-05-15', 'Stanford University', 'Biomedical Engineering', 69, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(18, 'scholarship', 'Arts and Humanities Excellence Award', 'Supports students in arts and humanities research.', 'https://university.edu/scholarships/arts-humanities', 'GPA above 3.4 and a strong arts portfolio.', '2023-09-14', '2024-03-28', 'Princeton University', 'Computer Science', 67, '2025-08-14 09:59:07', '2025-08-14 10:47:37'),
(19, 'scholarship', 'Machine Learning Challenge Scholarship', 'Award for students winning ML competitions.', 'https://university.edu/scholarships/ml-challenge', 'Proof of ML competition achievements.', '2023-09-22', '2024-04-02', 'UC Berkeley', 'Machine Learning', 27, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(20, 'professor', 'Space Exploration Research Grant', 'Funds space exploration projects and astrophysics research.', 'https://university.edu/grants/space', 'Faculty in astrophysics or space sciences.', '2023-11-08', '2024-06-12', 'MIT', 'Astrophysics', 33, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(21, 'scholarship', 'Blockchain Innovators Scholarship', 'For students building impactful blockchain applications.', 'https://university.edu/scholarships/blockchain', 'Working blockchain project and GPA above 3.5.', '2023-09-27', '2024-03-22', 'Harvard University', 'Blockchain Technology', 84, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(22, 'professor', 'Human-Computer Interaction Grant', 'Funds HCI and UX research initiatives.', 'https://university.edu/grants/hci', 'Faculty in computer science or design.', '2023-10-22', '2024-06-05', 'Stanford University', 'Human-Computer Interaction', 22, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(23, 'scholarship', 'Renewable Energy Scholars Program', 'For students researching renewable energy sources.', 'https://university.edu/scholarships/renewable-energy', 'Research project in renewable energy.', '2023-09-16', '2024-03-12', 'UC Berkeley', 'Renewable Energy', 57, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(24, 'professor', 'Quantum AI Research Grant', 'Funds exploration of quantum computing applied to AI.', 'https://university.edu/grants/quantum-ai', 'Faculty in quantum computing or AI.', '2023-11-18', '2024-06-25', 'Princeton University', 'Quantum Computing', 18, '2025-08-14 09:59:07', '2025-08-14 09:59:07'),
(25, 'scholarship', 'Social Impact Leaders Scholarship', 'Supports students creating social change initiatives.', 'https://university.edu/scholarships/social-impact', 'Community service experience and leadership skills.', '2023-09-10', '2024-03-14', 'Stanford University', 'Social Sciences', 19, '2025-08-14 09:59:07', '2025-08-14 09:59:07');

-- --------------------------------------------------------

--
-- Table structure for table `professors`
--

CREATE TABLE `professors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `university_name` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(20) DEFAULT NULL,
  `availability` enum('available','not available') DEFAULT 'available',
  `profileLink` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professors`
--

INSERT INTO `professors` (`id`, `name`, `country`, `university_name`, `image`, `contact_email`, `contact_phone`, `availability`, `profileLink`, `createdAt`, `updatedAt`) VALUES
(1, 'Dr. James Anderson', 'UK', 'Harvard University', 'https://example.com/images/dr._james_anderson.jpg', 'dr..james.anderson@university.edu', '+1 (555) 900-2325', 'available', 'https://university.edu/faculty/dr.-james-anderson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(2, 'Dr. Olivia Young', 'India', 'Australian National University', 'https://example.com/images/dr._olivia_young.jpg', 'dr..olivia.young@university.edu', '+1 (555) 587-6397', 'not available', 'https://university.edu/faculty/dr.-olivia-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(3, 'Dr. David Clark', 'Italy', 'University of Milan', 'https://example.com/images/dr._david_clark.jpg', 'dr..david.clark@university.edu', '+1 (555) 791-3925', 'available', 'https://university.edu/faculty/dr.-david-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(4, 'Dr. Joseph Martinez', 'Canada', 'University of Dhaka', 'https://example.com/images/dr._joseph_martinez.jpg', 'dr..joseph.martinez@university.edu', '+1 (555) 794-7367', 'available', 'https://university.edu/faculty/dr.-joseph-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(5, 'Dr. William Davis', 'USA', 'University of Toronto', 'https://example.com/images/dr._william_davis.jpg', 'dr..william.davis@university.edu', '+1 (555) 589-4615', 'available', 'https://university.edu/faculty/dr.-william-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(6, 'Dr. Robert Martinez', 'Canada', 'University of Toronto', 'https://example.com/images/dr._robert_martinez.jpg', 'dr..robert.martinez@university.edu', '+1 (555) 604-2494', 'available', 'https://university.edu/faculty/dr.-robert-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(7, 'Dr. James Rodriguez', 'Japan', 'University of Milan', 'https://example.com/images/dr._james_rodriguez.jpg', 'dr..james.rodriguez@university.edu', '+1 (555) 846-1917', 'available', 'https://university.edu/faculty/dr.-james-rodriguez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(8, 'Dr. Emily Davis', 'Italy', 'Harvard University', 'https://example.com/images/dr._emily_davis.jpg', 'dr..emily.davis@university.edu', '+1 (555) 328-4234', 'not available', 'https://university.edu/faculty/dr.-emily-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(9, 'Dr. Sarah Johnson', 'USA', 'Australian National University', 'https://example.com/images/dr._sarah_johnson.jpg', 'dr..sarah.johnson@university.edu', '+1 (555) 213-8414', 'not available', 'https://university.edu/faculty/dr.-sarah-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(10, 'Dr. Olivia Davis', 'Italy', 'University of Dhaka', 'https://example.com/images/dr._olivia_davis.jpg', 'dr..olivia.davis@university.edu', '+1 (555) 907-9332', 'available', 'https://university.edu/faculty/dr.-olivia-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(11, 'Dr. Ethan Anderson', 'Germany', 'Harvard University', 'https://example.com/images/dr._ethan_anderson.jpg', 'dr..ethan.anderson@university.edu', '+1 (555) 143-1374', 'not available', 'https://university.edu/faculty/dr.-ethan-anderson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(12, 'Dr. Daniel Martinez', 'Bangladesh', 'Oxford University', 'https://example.com/images/dr._daniel_martinez.jpg', 'dr..daniel.martinez@university.edu', '+1 (555) 298-4610', 'not available', 'https://university.edu/faculty/dr.-daniel-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(13, 'Dr. David Clark', 'India', 'Australian National University', 'https://example.com/images/dr._david_clark.jpg', 'dr..david.clark@university.edu', '+1 (555) 340-5159', 'not available', 'https://university.edu/faculty/dr.-david-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(14, 'Dr. Amelia Garcia', 'France', 'MIT', 'https://example.com/images/dr._amelia_garcia.jpg', 'dr..amelia.garcia@university.edu', '+1 (555) 205-2539', 'available', 'https://university.edu/faculty/dr.-amelia-garcia', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(15, 'Dr. Michael Davis', 'UK', 'Sorbonne University', 'https://example.com/images/dr._michael_davis.jpg', 'dr..michael.davis@university.edu', '+1 (555) 939-1942', 'not available', 'https://university.edu/faculty/dr.-michael-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(16, 'Dr. William Garcia', 'UK', 'MIT', 'https://example.com/images/dr._william_garcia.jpg', 'dr..william.garcia@university.edu', '+1 (555) 379-6814', 'not available', 'https://university.edu/faculty/dr.-william-garcia', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(17, 'Dr. Sarah Young', 'Italy', 'University of Tokyo', 'https://example.com/images/dr._sarah_young.jpg', 'dr..sarah.young@university.edu', '+1 (555) 891-9751', 'not available', 'https://university.edu/faculty/dr.-sarah-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(18, 'Dr. Isabella Young', 'Italy', 'University of Tokyo', 'https://example.com/images/dr._isabella_young.jpg', 'dr..isabella.young@university.edu', '+1 (555) 232-2472', 'available', 'https://university.edu/faculty/dr.-isabella-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(19, 'Dr. Amelia Davis', 'Germany', 'Australian National University', 'https://example.com/images/dr._amelia_davis.jpg', 'dr..amelia.davis@university.edu', '+1 (555) 685-1196', 'available', 'https://university.edu/faculty/dr.-amelia-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(20, 'Dr. Isabella Johnson', 'Canada', 'Sorbonne University', 'https://example.com/images/dr._isabella_johnson.jpg', 'dr..isabella.johnson@university.edu', '+1 (555) 871-9882', 'not available', 'https://university.edu/faculty/dr.-isabella-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(21, 'Dr. James Harris', 'Germany', 'Harvard University', 'https://example.com/images/dr._james_harris.jpg', 'dr..james.harris@university.edu', '+1 (555) 113-8644', 'not available', 'https://university.edu/faculty/dr.-james-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(22, 'Dr. Olivia Thompson', 'Germany', 'MIT', 'https://example.com/images/dr._olivia_thompson.jpg', 'dr..olivia.thompson@university.edu', '+1 (555) 489-7919', 'not available', 'https://university.edu/faculty/dr.-olivia-thompson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(23, 'Dr. Sophia Jackson', 'Italy', 'Australian National University', 'https://example.com/images/dr._sophia_jackson.jpg', 'dr..sophia.jackson@university.edu', '+1 (555) 269-4708', 'available', 'https://university.edu/faculty/dr.-sophia-jackson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(24, 'Dr. Amelia Davis', 'France', 'University of Tokyo', 'https://example.com/images/dr._amelia_davis.jpg', 'dr..amelia.davis@university.edu', '+1 (555) 668-8434', 'not available', 'https://university.edu/faculty/dr.-amelia-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(25, 'Dr. Michael Thompson', 'Australia', 'Australian National University', 'https://example.com/images/dr._michael_thompson.jpg', 'dr..michael.thompson@university.edu', '+1 (555) 748-1281', 'not available', 'https://university.edu/faculty/dr.-michael-thompson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(26, 'Dr. Anna Johnson', 'Germany', 'Oxford University', 'https://example.com/images/dr._anna_johnson.jpg', 'dr..anna.johnson@university.edu', '+1 (555) 659-1050', 'not available', 'https://university.edu/faculty/dr.-anna-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(27, 'Dr. William Harris', 'UK', 'Technical University of Munich', 'https://example.com/images/dr._william_harris.jpg', 'dr..william.harris@university.edu', '+1 (555) 386-3960', 'available', 'https://university.edu/faculty/dr.-william-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(28, 'Dr. Isabella Martinez', 'Australia', 'University of Milan', 'https://example.com/images/dr._isabella_martinez.jpg', 'dr..isabella.martinez@university.edu', '+1 (555) 769-3692', 'available', 'https://university.edu/faculty/dr.-isabella-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(29, 'Dr. William Lewis', 'Bangladesh', 'Sorbonne University', 'https://example.com/images/dr._william_lewis.jpg', 'dr..william.lewis@university.edu', '+1 (555) 975-2733', 'not available', 'https://university.edu/faculty/dr.-william-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(30, 'Dr. John Harris', 'USA', 'University of Dhaka', 'https://example.com/images/dr._john_harris.jpg', 'dr..john.harris@university.edu', '+1 (555) 465-5732', 'not available', 'https://university.edu/faculty/dr.-john-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(31, 'Dr. Michael Wilson', 'Bangladesh', 'University of Milan', 'https://example.com/images/dr._michael_wilson.jpg', 'dr..michael.wilson@university.edu', '+1 (555) 327-8329', 'available', 'https://university.edu/faculty/dr.-michael-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(32, 'Dr. Charlotte Martin', 'UK', 'MIT', 'https://example.com/images/dr._charlotte_martin.jpg', 'dr..charlotte.martin@university.edu', '+1 (555) 512-4982', 'not available', 'https://university.edu/faculty/dr.-charlotte-martin', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(33, 'Dr. Sophia Young', 'Italy', 'University of Toronto', 'https://example.com/images/dr._sophia_young.jpg', 'dr..sophia.young@university.edu', '+1 (555) 257-5865', 'available', 'https://university.edu/faculty/dr.-sophia-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(34, 'Dr. Anna Moore', 'Canada', 'Harvard University', 'https://example.com/images/dr._anna_moore.jpg', 'dr..anna.moore@university.edu', '+1 (555) 154-4651', 'available', 'https://university.edu/faculty/dr.-anna-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(35, 'Dr. Matthew Young', 'India', 'University of Dhaka', 'https://example.com/images/dr._matthew_young.jpg', 'dr..matthew.young@university.edu', '+1 (555) 967-8560', 'available', 'https://university.edu/faculty/dr.-matthew-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(36, 'Dr. Ethan Clark', 'Germany', 'Australian National University', 'https://example.com/images/dr._ethan_clark.jpg', 'dr..ethan.clark@university.edu', '+1 (555) 794-7098', 'not available', 'https://university.edu/faculty/dr.-ethan-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(37, 'Dr. David Moore', 'UK', 'Harvard University', 'https://example.com/images/dr._david_moore.jpg', 'dr..david.moore@university.edu', '+1 (555) 386-6656', 'available', 'https://university.edu/faculty/dr.-david-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(38, 'Dr. Ethan Rodriguez', 'Italy', 'Technical University of Munich', 'https://example.com/images/dr._ethan_rodriguez.jpg', 'dr..ethan.rodriguez@university.edu', '+1 (555) 409-5064', 'available', 'https://university.edu/faculty/dr.-ethan-rodriguez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(39, 'Dr. Robert Walker', 'Australia', 'University of Toronto', 'https://example.com/images/dr._robert_walker.jpg', 'dr..robert.walker@university.edu', '+1 (555) 934-6661', 'available', 'https://university.edu/faculty/dr.-robert-walker', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(40, 'Dr. David Garcia', 'Japan', 'University of Dhaka', 'https://example.com/images/dr._david_garcia.jpg', 'dr..david.garcia@university.edu', '+1 (555) 203-3179', 'available', 'https://university.edu/faculty/dr.-david-garcia', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(41, 'Dr. Robert Johnson', 'Bangladesh', 'Technical University of Munich', 'https://example.com/images/dr._robert_johnson.jpg', 'dr..robert.johnson@university.edu', '+1 (555) 663-6843', 'available', 'https://university.edu/faculty/dr.-robert-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(42, 'Dr. Amelia Harris', 'Canada', 'University of Milan', 'https://example.com/images/dr._amelia_harris.jpg', 'dr..amelia.harris@university.edu', '+1 (555) 176-4572', 'available', 'https://university.edu/faculty/dr.-amelia-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(43, 'Dr. Amelia Walker', 'France', 'Sorbonne University', 'https://example.com/images/dr._amelia_walker.jpg', 'dr..amelia.walker@university.edu', '+1 (555) 604-4687', 'not available', 'https://university.edu/faculty/dr.-amelia-walker', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(44, 'Dr. Robert Wilson', 'Italy', 'MIT', 'https://example.com/images/dr._robert_wilson.jpg', 'dr..robert.wilson@university.edu', '+1 (555) 719-2195', 'available', 'https://university.edu/faculty/dr.-robert-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(45, 'Dr. Robert Lewis', 'Canada', 'University of Tokyo', 'https://example.com/images/dr._robert_lewis.jpg', 'dr..robert.lewis@university.edu', '+1 (555) 977-2771', 'available', 'https://university.edu/faculty/dr.-robert-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(46, 'Dr. Isabella Lewis', 'France', 'Harvard University', 'https://example.com/images/dr._isabella_lewis.jpg', 'dr..isabella.lewis@university.edu', '+1 (555) 335-1136', 'available', 'https://university.edu/faculty/dr.-isabella-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(47, 'Dr. Anna Martinez', 'Bangladesh', 'Technical University of Munich', 'https://example.com/images/dr._anna_martinez.jpg', 'dr..anna.martinez@university.edu', '+1 (555) 134-2594', 'not available', 'https://university.edu/faculty/dr.-anna-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(48, 'Dr. Joseph Walker', 'Australia', 'University of Dhaka', 'https://example.com/images/dr._joseph_walker.jpg', 'dr..joseph.walker@university.edu', '+1 (555) 782-2035', 'available', 'https://university.edu/faculty/dr.-joseph-walker', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(49, 'Dr. Olivia Wilson', 'Canada', 'Australian National University', 'https://example.com/images/dr._olivia_wilson.jpg', 'dr..olivia.wilson@university.edu', '+1 (555) 310-6561', 'available', 'https://university.edu/faculty/dr.-olivia-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(50, 'Dr. Michael Brown', 'UK', 'University of Milan', 'https://example.com/images/dr._michael_brown.jpg', 'dr..michael.brown@university.edu', '+1 (555) 605-3989', 'available', 'https://university.edu/faculty/dr.-michael-brown', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(51, 'Dr. Sophia Brown', 'France', 'Technical University of Munich', 'https://example.com/images/dr._sophia_brown.jpg', 'dr..sophia.brown@university.edu', '+1 (555) 120-9367', 'available', 'https://university.edu/faculty/dr.-sophia-brown', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(52, 'Dr. Anna Wilson', 'Japan', 'University of Milan', 'https://example.com/images/dr._anna_wilson.jpg', 'dr..anna.wilson@university.edu', '+1 (555) 575-5271', 'not available', 'https://university.edu/faculty/dr.-anna-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(53, 'Dr. Anna Johnson', 'Bangladesh', 'University of Dhaka', 'https://example.com/images/dr._anna_johnson.jpg', 'dr..anna.johnson@university.edu', '+1 (555) 684-7826', 'available', 'https://university.edu/faculty/dr.-anna-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(54, 'Dr. Isabella Taylor', 'UK', 'MIT', 'https://example.com/images/dr._isabella_taylor.jpg', 'dr..isabella.taylor@university.edu', '+1 (555) 767-5820', 'available', 'https://university.edu/faculty/dr.-isabella-taylor', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(55, 'Dr. John Chen', 'India', 'University of Milan', 'https://example.com/images/dr._john_chen.jpg', 'dr..john.chen@university.edu', '+1 (555) 579-2565', 'not available', 'https://university.edu/faculty/dr.-john-chen', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(56, 'Dr. Charlotte Clark', 'Germany', 'University of Tokyo', 'https://example.com/images/dr._charlotte_clark.jpg', 'dr..charlotte.clark@university.edu', '+1 (555) 301-4662', 'not available', 'https://university.edu/faculty/dr.-charlotte-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(57, 'Dr. Emily Young', 'UK', 'Harvard University', 'https://example.com/images/dr._emily_young.jpg', 'dr..emily.young@university.edu', '+1 (555) 542-5911', 'available', 'https://university.edu/faculty/dr.-emily-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(58, 'Dr. Robert Wilson', 'Germany', 'MIT', 'https://example.com/images/dr._robert_wilson.jpg', 'dr..robert.wilson@university.edu', '+1 (555) 138-1494', 'not available', 'https://university.edu/faculty/dr.-robert-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(59, 'Dr. John Clark', 'Italy', 'University of Dhaka', 'https://example.com/images/dr._john_clark.jpg', 'dr..john.clark@university.edu', '+1 (555) 552-2564', 'available', 'https://university.edu/faculty/dr.-john-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(60, 'Dr. Charlotte Rodriguez', 'Japan', 'Australian National University', 'https://example.com/images/dr._charlotte_rodriguez.jpg', 'dr..charlotte.rodriguez@university.edu', '+1 (555) 685-4787', 'available', 'https://university.edu/faculty/dr.-charlotte-rodriguez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(61, 'Dr. Charlotte Johnson', 'Australia', 'University of Milan', 'https://example.com/images/dr._charlotte_johnson.jpg', 'dr..charlotte.johnson@university.edu', '+1 (555) 787-9525', 'available', 'https://university.edu/faculty/dr.-charlotte-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(62, 'Dr. John Martin', 'India', 'Australian National University', 'https://example.com/images/dr._john_martin.jpg', 'dr..john.martin@university.edu', '+1 (555) 886-1549', 'not available', 'https://university.edu/faculty/dr.-john-martin', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(63, 'Dr. Sophia Martin', 'Canada', 'University of Toronto', 'https://example.com/images/dr._sophia_martin.jpg', 'dr..sophia.martin@university.edu', '+1 (555) 871-2069', 'available', 'https://university.edu/faculty/dr.-sophia-martin', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(64, 'Dr. Sophia Taylor', 'France', 'University of Dhaka', 'https://example.com/images/dr._sophia_taylor.jpg', 'dr..sophia.taylor@university.edu', '+1 (555) 181-9397', 'not available', 'https://university.edu/faculty/dr.-sophia-taylor', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(65, 'Dr. David Harris', 'Bangladesh', 'University of Toronto', 'https://example.com/images/dr._david_harris.jpg', 'dr..david.harris@university.edu', '+1 (555) 859-4036', 'available', 'https://university.edu/faculty/dr.-david-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(66, 'Dr. Sophia Wilson', 'France', 'University of Dhaka', 'https://example.com/images/dr._sophia_wilson.jpg', 'dr..sophia.wilson@university.edu', '+1 (555) 277-4097', 'not available', 'https://university.edu/faculty/dr.-sophia-wilson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(67, 'Dr. Sophia Anderson', 'UK', 'Harvard University', 'https://example.com/images/dr._sophia_anderson.jpg', 'dr..sophia.anderson@university.edu', '+1 (555) 131-8072', 'not available', 'https://university.edu/faculty/dr.-sophia-anderson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(68, 'Dr. Joseph Taylor', 'France', 'University of Toronto', 'https://example.com/images/dr._joseph_taylor.jpg', 'dr..joseph.taylor@university.edu', '+1 (555) 340-4520', 'available', 'https://university.edu/faculty/dr.-joseph-taylor', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(69, 'Dr. Michael Martinez', 'Germany', 'University of Tokyo', 'https://example.com/images/dr._michael_martinez.jpg', 'dr..michael.martinez@university.edu', '+1 (555) 510-8169', 'not available', 'https://university.edu/faculty/dr.-michael-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(70, 'Dr. Lisa Young', 'Italy', 'Harvard University', 'https://example.com/images/dr._lisa_young.jpg', 'dr..lisa.young@university.edu', '+1 (555) 821-9722', 'available', 'https://university.edu/faculty/dr.-lisa-young', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(71, 'Dr. Sarah Moore', 'India', 'University of Tokyo', 'https://example.com/images/dr._sarah_moore.jpg', 'dr..sarah.moore@university.edu', '+1 (555) 851-9739', 'not available', 'https://university.edu/faculty/dr.-sarah-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(72, 'Dr. James Lewis', 'Canada', 'Sorbonne University', 'https://example.com/images/dr._james_lewis.jpg', 'dr..james.lewis@university.edu', '+1 (555) 890-9422', 'available', 'https://university.edu/faculty/dr.-james-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(73, 'Dr. Ethan Jackson', 'Australia', 'University of Milan', 'https://example.com/images/dr._ethan_jackson.jpg', 'dr..ethan.jackson@university.edu', '+1 (555) 700-9106', 'available', 'https://university.edu/faculty/dr.-ethan-jackson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(74, 'Dr. James Davis', 'Canada', 'Harvard University', 'https://example.com/images/dr._james_davis.jpg', 'dr..james.davis@university.edu', '+1 (555) 559-7197', 'available', 'https://university.edu/faculty/dr.-james-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(75, 'Dr. David Harris', 'Italy', 'Harvard University', 'https://example.com/images/dr._david_harris.jpg', 'dr..david.harris@university.edu', '+1 (555) 236-9949', 'available', 'https://university.edu/faculty/dr.-david-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(76, 'Dr. Ethan Martinez', 'Japan', 'University of Tokyo', 'https://example.com/images/dr._ethan_martinez.jpg', 'dr..ethan.martinez@university.edu', '+1 (555) 991-5618', 'not available', 'https://university.edu/faculty/dr.-ethan-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(77, 'Dr. Ethan Chen', 'USA', 'Sorbonne University', 'https://example.com/images/dr._ethan_chen.jpg', 'dr..ethan.chen@university.edu', '+1 (555) 815-5445', 'available', 'https://university.edu/faculty/dr.-ethan-chen', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(78, 'Dr. James Thompson', 'Canada', 'Oxford University', 'https://example.com/images/dr._james_thompson.jpg', 'dr..james.thompson@university.edu', '+1 (555) 545-6483', 'available', 'https://university.edu/faculty/dr.-james-thompson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(79, 'Dr. Olivia Martinez', 'Australia', 'Sorbonne University', 'https://example.com/images/dr._olivia_martinez.jpg', 'dr..olivia.martinez@university.edu', '+1 (555) 643-3615', 'available', 'https://university.edu/faculty/dr.-olivia-martinez', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(80, 'Dr. Anna Martin', 'India', 'Technical University of Munich', 'https://example.com/images/dr._anna_martin.jpg', 'dr..anna.martin@university.edu', '+1 (555) 193-5557', 'available', 'https://university.edu/faculty/dr.-anna-martin', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(81, 'Dr. Amelia Davis', 'Canada', 'University of Tokyo', 'https://example.com/images/dr._amelia_davis.jpg', 'dr..amelia.davis@university.edu', '+1 (555) 924-2212', 'available', 'https://university.edu/faculty/dr.-amelia-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(82, 'Dr. John Brown', 'Italy', 'University of Toronto', 'https://example.com/images/dr._john_brown.jpg', 'dr..john.brown@university.edu', '+1 (555) 757-7402', 'not available', 'https://university.edu/faculty/dr.-john-brown', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(83, 'Dr. Matthew Moore', 'Canada', 'Oxford University', 'https://example.com/images/dr._matthew_moore.jpg', 'dr..matthew.moore@university.edu', '+1 (555) 805-5368', 'not available', 'https://university.edu/faculty/dr.-matthew-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(84, 'Dr. Joseph Davis', 'USA', 'University of Tokyo', 'https://example.com/images/dr._joseph_davis.jpg', 'dr..joseph.davis@university.edu', '+1 (555) 118-2472', 'available', 'https://university.edu/faculty/dr.-joseph-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(85, 'Dr. Joseph Johnson', 'France', 'University of Dhaka', 'https://example.com/images/dr._joseph_johnson.jpg', 'dr..joseph.johnson@university.edu', '+1 (555) 626-5214', 'available', 'https://university.edu/faculty/dr.-joseph-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(86, 'Dr. Joseph Lewis', 'UK', 'Sorbonne University', 'https://example.com/images/dr._joseph_lewis.jpg', 'dr..joseph.lewis@university.edu', '+1 (555) 333-6895', 'available', 'https://university.edu/faculty/dr.-joseph-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(87, 'Dr. Mia Harris', 'Canada', 'Australian National University', 'https://example.com/images/dr._mia_harris.jpg', 'dr..mia.harris@university.edu', '+1 (555) 644-7617', 'available', 'https://university.edu/faculty/dr.-mia-harris', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(88, 'Dr. John Jackson', 'Japan', 'University of Toronto', 'https://example.com/images/dr._john_jackson.jpg', 'dr..john.jackson@university.edu', '+1 (555) 588-7332', 'available', 'https://university.edu/faculty/dr.-john-jackson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(89, 'Dr. Charlotte Johnson', 'India', 'Sorbonne University', 'https://example.com/images/dr._charlotte_johnson.jpg', 'dr..charlotte.johnson@university.edu', '+1 (555) 222-3813', 'not available', 'https://university.edu/faculty/dr.-charlotte-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(90, 'Dr. Emily Lee', 'Japan', 'University of Milan', 'https://example.com/images/dr._emily_lee.jpg', 'dr..emily.lee@university.edu', '+1 (555) 178-9413', 'available', 'https://university.edu/faculty/dr.-emily-lee', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(91, 'Dr. David Thompson', 'Germany', 'Australian National University', 'https://example.com/images/dr._david_thompson.jpg', 'dr..david.thompson@university.edu', '+1 (555) 438-2655', 'available', 'https://university.edu/faculty/dr.-david-thompson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(92, 'Dr. Daniel Brown', 'Italy', 'Oxford University', 'https://example.com/images/dr._daniel_brown.jpg', 'dr..daniel.brown@university.edu', '+1 (555) 190-2978', 'available', 'https://university.edu/faculty/dr.-daniel-brown', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(93, 'Dr. Isabella Lewis', 'France', 'University of Dhaka', 'https://example.com/images/dr._isabella_lewis.jpg', 'dr..isabella.lewis@university.edu', '+1 (555) 362-6774', 'available', 'https://university.edu/faculty/dr.-isabella-lewis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(94, 'Dr. William Moore', 'France', 'University of Milan', 'https://example.com/images/dr._william_moore.jpg', 'dr..william.moore@university.edu', '+1 (555) 333-2088', 'not available', 'https://university.edu/faculty/dr.-william-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(95, 'Dr. Anna Martin', 'Italy', 'Technical University of Munich', 'https://example.com/images/dr._anna_martin.jpg', 'dr..anna.martin@university.edu', '+1 (555) 392-7393', 'not available', 'https://university.edu/faculty/dr.-anna-martin', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(96, 'Dr. James Johnson', 'UK', 'University of Dhaka', 'https://example.com/images/dr._james_johnson.jpg', 'dr..james.johnson@university.edu', '+1 (555) 261-6619', 'available', 'https://university.edu/faculty/dr.-james-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(97, 'Dr. William Moore', 'USA', 'University of Milan', 'https://example.com/images/dr._william_moore.jpg', 'dr..william.moore@university.edu', '+1 (555) 527-7056', 'available', 'https://university.edu/faculty/dr.-william-moore', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(98, 'Dr. Daniel Clark', 'Canada', 'Oxford University', 'https://example.com/images/dr._daniel_clark.jpg', 'dr..daniel.clark@university.edu', '+1 (555) 940-1499', 'available', 'https://university.edu/faculty/dr.-daniel-clark', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(99, 'Dr. Sarah Davis', 'Germany', 'University of Toronto', 'https://example.com/images/dr._sarah_davis.jpg', 'dr..sarah.davis@university.edu', '+1 (555) 832-2228', 'available', 'https://university.edu/faculty/dr.-sarah-davis', '2025-07-31 16:47:42', '2025-07-31 16:47:42'),
(100, 'Dr. William Johnson', 'USA', 'Oxford University', 'https://example.com/images/dr._william_johnson.jpg', 'dr..william.johnson@university.edu', '+1 (555) 651-3857', 'available', 'https://university.edu/faculty/dr.-william-johnson', '2025-07-31 16:47:42', '2025-07-31 16:47:42');

-- --------------------------------------------------------

--
-- Table structure for table `professor_research_interests`
--

CREATE TABLE `professor_research_interests` (
  `id` int(11) NOT NULL,
  `professor_id` int(11) DEFAULT NULL,
  `interest` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `professor_research_interests`
--

INSERT INTO `professor_research_interests` (`id`, `professor_id`, `interest`) VALUES
(1, 1, 'Data Science'),
(2, 1, 'Quantum Computing'),
(3, 1, 'Sustainable Materials'),
(4, 2, 'Sustainable Materials'),
(5, 2, 'Computational Biology'),
(6, 3, 'Data Science'),
(7, 3, 'Environmental Science'),
(8, 4, 'Robotics'),
(9, 4, 'Cryptography'),
(10, 5, 'Neuroscience'),
(11, 5, 'Computational Biology'),
(12, 5, 'Cryptography'),
(13, 5, 'Computer Vision'),
(14, 6, 'Computer Vision'),
(15, 6, 'Computational Biology'),
(16, 6, 'Human-Computer Interaction'),
(17, 7, 'Computational Biology'),
(18, 7, 'Machine Learning'),
(19, 7, 'Computer Vision'),
(20, 8, 'Renewable Energy'),
(21, 8, 'Neuroscience'),
(22, 8, 'Robotics'),
(23, 8, 'Cryptography'),
(24, 9, 'Artificial Intelligence'),
(25, 9, 'Neuroscience'),
(26, 9, 'Cryptography'),
(27, 10, 'Natural Language Processing'),
(28, 10, 'Neuroscience'),
(29, 10, 'Artificial Intelligence'),
(30, 11, 'Computer Vision'),
(31, 11, 'Robotics'),
(32, 11, 'Genomics'),
(33, 11, 'Artificial Intelligence'),
(34, 12, 'Quantum Computing'),
(35, 12, 'Robotics'),
(36, 12, 'Artificial Intelligence'),
(37, 13, 'Blockchain'),
(38, 13, 'Algorithm Design'),
(39, 13, 'Computational Biology'),
(40, 14, 'Human-Computer Interaction'),
(41, 14, 'Robotics'),
(42, 14, 'Algorithm Design'),
(43, 15, 'Bioinformatics'),
(44, 15, 'Cryptography'),
(45, 15, 'Renewable Energy'),
(46, 15, 'Natural Language Processing'),
(47, 16, 'Human-Computer Interaction'),
(48, 16, 'Neuroscience'),
(49, 16, 'Artificial Intelligence'),
(50, 16, 'Bioinformatics'),
(51, 17, 'Robotics'),
(52, 17, 'Neuroscience'),
(53, 18, 'Bioinformatics'),
(54, 18, 'Blockchain'),
(55, 19, 'Computer Vision'),
(56, 19, 'Machine Learning'),
(57, 20, 'Cryptography'),
(58, 20, 'Neuroscience'),
(59, 21, 'Blockchain'),
(60, 21, 'Genomics'),
(61, 21, 'Environmental Science'),
(62, 21, 'Natural Language Processing'),
(63, 22, 'Cloud Computing'),
(64, 22, 'Human-Computer Interaction'),
(65, 23, 'Machine Learning'),
(66, 23, 'Computational Biology'),
(67, 23, 'Blockchain'),
(68, 24, 'Neuroscience'),
(69, 24, 'Computer Vision'),
(70, 24, 'Algorithm Design'),
(71, 25, 'Data Science'),
(72, 25, 'Cryptography'),
(73, 26, 'Neuroscience'),
(74, 26, 'Natural Language Processing'),
(75, 27, 'Cryptography'),
(76, 27, 'Blockchain'),
(77, 27, 'Environmental Science'),
(78, 27, 'Bioinformatics'),
(79, 28, 'Environmental Science'),
(80, 28, 'Computational Biology'),
(81, 28, 'Cryptography'),
(82, 28, 'Human-Computer Interaction'),
(83, 29, 'Environmental Science'),
(84, 29, 'Cognitive Psychology'),
(85, 29, 'Data Science'),
(86, 29, 'Bioinformatics'),
(87, 30, 'Data Science'),
(88, 30, 'Robotics'),
(89, 30, 'Computational Biology'),
(90, 30, 'Cloud Computing'),
(91, 31, 'Algorithm Design'),
(92, 31, 'Computational Biology'),
(93, 31, 'Robotics'),
(94, 32, 'Environmental Science'),
(95, 32, 'Machine Learning'),
(96, 32, 'Quantum Computing'),
(97, 32, 'Genomics'),
(98, 33, 'Sustainable Materials'),
(99, 33, 'Computer Vision'),
(100, 33, 'Genomics'),
(101, 34, 'Natural Language Processing'),
(102, 34, 'Cognitive Psychology'),
(103, 34, 'Algorithm Design'),
(104, 34, 'Robotics'),
(105, 35, 'Cloud Computing'),
(106, 35, 'Environmental Science'),
(107, 35, 'Genomics'),
(108, 36, 'Natural Language Processing'),
(109, 36, 'Artificial Intelligence'),
(110, 37, 'Human-Computer Interaction'),
(111, 37, 'Sustainable Materials'),
(112, 37, 'Environmental Science'),
(113, 38, 'Bioinformatics'),
(114, 38, 'Sustainable Materials'),
(115, 38, 'Cognitive Psychology'),
(116, 38, 'Cryptography'),
(117, 39, 'Cryptography'),
(118, 39, 'Human-Computer Interaction'),
(119, 39, 'Sustainable Materials'),
(120, 40, 'Machine Learning'),
(121, 40, 'Bioinformatics'),
(122, 40, 'Renewable Energy'),
(123, 40, 'Computational Biology'),
(124, 41, 'Artificial Intelligence'),
(125, 41, 'Blockchain'),
(126, 42, 'Natural Language Processing'),
(127, 42, 'Machine Learning'),
(128, 42, 'Blockchain'),
(129, 42, 'Renewable Energy'),
(130, 43, 'Computational Biology'),
(131, 43, 'Blockchain'),
(132, 43, 'Cognitive Psychology'),
(133, 43, 'Sustainable Materials'),
(134, 44, 'Machine Learning'),
(135, 44, 'Artificial Intelligence'),
(136, 44, 'Sustainable Materials'),
(137, 45, 'Robotics'),
(138, 45, 'Computational Biology'),
(139, 46, 'Renewable Energy'),
(140, 46, 'Bioinformatics'),
(141, 47, 'Computational Biology'),
(142, 47, 'Cloud Computing'),
(143, 47, 'Renewable Energy'),
(144, 48, 'Computer Vision'),
(145, 48, 'Neuroscience'),
(146, 48, 'Robotics'),
(147, 48, 'Renewable Energy'),
(148, 49, 'Algorithm Design'),
(149, 49, 'Bioinformatics'),
(150, 50, 'Cloud Computing'),
(151, 50, 'Machine Learning'),
(152, 51, 'Bioinformatics'),
(153, 51, 'Sustainable Materials'),
(154, 51, 'Computer Vision'),
(155, 52, 'Genomics'),
(156, 52, 'Robotics'),
(157, 52, 'Renewable Energy'),
(158, 53, 'Neuroscience'),
(159, 53, 'Artificial Intelligence'),
(160, 53, 'Robotics'),
(161, 54, 'Quantum Computing'),
(162, 54, 'Cognitive Psychology'),
(163, 54, 'Neuroscience'),
(164, 55, 'Cloud Computing'),
(165, 55, 'Quantum Computing'),
(166, 55, 'Human-Computer Interaction'),
(167, 55, 'Cryptography'),
(168, 56, 'Human-Computer Interaction'),
(169, 56, 'Renewable Energy'),
(170, 56, 'Neuroscience'),
(171, 57, 'Data Science'),
(172, 57, 'Cognitive Psychology'),
(173, 58, 'Bioinformatics'),
(174, 58, 'Quantum Computing'),
(175, 59, 'Blockchain'),
(176, 59, 'Environmental Science'),
(177, 60, 'Algorithm Design'),
(178, 60, 'Cryptography'),
(179, 61, 'Environmental Science'),
(180, 61, 'Computer Vision'),
(181, 61, 'Neuroscience'),
(182, 62, 'Machine Learning'),
(183, 62, 'Robotics'),
(184, 63, 'Blockchain'),
(185, 63, 'Computer Vision'),
(186, 64, 'Machine Learning'),
(187, 64, 'Algorithm Design'),
(188, 64, 'Computer Vision'),
(189, 65, 'Computational Biology'),
(190, 65, 'Neuroscience'),
(191, 65, 'Genomics'),
(192, 66, 'Environmental Science'),
(193, 66, 'Neuroscience'),
(194, 66, 'Human-Computer Interaction'),
(195, 66, 'Cryptography'),
(196, 67, 'Environmental Science'),
(197, 67, 'Cloud Computing'),
(198, 67, 'Cryptography'),
(199, 68, 'Cloud Computing'),
(200, 68, 'Bioinformatics'),
(201, 68, 'Computational Biology'),
(202, 68, 'Blockchain'),
(203, 69, 'Bioinformatics'),
(204, 69, 'Renewable Energy'),
(205, 69, 'Sustainable Materials'),
(206, 70, 'Cloud Computing'),
(207, 70, 'Neuroscience'),
(208, 70, 'Blockchain'),
(209, 70, 'Cryptography'),
(210, 71, 'Algorithm Design'),
(211, 71, 'Cloud Computing'),
(212, 71, 'Blockchain'),
(213, 71, 'Human-Computer Interaction'),
(214, 72, 'Natural Language Processing'),
(215, 72, 'Bioinformatics'),
(216, 72, 'Environmental Science'),
(217, 72, 'Blockchain'),
(218, 73, 'Machine Learning'),
(219, 73, 'Robotics'),
(220, 74, 'Bioinformatics'),
(221, 74, 'Machine Learning'),
(222, 75, 'Cloud Computing'),
(223, 75, 'Bioinformatics'),
(224, 76, 'Sustainable Materials'),
(225, 76, 'Machine Learning'),
(226, 76, 'Environmental Science'),
(227, 77, 'Machine Learning'),
(228, 77, 'Sustainable Materials'),
(229, 77, 'Robotics'),
(230, 78, 'Natural Language Processing'),
(231, 78, 'Human-Computer Interaction'),
(232, 78, 'Blockchain'),
(233, 78, 'Cognitive Psychology'),
(234, 79, 'Quantum Computing'),
(235, 79, 'Cryptography'),
(236, 80, 'Robotics'),
(237, 80, 'Quantum Computing'),
(238, 80, 'Cognitive Psychology'),
(239, 81, 'Computer Vision'),
(240, 81, 'Sustainable Materials'),
(241, 82, 'Natural Language Processing'),
(242, 82, 'Environmental Science'),
(243, 82, 'Data Science'),
(244, 82, 'Sustainable Materials'),
(245, 83, 'Natural Language Processing'),
(246, 83, 'Machine Learning'),
(247, 84, 'Cloud Computing'),
(248, 84, 'Quantum Computing'),
(249, 84, 'Bioinformatics'),
(250, 84, 'Cryptography'),
(251, 85, 'Computer Vision'),
(252, 85, 'Machine Learning'),
(253, 85, 'Sustainable Materials'),
(254, 85, 'Genomics'),
(255, 86, 'Natural Language Processing'),
(256, 86, 'Cryptography'),
(257, 86, 'Genomics'),
(258, 86, 'Bioinformatics'),
(259, 87, 'Machine Learning'),
(260, 87, 'Robotics'),
(261, 88, 'Bioinformatics'),
(262, 88, 'Neuroscience'),
(263, 88, 'Data Science'),
(264, 88, 'Sustainable Materials'),
(265, 89, 'Environmental Science'),
(266, 89, 'Renewable Energy'),
(267, 90, 'Genomics'),
(268, 90, 'Quantum Computing'),
(269, 90, 'Artificial Intelligence'),
(270, 91, 'Algorithm Design'),
(271, 91, 'Neuroscience'),
(272, 92, 'Data Science'),
(273, 92, 'Cognitive Psychology'),
(274, 92, 'Machine Learning'),
(275, 92, 'Cryptography'),
(276, 93, 'Computer Vision'),
(277, 93, 'Bioinformatics'),
(278, 93, 'Quantum Computing'),
(279, 94, 'Computer Vision'),
(280, 94, 'Computational Biology'),
(281, 95, 'Robotics'),
(282, 95, 'Cloud Computing'),
(283, 96, 'Genomics'),
(284, 96, 'Robotics'),
(285, 96, 'Neuroscience'),
(286, 96, 'Cloud Computing'),
(287, 97, 'Human-Computer Interaction'),
(288, 97, 'Genomics'),
(289, 98, 'Bioinformatics'),
(290, 98, 'Algorithm Design'),
(291, 99, 'Computational Biology'),
(292, 99, 'Natural Language Processing'),
(293, 99, 'Computer Vision'),
(294, 99, 'Cloud Computing'),
(295, 100, 'Genomics'),
(296, 100, 'Data Science');

-- --------------------------------------------------------

--
-- Table structure for table `purchased_books`
--

CREATE TABLE `purchased_books` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `bookId` int(11) NOT NULL,
  `purchasedAt` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchased_books`
--

INSERT INTO `purchased_books` (`id`, `userId`, `bookId`, `purchasedAt`) VALUES
(1, 1, 1, '2025-07-31 16:57:07'),
(2, 1, 4, '2025-07-31 16:57:07'),
(3, 2, 2, '2025-07-31 16:57:07'),
(4, 4, 3, '2025-07-31 16:57:07'),
(5, 5, 5, '2025-07-31 16:57:07'),
(6, 1, 5, '2025-07-31 16:57:07'),
(7, 2, 1, '2025-07-31 16:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `message` text NOT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `userId`, `message`, `createdAt`, `updatedAt`) VALUES
(1, 1, 'This book helped me get into my dream college! Highly recommended.', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(2, 2, 'Great resource for job preparation. The tips are practical and effective.', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(3, 4, 'Excellent content for learning programming. Clear explanations and examples.', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(4, 1, 'The MBA preparation guide is comprehensive and well-structured.', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(5, 5, 'Data Science concepts explained in an easy-to-understand manner.', '2025-07-31 16:57:07', '2025-07-31 16:57:07');

-- --------------------------------------------------------

--
-- Table structure for table `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  `programType` enum('undergraduate','postgraduate','Ph.D.') NOT NULL,
  `discipline` varchar(255) NOT NULL,
  `admissionLink` varchar(255) NOT NULL,
  `applicationDate` date DEFAULT NULL,
  `applicationDeadline` date DEFAULT NULL,
  `admitCardDownloadDate` date DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `universities`
--

INSERT INTO `universities` (`id`, `name`, `location`, `programType`, `discipline`, `admissionLink`, `applicationDate`, `applicationDeadline`, `admitCardDownloadDate`, `image`, `createdAt`, `updatedAt`) VALUES
(1, 'Harvard University', 'Cambridge, MA', 'undergraduate', 'Computer Science', 'https://harvard.edu/apply', '2023-09-01', '2023-12-15', '2024-01-15', 'https://example.com/images/harvard.jpg', '2025-07-31 16:49:06', '2025-07-31 16:49:06'),
(2, 'Stanford University', 'Stanford, CA', 'postgraduate', 'Artificial Intelligence', 'https://stanford.edu/admissions', '2023-10-01', '2024-01-20', '2024-02-10', 'https://example.com/images/stanford.jpg', '2025-07-31 16:49:06', '2025-07-31 16:49:06'),
(3, 'MIT', 'Cambridge, MA', 'Ph.D.', 'Robotics', 'https://mit.edu/admissions', '2023-11-01', '2024-02-15', '2024-03-01', 'https://example.com/images/mit.jpg', '2025-07-31 16:49:06', '2025-07-31 16:49:06'),
(4, 'UC Berkeley', 'Berkeley, CA', 'undergraduate', 'Data Science', 'https://berkeley.edu/apply', '2023-09-15', '2023-11-30', '2024-01-05', 'https://example.com/images/berkeley.jpg', '2025-07-31 16:49:06', '2025-07-31 16:49:06'),
(5, 'Princeton University', 'Princeton, NJ', 'postgraduate', 'Quantum Computing', 'https://princeton.edu/admissions', '2023-10-15', '2024-01-10', '2024-02-01', 'https://example.com/images/princeton.jpg', '2025-07-31 16:49:06', '2025-07-31 16:49:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `qualification` enum('high-school','bachelor','master','phd','other') DEFAULT NULL,
  `institute` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `phoneNumber` varchar(20) DEFAULT NULL,
  `emailVerified` tinyint(1) DEFAULT 0,
  `emailVerificationCode` int(11) DEFAULT NULL,
  `isPremium` tinyint(1) DEFAULT 0,
  `premiumExpiresAt` date DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `createdAt` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `qualification`, `institute`, `email`, `password`, `profilePicture`, `address`, `phoneNumber`, `emailVerified`, `emailVerificationCode`, `isPremium`, `premiumExpiresAt`, `role`, `createdAt`, `updatedAt`) VALUES
(1, 'John Doe', NULL, NULL, NULL, 'john@example.com', 'hashed_password_1', 'https://example.com/images/john.jpg', '123 Main St, City', '555-1234', 1, NULL, 1, '2024-12-31', 'user', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(2, 'Jane Smith', NULL, NULL, NULL, 'jane@example.com', 'hashed_password_2', 'https://example.com/images/jane.jpg', '456 Oak Ave, Town', '555-5678', 1, NULL, 0, NULL, 'user', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(3, 'Admin User', NULL, NULL, NULL, 'admin@example.com', 'hashed_password_admin', 'https://example.com/images/admin.jpg', '789 Admin Rd, Capital', '555-9999', 1, NULL, 1, '2025-12-31', 'admin', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(4, 'Mike Johnson', NULL, NULL, NULL, 'mike@example.com', 'hashed_password_3', NULL, '321 Pine St, Village', '555-4321', 0, NULL, 0, NULL, 'user', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(5, 'Sarah Williams', NULL, NULL, NULL, 'sarah@example.com', 'hashed_password_4', 'https://example.com/images/sarah.jpg', '654 Elm Blvd, County', '555-8765', 1, NULL, 1, '2024-06-30', 'user', '2025-07-31 16:57:07', '2025-07-31 16:57:07'),
(6, 'Admin', NULL, NULL, NULL, 'admin@gmail.com', 'asdfasdf', 'admin_profile.jpg', '123 Admin Street, Admin City', '+10000000000', 1, 0, 1, '2030-12-31', 'admin', '2025-08-02 14:32:14', '2025-08-02 14:34:40'),
(7, 'Sajjad', 'male', 'high-school', 'Daffodil International University', 'sajjadmojumder50@gmail.com', '6aebaff30d92f492a22955d80a3f8e99', NULL, NULL, NULL, 0, NULL, 0, NULL, 'user', '2025-08-11 13:00:25', '2025-08-11 13:00:25'),
(11, 'anik', 'male', 'bachelor', 'daffodil International University', 'anik15-5640@diu.edu.bd', '*Anik5640', NULL, NULL, NULL, 0, NULL, 0, NULL, 'user', '2025-08-13 00:35:05', '2025-08-13 00:35:05'),
(12, 'Sabiba', 'female', 'bachelor', 'Daffodil International University', 'sabiba@gmail.com', '*Anik5640', NULL, NULL, NULL, 0, NULL, 0, NULL, 'user', '2025-08-14 16:25:14', '2025-08-14 16:25:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_category` (`category`),
  ADD KEY `idx_author` (`author`);

--
-- Indexes for table `book_reviews`
--
ALTER TABLE `book_reviews`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_book_review` (`bookId`,`reviewId`),
  ADD KEY `idx_book` (`bookId`),
  ADD KEY `idx_review` (`reviewId`);

--
-- Indexes for table `exam_units`
--
ALTER TABLE `exam_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_university` (`university_id`);

--
-- Indexes for table `fundings`
--
ALTER TABLE `fundings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`),
  ADD KEY `idx_type` (`type`),
  ADD KEY `idx_title` (`title`),
  ADD KEY `idx_deadline` (`applicationDeadline`);

--
-- Indexes for table `professors`
--
ALTER TABLE `professors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name` (`name`),
  ADD KEY `idx_email` (`contact_email`);

--
-- Indexes for table `professor_research_interests`
--
ALTER TABLE `professor_research_interests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `professor_id` (`professor_id`);

--
-- Indexes for table `purchased_books`
--
ALTER TABLE `purchased_books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_book` (`userId`,`bookId`),
  ADD KEY `idx_user` (`userId`),
  ADD KEY `idx_book` (`bookId`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_user` (`userId`);

--
-- Indexes for table `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_name_location` (`name`,`location`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `idx_email` (`email`),
  ADD KEY `idx_role` (`role`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `book_reviews`
--
ALTER TABLE `book_reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_units`
--
ALTER TABLE `exam_units`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `fundings`
--
ALTER TABLE `fundings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `professors`
--
ALTER TABLE `professors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `professor_research_interests`
--
ALTER TABLE `professor_research_interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=297;

--
-- AUTO_INCREMENT for table `purchased_books`
--
ALTER TABLE `purchased_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `book_reviews`
--
ALTER TABLE `book_reviews`
  ADD CONSTRAINT `book_reviews_ibfk_1` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `book_reviews_ibfk_2` FOREIGN KEY (`reviewId`) REFERENCES `reviews` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exam_units`
--
ALTER TABLE `exam_units`
  ADD CONSTRAINT `exam_units_ibfk_1` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `fundings`
--
ALTER TABLE `fundings`
  ADD CONSTRAINT `fundings_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `professor_research_interests`
--
ALTER TABLE `professor_research_interests`
  ADD CONSTRAINT `professor_research_interests_ibfk_1` FOREIGN KEY (`professor_id`) REFERENCES `professors` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `purchased_books`
--
ALTER TABLE `purchased_books`
  ADD CONSTRAINT `purchased_books_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `purchased_books_ibfk_2` FOREIGN KEY (`bookId`) REFERENCES `books` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
