SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `messages`
-- ----------------------------

DROP DATABASE IF EXISTS telemetry_db;

CREATE DATABASE IF NOT EXISTS telemetry_db COLLATE utf8_unicode_ci;

--
-- Create the user account
--
GRANT SELECT, INSERT ON telemetry_db.* TO telemetry_user@localhost IDENTIFIED BY 'telemetry_user_pass';

USE telemetry_db;

DROP TABLE IF EXISTS `messages`;
CREATE TABLE `messages` (
  `mesasge_id` int(4) NOT NULL AUTO_INCREMENT,
  `source_msisdn` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `dest_msisdn` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `bearer` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `message_ref` varchar(15) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `received_time` varchar(25) NOT NULL,
  `device_id` varchar(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `switch_a` int(1) NOT NULL,
  `switch_b` int(1) NOT NULL,
  `switch_c` int(1) NOT NULL,
  `switch_d` int(1) NOT NULL,
  `fan` int(1) NOT NULL,
  `h_temp` double NOT NULL,
  `last_key` int(1) NOT NULL,
  PRIMARY KEY (`mesasge_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company_name
-- ----------------------------

-- ----------------------------
-- Table structure for `error_log`
-- ----------------------------
DROP TABLE IF EXISTS `error_log`;
CREATE TABLE `error_log` (
  `log_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `log_message` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`log_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


