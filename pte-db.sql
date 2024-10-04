-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 03, 2024 at 04:03 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pte`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `userid` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `auth_users`
--

CREATE TABLE `auth_users` (
  `authId` int(50) NOT NULL,
  `first_name` varchar(500) DEFAULT NULL,
  `last_name` varchar(500) DEFAULT NULL,
  `email` varchar(500) DEFAULT NULL,
  `auth_password` varchar(500) DEFAULT NULL,
  `last_login` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `auth_users`
--

INSERT INTO `auth_users` (`authId`, `first_name`, `last_name`, `email`, `auth_password`, `last_login`, `create_date`) VALUES
(1, 'Admin', 'Admin', 'admin@mail.com', '39921a1b090e60ecebbf3599de6b7781', '2024-10-01 04:26:34', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `coupon_usage`
--

CREATE TABLE `coupon_usage` (
  `id` int(11) NOT NULL,
  `coupon_code` varchar(10) NOT NULL,
  `purchaseid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `exam_target`
--

CREATE TABLE `exam_target` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `exam_date` varchar(255) NOT NULL,
  `target` int(11) DEFAULT NULL,
  `overall` int(11) DEFAULT NULL,
  `listening` int(11) DEFAULT NULL,
  `reading` int(11) DEFAULT NULL,
  `writing` int(11) DEFAULT NULL,
  `speaking` int(11) DEFAULT NULL,
  `update_date` datetime NOT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `question_id` int(11) DEFAULT NULL,
  `feedback` text NOT NULL,
  `create_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `individual_task_scoring`
--

CREATE TABLE `individual_task_scoring` (
  `id` int(11) NOT NULL,
  `tasks_code` varchar(200) DEFAULT NULL,
  `tasks` varchar(200) DEFAULT NULL,
  `avg_questions` int(11) DEFAULT NULL,
  `total_marks` double DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `speaking` double DEFAULT NULL,
  `writing` double DEFAULT NULL,
  `reading` double DEFAULT NULL,
  `listening` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `individual_task_scoring`
--

INSERT INTO `individual_task_scoring` (`id`, `tasks_code`, `tasks`, `avg_questions`, `total_marks`, `points`, `speaking`, `writing`, `reading`, `listening`) VALUES
(1, 'repeat_sentences', 'Repeat Sentence', 10, 51.8, 13, 32.1, NULL, NULL, 19.7),
(2, 'wfds', 'Write From Dictation', 3, 46.5, 12, NULL, 26.8, NULL, 19.7),
(3, 'fib_wr', 'Reading & Writing：Fill in the blanks', 5, 44.4, 6, NULL, 22.3, 22.1, NULL),
(4, 'read_alouds', 'Read Aloud', 6, 44.3, 15, 22.2, NULL, 22.1, NULL),
(5, 'ssts', 'Summarize Spoken Text', 2, 25, 10, NULL, 11.9, NULL, 13.1),
(6, 'describe_images', 'Describe Image', 6, 22.2, 15, 22.2, NULL, NULL, NULL),
(7, 'retell_lectures', 'Re-tell Lecture', 3, 20.9, 15, 11.1, NULL, NULL, 9.9),
(8, 'swtx', 'Summarize Written Text', 2, 20.7, 7, NULL, 10.4, 10.3, NULL),
(9, 'hiws', 'Highlight Incorrect Words', 2, 16.7, 6, NULL, NULL, 8.9, 7.9),
(10, 'fib_rd', 'Reading：Fill in the Blanks', 4, 14.8, 5, NULL, NULL, 14.8, NULL),
(11, 'l_fib', 'Listening: Fill in the Blanks', 2, 14, 5, NULL, 7.4, NULL, 6.6),
(12, 'essays', 'Write Essay', 1, 11.2, 15, NULL, 11.2, NULL, NULL),
(13, 'answer_questions', 'Answer Short Question', 10, 9, 1, 2.5, NULL, NULL, 6.6),
(14, 'ro', 'Re-order Paragraphs', 2, 5.9, 4, NULL, NULL, 5.9, NULL),
(15, 'r_mcm', 'Reading: Multiple Choice (Multiple)', 2, 3, 2, NULL, NULL, 3, NULL),
(16, 'l_hcs', 'Highlight Correct Summary', 2, 2.8, 1, NULL, NULL, 1.5, 1.3),
(17, 'l_mcm', 'Listening: Multiple Choice (Multiple)', 2, 2.6, 2, NULL, NULL, NULL, 2.6),
(18, 'r_mcs', 'Reading: Multiple Choice (Single)', 2, 1.5, 1, NULL, NULL, 1.5, NULL),
(19, 'l_mcs', 'Listening: Multiple Choice (Single)', 2, 1.3, 1, NULL, NULL, NULL, 1.3),
(20, 'l_smw', 'Select Missing Word', 2, 1.3, 1, NULL, NULL, NULL, 1.3),
(21, 'respond_situation', 'Respond to a situation', 3, 20.9, 15, 11.1, NULL, NULL, 9.9),
(22, 'email', 'Write Email', 1, 11.2, 15, NULL, 11.2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `listening_answers`
--

CREATE TABLE `listening_answers` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `question_id` int(20) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `score` varchar(500) DEFAULT NULL,
  `component_score` text DEFAULT NULL,
  `mistakes` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `create_date` varchar(255) DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `listening_questions`
--

CREATE TABLE `listening_questions` (
  `id` int(20) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `audioPath` varchar(255) DEFAULT NULL,
  `original_file_name` varchar(500) DEFAULT NULL,
  `transcript` varchar(2000) DEFAULT NULL,
  `question` varchar(2000) DEFAULT NULL,
  `options` varchar(2000) DEFAULT NULL,
  `keywords` varchar(2000) DEFAULT NULL,
  `answer` varchar(2000) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `exam_duration` varchar(255) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL COMMENT 'type can be (l_mcm, ssts)	',
  `status` int(10) NOT NULL DEFAULT 1,
  `update_date` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `materials`
--

CREATE TABLE `materials` (
  `id` int(11) NOT NULL,
  `type` text DEFAULT NULL,
  `category` text DEFAULT NULL,
  `label_name` text DEFAULT NULL,
  `path` text DEFAULT NULL,
  `thumbnail` varchar(500) DEFAULT NULL,
  `language` varchar(255) NOT NULL DEFAULT 'EN',
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `last_updated` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `pte_type` varchar(20) NOT NULL DEFAULT 'academic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `mock_test`
--

CREATE TABLE `mock_test` (
  `id` int(20) NOT NULL,
  `title` varchar(1000) NOT NULL,
  `test_type` varchar(255) DEFAULT NULL,
  `test_sub_type` varchar(255) DEFAULT NULL,
  `reading` varchar(500) DEFAULT NULL,
  `writing` varchar(500) DEFAULT NULL,
  `listening` varchar(500) DEFAULT NULL,
  `speaking` varchar(500) DEFAULT NULL,
  `speaking_duration` varchar(10) DEFAULT NULL COMMENT 'in minutes',
  `writing_duration` varchar(10) DEFAULT NULL COMMENT 'in minutes',
  `reading_duration` varchar(10) DEFAULT NULL COMMENT 'in minutes',
  `listening_duration` varchar(10) DEFAULT NULL COMMENT 'in minutes',
  `section_duration` varchar(10) DEFAULT NULL,
  `create_date` varchar(250) NOT NULL,
  `pte_type` varchar(20) NOT NULL DEFAULT 'academic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_answers`
--

CREATE TABLE `mock_test_answers` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `mock_series` int(20) DEFAULT NULL,
  `mock_test_id` varchar(20) DEFAULT NULL,
  `question_id` int(20) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `score` varchar(500) DEFAULT NULL,
  `points` int(10) DEFAULT NULL,
  `component_score` text DEFAULT NULL,
  `answer_id` int(11) DEFAULT NULL,
  `mistakes` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `saved` tinyint(4) NOT NULL DEFAULT 0,
  `timestamp` int(20) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `update_date` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_logs`
--

CREATE TABLE `mock_test_logs` (
  `meta_id` bigint(11) NOT NULL,
  `studentId` bigint(11) NOT NULL,
  `mock_series` int(20) NOT NULL,
  `mock_test_id` varchar(20) NOT NULL,
  `meta_status` varchar(20) NOT NULL,
  `user_agent` text DEFAULT NULL,
  `browser` varchar(255) DEFAULT NULL,
  `platform` varchar(255) DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `student_name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `mock_test_results`
--

CREATE TABLE `mock_test_results` (
  `id` int(11) NOT NULL,
  `mock_test_id` varchar(255) NOT NULL,
  `mock_series` int(11) NOT NULL,
  `studentId` int(11) NOT NULL,
  `writing_score` int(11) DEFAULT NULL,
  `speaking_score` int(11) DEFAULT NULL,
  `listening_score` int(11) DEFAULT NULL,
  `reading_score` int(11) DEFAULT NULL,
  `overall_score` int(11) NOT NULL,
  `create_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `options`
--

CREATE TABLE `options` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `value` text DEFAULT NULL,
  `autoload` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `options`
--

INSERT INTO `options` (`id`, `name`, `value`, `autoload`) VALUES
(1, 'email_header', '<!doctype html>\n                            <html>\n                            <head>\n                              <meta name=\"viewport\" content=\"width=device-width\" />\n                              <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />\n                              <style>\n                                body {\n                                 background-color: #f6f6f6;\n                                 font-family: sans-serif;\n                                 -webkit-font-smoothing: antialiased;\n                                 font-size: 14px;\n                                 line-height: 1.4;\n                                 margin: 0;\n                                 padding: 0;\n                                 -ms-text-size-adjust: 100%;\n                                 -webkit-text-size-adjust: 100%;\n                               }\n                               table {\n                                 border-collapse: separate;\n                                 mso-table-lspace: 0pt;\n                                 mso-table-rspace: 0pt;\n                                 width: 100%;\n                               }\n                               table td {\n                                 font-family: sans-serif;\n                                 font-size: 14px;\n                                 vertical-align: top;\n                               }\n                                   /* -------------------------------------\n                                     BODY & CONTAINER\n                                     ------------------------------------- */\n                                     .body {\n                                       background-color: #f6f6f6;\n                                       width: 100%;\n                                     }\n                                     /* Set a max-width, and make it display as block so it will automatically stretch to that width, but will also shrink down on a phone or something */\n\n                                     .container {\n                                       display: block;\n                                       margin: 0 auto !important;\n                                       /* makes it centered */\n                                       max-width: 680px;\n                                       padding: 10px;\n                                       width: 680px;\n                                     }\n                                     /* This should also be a block element, so that it will fill 100% of the .container */\n\n                                     .content {\n                                       box-sizing: border-box;\n                                       display: block;\n                                       margin: 0 auto;\n                                       max-width: 680px;\n                                       padding: 10px;\n                                     }\n                                   /* -------------------------------------\n                                     HEADER, FOOTER, MAIN\n                                     ------------------------------------- */\n\n                                     .main {\n                                       background: #fff;\n                                       border-radius: 3px;\n                                       width: 100%;\n                                     }\n                                     .wrapper {\n                                       box-sizing: border-box;\n                                       padding: 20px;\n                                     }\n                                     .footer {\n                                       clear: both;\n                                       padding-top: 10px;\n                                       text-align: center;\n                                       width: 100%;\n                                     }\n                                     .footer td,\n                                     .footer p,\n                                     .footer span,\n                                     .footer a {\n                                       color: #999999;\n                                       font-size: 12px;\n                                       text-align: center;\n                                     }\n                                     hr {\n                                       border: 0;\n                                       border-bottom: 1px solid #f6f6f6;\n                                       margin: 20px 0;\n                                     }\n                                   /* -------------------------------------\n                                     RESPONSIVE AND MOBILE FRIENDLY STYLES\n                                     ------------------------------------- */\n\n                                     @media only screen and (max-width: 620px) {\n                                       table[class=body] .content {\n                                         padding: 0 !important;\n                                       }\n                                       table[class=body] .container {\n                                         padding: 0 !important;\n                                         width: 100% !important;\n                                       }\n                                       table[class=body] .main {\n                                         border-left-width: 0 !important;\n                                         border-radius: 0 !important;\n                                         border-right-width: 0 !important;\n                                       }\n                                     }\n                                   </style>\n                                 </head>\n                                 <body class=\"\">\n                                  <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" class=\"body\">\n                                    <tr>\n                                     <td>&nbsp;</td>\n                                     <td class=\"container\">\n                                      <div class=\"content\">\n<!--<img style=\"center\" src=\"https://support.rethinkingweb.com/uploads/company/181fbc62f339f3ec0f64a3f3fd146a47.jpg\"/>-->\n                                        <!-- START CENTERED WHITE CONTAINER -->\n                                        <table class=\"main\">\n                                          <!-- START MAIN CONTENT AREA -->\n                                          <tr>\n                                           <td class=\"wrapper\">\n                                            <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n                                              <tr>\n                                               <td>', 1),
(2, 'email_footer', '</td>\n                             </tr>\n                           </table>\n                         </td>\n                       </tr>\n                       <!-- END MAIN CONTENT AREA -->\n                     </table>\n                     <!-- START FOOTER -->\n                     <div class=\"footer\">\n                      <table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">\n                        <tr>\n                          <td class=\"content-block\">\n                            <span>This is an automated email, so please don\'t reply to this email address</span>\n                          </td>\n                        </tr>\n                      </table>\n                    </div>\n                    <!-- END FOOTER -->\n                    <!-- END CENTERED WHITE CONTAINER -->\n                  </div>\n                </td>\n                <td>&nbsp;</td>\n              </tr>\n            </table>\n            </body>\n            </html>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `packages`
--

CREATE TABLE `packages` (
  `packageid` int(11) NOT NULL,
  `package_name` varchar(500) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cost` int(11) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `duration_type` varchar(255) NOT NULL,
  `usage_type` varchar(20) DEFAULT 'regular',
  `package_category` varchar(255) DEFAULT NULL,
  `is_purchaseable` tinyint(4) DEFAULT NULL,
  `show_videos` tinyint(4) NOT NULL DEFAULT 0,
  `show_materials` tinyint(4) NOT NULL DEFAULT 0,
  `show_class_links` tinyint(4) NOT NULL DEFAULT 0,
  `addon_language` varchar(255) DEFAULT NULL,
  `desc` varchar(255) NOT NULL,
  `category_type_ids` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `attempt_limit` int(11) NOT NULL DEFAULT 0,
  `last_updated` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `pte_type` varchar(20) NOT NULL DEFAULT 'academic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `productid` int(11) NOT NULL,
  `buyerid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `create_date` datetime NOT NULL,
  `amount` int(11) NOT NULL,
  `stripe_productid` varchar(255) NOT NULL,
  `stripe_priceid` varchar(255) NOT NULL,
  `stripe_sessionid` varchar(255) NOT NULL,
  `last_updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchaseid` int(11) NOT NULL,
  `paymentid` int(11) NOT NULL,
  `product` varchar(255) NOT NULL,
  `productid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `expire_date` datetime NOT NULL,
  `create_date` datetime NOT NULL,
  `last_updated` datetime DEFAULT NULL,
  `is_expired` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `question_categories`
--

CREATE TABLE `question_categories` (
  `id` int(20) NOT NULL,
  `question_code` varchar(255) DEFAULT NULL,
  `type_name` varchar(255) DEFAULT NULL,
  `type_description` varchar(500) DEFAULT NULL,
  `question_category` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL,
  `pte_type` varchar(20) NOT NULL DEFAULT 'academic'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `question_categories`
--

INSERT INTO `question_categories` (`id`, `question_code`, `type_name`, `type_description`, `question_category`, `create_date`, `pte_type`) VALUES
(1, 'ssts', 'Summarize Spoken Text', 'You will hear a short report. Write a summary for a fellow student who was not present. You should write 50-70 words. You have 10 minutes to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points presented in the lecture.', 'Listening', '2023-01-06', 'academic'),
(2, 'l_mcm', 'Multiple Choice (Multiple)', 'Listen to the recording and answer the question by selecting all the correct responses. You will need to select more than one response.', 'Listening', '2023-01-06', 'academic'),
(5, 'swtx', 'Summarize Written Text', 'Read the passage below and summarize it using one sentence. Type your response in the box at the bottom of the screen. You have 10 minutes to finish this task. Your response will be judged on the quality of your writing and on how well your response presents the key points in the passage.', 'Writing', '2023-01-07', 'academic'),
(6, 'essays', 'Write Essay', 'You will have 20 minutes to plan, write and revise an essay about the topic below. Your response will be judged on how well you develop a position, organize your ideas, present supporting details, and control the elements of standard written English. You should write 200-300 words.', 'Writing', '2023-01-07', 'academic'),
(7, 'l_mcs', 'Multiple Choice (Single)', 'Listen to the recording and answer the single-choice question by selectingthe correct response . Only one response is correct.', 'Listening', '2023-01-09', 'academic'),
(8, 'l_hcs', 'Highlight Correct Summary', 'You will hear a recording. Click on the paragraph that best relates to the recording.', 'Listening', '2023-01-09', 'academic'),
(9, 'l_smw', 'Select Missing Word', 'You will hear a recording about fiction writing. At the end of the recording the lost word or group of words has been replaced by a beep. Select the correct option to complete the recording.', 'Listening', '2023-01-09', 'academic'),
(10, 'wfds', 'Write From Dictation', 'You will hear a sentence. Type the sentence in the box below exactly as you hear it. Write as much of the sentence as you can. You will hear the sentence only once.', 'Listening', '2023-01-09', 'academic'),
(11, 'l_fib', 'Fill in the Blanks', 'You will hear a recording. Type the missing words in each blank.', 'Listening', '2023-01-09', 'academic'),
(12, 'read_alouds', 'Read Aloud', 'Look at the text below. In 40 seconds, you must read this text aloud as naturally and clearly as possible. You have 40 seconds to read aloud.', 'Speaking', '2023-01-09', 'academic'),
(13, 'repeat_sentences', 'Repeat Sentence', 'You will hear a sentence. Please repeat the sentence exactly as you hear it. You will hear the sentence only once.', 'Speaking', '2023-01-09', 'academic'),
(14, 'describe_images', 'Describe Image', 'Look at the graph below. In 25 seconds, please speak into the microphone and describe in detail what the graph is showing. You will have 40 seconds to give your response.', 'Speaking', '2023-01-12', 'academic'),
(15, 'retell_lectures', 'Re-tell Lecture', 'You will hear a lecture. After listening to the lecture, in 10 seconds, please speak into the microphone and retell what you have just heard from the lecture in your own words. You will have 40 seconds to give your response.', 'Speaking', '2023-01-12', 'academic'),
(16, 'answer_questions', 'Answer Short Question', 'You will hear a question. Please give a simple and short answer. Often just one or a few words is enough.', 'Speaking', '2023-01-12', 'academic'),
(17, 'hiws', 'Highlight Incorrect Words', 'You will hear a recording. Below is a transcription of the recording. Some words in the transcription differ from what the speaker said. Please click on the words that are different.', 'Listening', '2023-01-19', 'academic'),
(18, 'fib_wr', 'Reading & Writing：Fill in the blanks', 'There are some words missing in the following text. Please select the correct word in the drop-down box.', 'Reading', '2023-01-19', 'academic'),
(19, 'r_mcm', 'Multiple Choice (Multiple)', 'Read the text and answer the question by selecting all the correct responses. More than one response is correct.', 'Reading', '2023-01-19', 'academic'),
(20, 'fib_rd', 'Reading：Fill in the Blanks', 'There are some words missing in the following text. Please select the correct word in the drop-down box.', 'Reading', '2023-01-19', 'academic'),
(21, 'r_mcs', 'Multiple Choice (Single)\r\n', 'Read the text and answer the multiple-choice question by selecting the correct response. Only one response is correct.', 'Reading', '2023-01-19', 'academic'),
(22, 'ro', 'Re-order Paragraphs', 'The text boxes in the left panel have been placed in a random order. Restore the original order by dragging the text boxes from the left panel to the right panel.', 'Reading', '2023-01-19', 'academic'),
(23, 'email', 'Write Email', 'You will have 9 minutes to plan, write and revise an email about the topic below. You should aim to write atleast 100 words. Write using complete sentences.', 'Writing', '2024-03-04', 'core'),
(24, 'respond_situation', 'Respond to a situation', 'You will have 20 seconds to think about your answer . Then you will hear a beep . You will have 40 seconds to answer the question . Please answer as completely as you can .', 'Speaking', '2024-03-04', 'core');

-- --------------------------------------------------------

--
-- Table structure for table `reading_answers`
--

CREATE TABLE `reading_answers` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `question_id` int(20) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `score` varchar(500) DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reading_questions`
--

CREATE TABLE `reading_questions` (
  `id` int(20) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `question` varchar(2000) DEFAULT NULL,
  `options` varchar(2000) DEFAULT NULL,
  `answer` varchar(2000) DEFAULT NULL,
  `exam_duration` varchar(255) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL COMMENT 'type can be (fib_wr, r_mcm, ro, fib_rd, r_mcs)	',
  `status` int(10) NOT NULL DEFAULT 1,
  `update_date` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `resource_uploads`
--

CREATE TABLE `resource_uploads` (
  `id` int(11) NOT NULL,
  `path` text DEFAULT NULL,
  `original_file_name` varchar(500) DEFAULT NULL,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `scheduled_emails`
--

CREATE TABLE `scheduled_emails` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `template` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `speaking_answers`
--

CREATE TABLE `speaking_answers` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `question_id` int(20) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `answer` varchar(2000) DEFAULT NULL,
  `score` varchar(500) DEFAULT NULL,
  `component_score` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `answer_transcript` text DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `speaking_questions`
--

CREATE TABLE `speaking_questions` (
  `id` int(20) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `resourcePath` varchar(255) DEFAULT NULL,
  `original_file_name` varchar(500) DEFAULT NULL,
  `transcript` varchar(2000) DEFAULT NULL,
  `question` varchar(2000) DEFAULT NULL,
  `keywords` varchar(2000) DEFAULT NULL,
  `answer` varchar(2000) DEFAULT NULL,
  `exam_duration` varchar(255) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL COMMENT 'type can be (l_mcm, ssts)	',
  `status` int(10) NOT NULL DEFAULT 1,
  `update_date` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `studentuser`
--

CREATE TABLE `studentuser` (
  `studentId` int(50) NOT NULL,
  `first_name` varchar(500) DEFAULT NULL,
  `last_name` varchar(500) DEFAULT NULL,
  `email` varchar(500) NOT NULL,
  `country_code` varchar(20) DEFAULT NULL,
  `phone` bigint(20) DEFAULT NULL,
  `auth_password` varchar(500) NOT NULL,
  `citizenship_country` varchar(255) DEFAULT NULL,
  `residence_country` varchar(255) DEFAULT NULL,
  `residence_state` varchar(255) DEFAULT NULL,
  `mother_tongue` varchar(255) DEFAULT NULL,
  `branch` varchar(255) DEFAULT NULL,
  `desired_band` decimal(5,0) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `last_login` varchar(500) DEFAULT NULL,
  `last_updated` datetime DEFAULT NULL,
  `create_date` varchar(255) DEFAULT NULL,
  `created_by` varchar(255) DEFAULT NULL,
  `validity` datetime DEFAULT NULL,
  `student_type` varchar(255) DEFAULT NULL,
  `ak_coupon_code` varchar(10) DEFAULT NULL,
  `profile_completed` tinyint(4) DEFAULT 0,
  `pte_core_access` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Triggers `studentuser`
--
DELIMITER $$
CREATE TRIGGER `schedule_applykart_reminder_email` AFTER INSERT ON `studentuser` FOR EACH ROW INSERT INTO scheduled_emails (student_id, scheduled_at, template) VALUES (NEW.studentId, DATE_ADD(NEW.create_date, INTERVAL 1 DAY), 'APPLYKART_REMINDER_CRON')
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_auto_login`
--

CREATE TABLE `user_auto_login` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `writing_answers`
--

CREATE TABLE `writing_answers` (
  `id` int(20) NOT NULL,
  `user_id` int(20) NOT NULL,
  `question_id` int(20) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `score` varchar(500) DEFAULT NULL,
  `component_score` text DEFAULT NULL,
  `mistakes` text DEFAULT NULL,
  `suggestion` text DEFAULT NULL,
  `create_date` varchar(255) DEFAULT '0000-00-00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `writing_questions`
--

CREATE TABLE `writing_questions` (
  `id` int(20) NOT NULL,
  `title` varchar(1000) DEFAULT NULL,
  `question` varchar(2000) DEFAULT NULL,
  `keywords` varchar(2000) DEFAULT NULL,
  `answer` varchar(2000) DEFAULT NULL,
  `explanation` text DEFAULT NULL,
  `exam_duration` varchar(255) DEFAULT NULL,
  `question_type` varchar(255) DEFAULT NULL COMMENT 'type can be (ssts,swtx)	',
  `status` int(10) NOT NULL DEFAULT 1,
  `update_date` varchar(255) DEFAULT NULL,
  `create_date` varchar(255) DEFAULT '0000-00-00',
  `additional_json` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userid` (`userid`);

--
-- Indexes for table `auth_users`
--
ALTER TABLE `auth_users`
  ADD PRIMARY KEY (`authId`);

--
-- Indexes for table `coupon_usage`
--
ALTER TABLE `coupon_usage`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_target`
--
ALTER TABLE `exam_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `individual_task_scoring`
--
ALTER TABLE `individual_task_scoring`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listening_answers`
--
ALTER TABLE `listening_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `listening_questions`
--
ALTER TABLE `listening_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `materials`
--
ALTER TABLE `materials`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_test`
--
ALTER TABLE `mock_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_test_answers`
--
ALTER TABLE `mock_test_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mock_test_logs`
--
ALTER TABLE `mock_test_logs`
  ADD PRIMARY KEY (`meta_id`);

--
-- Indexes for table `mock_test_results`
--
ALTER TABLE `mock_test_results`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `options`
--
ALTER TABLE `options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `packages`
--
ALTER TABLE `packages`
  ADD PRIMARY KEY (`packageid`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchaseid`);

--
-- Indexes for table `question_categories`
--
ALTER TABLE `question_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_answers`
--
ALTER TABLE `reading_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reading_questions`
--
ALTER TABLE `reading_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `resource_uploads`
--
ALTER TABLE `resource_uploads`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speaking_answers`
--
ALTER TABLE `speaking_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `speaking_questions`
--
ALTER TABLE `speaking_questions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `studentuser`
--
ALTER TABLE `studentuser`
  ADD PRIMARY KEY (`studentId`);

--
-- Indexes for table `writing_answers`
--
ALTER TABLE `writing_answers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `writing_questions`
--
ALTER TABLE `writing_questions`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auth_users`
--
ALTER TABLE `auth_users`
  MODIFY `authId` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `coupon_usage`
--
ALTER TABLE `coupon_usage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_target`
--
ALTER TABLE `exam_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `individual_task_scoring`
--
ALTER TABLE `individual_task_scoring`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `listening_answers`
--
ALTER TABLE `listening_answers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `listening_questions`
--
ALTER TABLE `listening_questions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materials`
--
ALTER TABLE `materials`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mock_test`
--
ALTER TABLE `mock_test`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mock_test_answers`
--
ALTER TABLE `mock_test_answers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mock_test_logs`
--
ALTER TABLE `mock_test_logs`
  MODIFY `meta_id` bigint(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mock_test_results`
--
ALTER TABLE `mock_test_results`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `options`
--
ALTER TABLE `options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `packages`
--
ALTER TABLE `packages`
  MODIFY `packageid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchaseid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `question_categories`
--
ALTER TABLE `question_categories`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `reading_answers`
--
ALTER TABLE `reading_answers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reading_questions`
--
ALTER TABLE `reading_questions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `resource_uploads`
--
ALTER TABLE `resource_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `scheduled_emails`
--
ALTER TABLE `scheduled_emails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speaking_answers`
--
ALTER TABLE `speaking_answers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `speaking_questions`
--
ALTER TABLE `speaking_questions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `studentuser`
--
ALTER TABLE `studentuser`
  MODIFY `studentId` int(50) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `writing_answers`
--
ALTER TABLE `writing_answers`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `writing_questions`
--
ALTER TABLE `writing_questions`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
