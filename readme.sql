-- 9-Aug-23
ALTER TABLE `writing_questions` CHANGE `explanation` `explanation` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL;

ALTER TABLE `listening_questions` ADD `explanation` TEXT NULL AFTER `answer`;

ALTER TABLE `studentuser` ADD `phone` BIGINT(20) NULL AFTER `email`;
ALTER TABLE `studentuser` ADD `profile_completed` TINYINT(4) DEFAULT 0;

ALTER TABLE `studentuser` ADD `citizenship_country` VARCHAR(255) NULL AFTER `auth_password`, ADD `residence_country` VARCHAR(255) NULL AFTER `citizenship_country`, ADD `residence_state` VARCHAR(255) NULL AFTER `residence_country`, ADD `mother_tongue` VARCHAR(255) NULL AFTER `residence_state`, ADD `branch` VARCHAR(255) NULL AFTER `mother_tongue`, ADD `desired_band` DECIMAL(5,0) NULL AFTER `branch`, ADD `profile_picture` VARCHAR(255) NULL AFTER `desired_band`;

ALTER TABLE `studentuser` ADD `update_date` VARCHAR(255) NULL AFTER `create_date`;

-- 18-08-23

ALTER TABLE `mock_test` ADD `test_type` VARCHAR(255) NULL AFTER `title`;

ALTER TABLE `mock_test` ADD `test_sub_type` VARCHAR(255) NULL AFTER `test_type`;

-- 25-Aug-23
ALTER TABLE `mock_test` ADD `section_duration` INT(10) NULL AFTER `listening_duration`;

ALTER TABLE `speaking_answers` ADD `answer_transcript` TEXT NULL AFTER `suggestion`;

ALTER TABLE `speaking_questions` ADD `original_file_name` VARCHAR(500) NULL;
ALTER TABLE `listening_questions` ADD `original_file_name` VARCHAR(500) NULL;

-- 16-Sep-23
CREATE TABLE `packages` (
  `packageid` int(11) NOT NULL,
  `package_name` varchar(500) DEFAULT NULL,
  `cost` varchar(255) NOT NULL,
  `duration` varchar(255) DEFAULT NULL,
  `duration_type` varchar(255) NOT NULL,
  `package_category` varchar(255) DEFAULT NULL,
  `is_purchaseable` tinyint(4) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `category_type_ids` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `last_updated` datetime DEFAULT NULL,
  `created_on` datetime DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL
);

ALTER TABLE `packages` ADD `description` TEXT NULL AFTER `package_name`;

-- 19-Sep-23
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
);

ALTER TABLE `purchases` ADD PRIMARY KEY (`purchaseid`);

ALTER TABLE `purchases` MODIFY `purchaseid` int(11) NOT NULL AUTO_INCREMENT;

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
);

ALTER TABLE `payments` ADD PRIMARY KEY (`id`);

ALTER TABLE `payments` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `studentuser` ADD `status` TINYINT(4) NOT NULL DEFAULT '1' AFTER `profile_picture`;

ALTER TABLE `studentuser` ADD `created_by` VARCHAR(255) NULL;

ALTER TABLE `studentuser` ADD `validity` datetime NULL;

ALTER TABLE `studentuser` ADD `student_type` VARCHAR(255) NULL;

-- 04-Oct-23
ALTER TABLE `studentuser` ADD `last_updated` DATETIME NULL AFTER `last_login`;

ALTER TABLE `packages` ADD `attempt_limit` INT(11) NOT NULL DEFAULT '0' AFTER `status`;

-- 10-Oct-23
CREATE TABLE `mock_test_results` (
  `id` INT(11) NOT NULL , 
  `mock_test_id` varchar(255) NOT NULL , 
  `mock_series` INT(11) NOT NULL , 
  `studentId` INT(11) NOT NULL ,
  `writing_score` INT(11) DEFAULT NULL , 
  `speaking_score` INT(11) DEFAULT NULL , 
  `listening_score` INT(11) DEFAULT NULL , 
  `reading_score` INT(11) DEFAULT NULL , 
  `overall_score` INT(11) NOT NULL , 
  `create_date` varchar(255) NOT NULL
  );

ALTER TABLE `mock_test_results` ADD PRIMARY KEY (`id`);

ALTER TABLE `mock_test_results` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `packages` ADD `show_videos` TINYINT(4) NOT NULL DEFAULT '0' AFTER `is_purchaseable`;

ALTER TABLE `mock_test_answers` ADD `answer_id` int(11) NULL AFTER `component_score`;

--07-12-23
CREATE TABLE `feedbacks` (
  `id` INT(11) NOT NULL , 
  `user_id` INT(11) NOT NULL , 
  `feedback` TEXT NOT NULL , 
  `create_date` datetime DEFAULT NULL
);

ALTER TABLE `feedbacks` ADD PRIMARY KEY (`id`);

ALTER TABLE `feedbacks` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `feedbacks` ADD `question_type` VARCHAR(255) NULL AFTER `user_id`, ADD `question_id` INT(11) NULL AFTER `question_type`;
CREATE TABLE `materials` (`id` INT NOT NULL , `type` TEXT NULL , `path` TEXT NULL , `last_updated` DATETIME NOT NULL , `create_date` DATETIME NOT NULL );
ALTER TABLE `materials` ADD `status` TINYINT(4) NOT NULL DEFAULT '0' AFTER `path`;
ALTER TABLE `materials` ADD `label_name` TEXT NULL AFTER `type`;
ALTER TABLE `materials` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, add PRIMARY KEY (`id`);
ALTER TABLE `materials` ADD `category` TEXT NULL AFTER `type`;
ALTER TABLE `packages` ADD `show_materials` TINYINT(4) NOT NULL DEFAULT '0' AFTER `show_videos`;


INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Read Aloud Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/UvcwdNAPhsU', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Read Aloud / Example', 'https://www.youtube.com/embed/9c7grBC1sDg', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Repeat Sentence Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/Oh7-iRQ0XuE', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Repeat Sentence / Example', 'https://www.youtube.com/embed/ng40cO-bIkI', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Describe Image by Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/01JxSIELU9Q', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Describe Image / Example', 'https://www.youtube.com/embed/UAVml42nKUw', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Re-tell Lecture Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/hyEwLzAPd_U', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Re-tell Lecture / Example', 'https://www.youtube.com/embed/0DAGLlEy_oQ', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Answer Short Question Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/Jx0GfRPUj6g', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Speaking - Answer short Question / Example', 'https://www.youtube.com/embed/am5LIRShcmI', 'speaking', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Writing - Summarise Written Text Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/9jAu-fYk1R4', 'writing', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Writing - Summarise Written Text / Example', 'https://www.youtube.com/embed/S5qWgbptIyk', 'writing', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Writing - Write Essay Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/ObkDKBYDM1Y', 'writing', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Writing - Write essay / Example', 'https://www.youtube.com/embed/KixJY9C73cc', 'writing', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - MCCMA Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/e06BJmkPWOY', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - MCCMA / Example', 'https://www.youtube.com/embed/kh__bm4Cm8A', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - Re-Order Paragraph Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/2h6-UHu-0C8', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - Re-order Paragraph / Example', 'https://www.youtube.com/embed/YxzhuWoq-sg', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - Fill in the Blanks Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/Z4t1wQLMMcI', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - Fill in the Blanks / Example', 'https://www.youtube.com/embed/5J8tLDWtE2Y', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - MCCSA Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/tKTScNg3vZs', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading - MCCSA / Example', 'https://www.youtube.com/embed/wKtghFyYag8', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading & Writing - Fill in the Blanks Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/cTMqFCAKh2Q', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Reading & Writing Fill in the Blanks / Example', 'https://www.youtube.com/embed/2nlOAHI2L_g', 'reading', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Summarize Spoken Text Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/qWv33lj1cXM', 'listening', 1, '2023-12-26 11:25:26', '2023-12-26 11:25:26');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Summarise Spoken Text / Example', 'https://www.youtube.com/embed/HQkQ2fWOBzs', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - MCCMA Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/N_pE9HKM7SU', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - MCCMA / Example', 'https://www.youtube.com/embed/jr4TuhZuSoc', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Fill in the blanks Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/cuRje-_vZmc', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Fill in the Blanks / Example', 'https://www.youtube.com/embed/y5B5EvYPwPU', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Highlight Correct Summary Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/7msB0rbsHN0', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - highlight correct summary / Example', 'https://www.youtube.com/embed/Cn3M8sLPM4g', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - MCCSA Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/W5HOWjcLuz4', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - MCCSA / Example', 'https://www.youtube.com/embed/LoJiI7Uaieo', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Select Missing Word Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/sdF8D4nWBsk', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Select missing words / Example', 'https://www.youtube.com/embed/2SooOilNFjE', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Highlight Incorrect Words Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/-eduBJDbcAk', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Highlight incorrect words / Example', 'https://www.youtube.com/embed/ZjXQr2J4izY', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Write from Dictation Malcolm 2023 / Explanation', 'https://www.youtube.com/embed/thw-ip0yZiU', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');
INSERT INTO `materials` (`type`, `label_name`, `path`, `category`, `status`, `create_date`, `last_updated`) VALUES ('video', 'Listening - Write from Dictation / Example', 'https://www.youtube.com/embed/JnYy9JZOJ6E', 'listening', 1, '2023-12-26 11:25:27', '2023-12-26 11:25:27');

ALTER TABLE `packages` ADD `show_class_links` TINYINT(4) NOT NULL DEFAULT '0' AFTER `show_materials`;

--20-03-24 - Add by Akshita
ALTER TABLE `mock_test` ADD `pte_type` VARCHAR(20) NOT NULL DEFAULT 'academic';
ALTER TABLE `packages` ADD `pte_type` VARCHAR(20) NOT NULL DEFAULT 'academic';
ALTER TABLE `question_categories` ADD `pte_type` VARCHAR(20) NOT NULL DEFAULT 'academic';
ALTER TABLE `materials` ADD `pte_type` VARCHAR(20) NOT NULL DEFAULT 'academic';
INSERT INTO `question_categories` (`question_code`, `type_name`, `pte_type`, `type_description`, `question_category`, `create_date`) VALUES ('email', 'Write Email', 'core', 'You will have 9 minutes to plan, write and revise an email about the topic below. You should aim to write atleast 100 words. Write using complete sentences.', 'Writing', '2024-03-04');
INSERT INTO `question_categories` (`question_code`, `type_name`, `pte_type`, `type_description`, `question_category`, `create_date`) VALUES ('respond_situation', 'Respond to a situation', 'core', 'You will have 20 seconds to think about your answer . Then you will hear a beep . You will have 40 seconds to answer the question . Please answer as completely as you can .', 'Speaking', '2024-03-04');

ALTER TABLE `writing_questions` ADD `additional_json` TEXT NULL ;

-- 15-05-24

ALTER TABLE `mock_test_answers` ADD `saved` TINYINT(4) NOT NULL DEFAULT '0' AFTER `status`;
update `mock_test_answers` set `saved` = 1 where `status` = 3;

CREATE TABLE `mock_test_logs` (
  `meta_id` BIGINT(11) NOT NULL AUTO_INCREMENT , 
  `studentId` BIGINT(11) NOT NULL , 
  `student_name` VARCHAR(255) NULL DEFAULT NULL , 
  `mock_series` INT(20) NOT NULL , 
  `mock_test_id` VARCHAR(20) NOT NULL , 
  `meta_status` VARCHAR(20) NOT NULL , 
  `user_agent` TEXT NULL DEFAULT NULL , 
  `browser` VARCHAR(255) NULL DEFAULT NULL , 
  `platform` VARCHAR(255) NULL DEFAULT NULL , 
  `create_date` DATETIME NOT NULL , 
  PRIMARY KEY (`meta_id`));

ALTER TABLE `mock_test_answers` 
ADD `user_agent` TEXT NULL DEFAULT NULL AFTER `timestamp`, 
ADD `browser` VARCHAR(255) NULL DEFAULT NULL AFTER `user_agent`, 
ADD `platform` VARCHAR(255) NULL DEFAULT NULL AFTER `browser`;


--27-05-24
CREATE TABLE `user_auto_login` (
  `key_id` char(32) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_agent` varchar(150) NOT NULL,
  `last_ip` varchar(40) NOT NULL,
  `last_login` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
);

ALTER TABLE `mock_test_logs` ADD `description` TEXT NULL AFTER `student_name`;

CREATE TABLE `resource_uploads` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `path` TEXT NULL , `original_file_name` VARCHAR(500) NULL , 
  `create_date` DATETIME NOT NULL , PRIMARY KEY (`id`));

--28-06-24
ALTER TABLE `packages` ADD `addon_language` VARCHAR(255) NULL DEFAULT NULL AFTER `show_class_links`;
ALTER TABLE `materials` ADD `language` VARCHAR(255) NOT NULL DEFAULT 'EN' AFTER `path`;

--2-7-24
ALTER TABLE `studentuser` ADD `country_code` VARCHAR(20) NULL AFTER `email`;

--05-07-24
ALTER TABLE `materials` ADD `thumbnail` VARCHAR(500) NULL AFTER `path`;

--05-07-24
CREATE TABLE `options` (
  `id` INT(11) NOT NULL AUTO_INCREMENT , 
  `name` TEXT NULL , 
  `value` TEXT NULL , 
  `autoload` TINYINT(4) NOT NULL , PRIMARY KEY (`id`)
);

ALTER TABLE `studentuser` ADD `ak_coupon_code` VARCHAR(10) NULL AFTER `student_type`;

CREATE TABLE `activity_log` (
  `id` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` datetime NOT NULL,
  `userid` varchar(100) DEFAULT NULL
);;
ALTER TABLE `activity_log` ADD PRIMARY KEY (`id`), ADD KEY `userid` (`userid`);
ALTER TABLE `activity_log` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `packages` ADD `usage_type` VARCHAR(20) NULL DEFAULT 'regular' AFTER `duration_type`;

CREATE TABLE `coupon_usage` (
  `id` INT(11) NOT NULL AUTO_INCREMENT , 
  `coupon_code` VARCHAR(10) NOT NULL , 
  `purchaseid` INT(11) NOT NULL , 
  `studentid` INT(11) NOT NULL , 
  `create_date` DATETIME NOT NULL , PRIMARY KEY (`id`));

--05-09-24
--NEW TRIGGER
CREATE TABLE `scheduled_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `scheduled_at` datetime NOT NULL,
  `template` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TRIGGER `schedule_applykart_reminder_email` AFTER INSERT ON `studentuser` FOR EACH ROW INSERT INTO scheduled_emails (student_id, scheduled_at, template) VALUES (NEW.studentId, DATE_ADD(NEW.create_date, INTERVAL 1 DAY), 'APPLYKART_REMINDER_CRON');