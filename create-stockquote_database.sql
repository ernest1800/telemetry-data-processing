SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `company_name`
-- ----------------------------

DROP DATABASE IF EXISTS stockquote_db;

CREATE DATABASE IF NOT EXISTS stockquote_db COLLATE utf8_unicode_ci;

--
-- Create the user account
--
GRANT SELECT, INSERT ON stockquote_db.* TO stockquote_user@localhost IDENTIFIED BY 'stockquote_user_pass';

USE stockquote_db;

DROP TABLE IF EXISTS `company_name`;
CREATE TABLE `company_name` (
  `stock_company_name_id` int(4) NOT NULL AUTO_INCREMENT,
  `stock_company_symbol` char(3) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `stock_company_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`stock_company_name_id`)
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of company_name
-- ----------------------------
INSERT INTO `company_name` VALUES ('16', 'IBM', 'INTL BUSINESS MAC');
INSERT INTO `company_name` VALUES ('17', 'MAA', 'MID AMER APT COMM');
INSERT INTO `company_name` VALUES ('18', 'MAB', 'EATON VANCE C-E F');
INSERT INTO `company_name` VALUES ('19', 'MAC', 'MACERICH CO');
INSERT INTO `company_name` VALUES ('20', 'MAD', 'MADECO SA');
INSERT INTO `company_name` VALUES ('21', 'MSN', 'EMERSON RADIO');
INSERT INTO `company_name` VALUES ('22', 'FFD', 'MORGAN STANLEY');
INSERT INTO `company_name` VALUES ('23', 'ACB', 'ADELANTE SHARES C');
INSERT INTO `company_name` VALUES ('24', 'ABC', 'AMERISOURCEBERGEN');
INSERT INTO `company_name` VALUES ('25', 'DDT', 'DILLARDS CAP 7.5');
INSERT INTO `company_name` VALUES ('27', 'CCI', 'CROWN CASTLE INTL');
INSERT INTO `company_name` VALUES ('28', 'CFI', 'CULP INC');
INSERT INTO `company_name` VALUES ('29', 'MFI', 'MicroFinancial In');
INSERT INTO `company_name` VALUES ('39', 'BBD', 'Banco Bradesco Sa');
INSERT INTO `company_name` VALUES ('43', 'AAN', 'Aaron\'s');
INSERT INTO `company_name` VALUES ('44', 'RBS', 'Royal Bank of Sco');
INSERT INTO `company_name` VALUES ('45', 'RAD', 'Rite Aid Corporat');
INSERT INTO `company_name` VALUES ('46', 'ABH', 'AbitibiBowater In');
INSERT INTO `company_name` VALUES ('47', 'ACP', 'Avenue Income Cre');
INSERT INTO `company_name` VALUES ('48', 'MFT', 'Blackrock MuniYie');
INSERT INTO `company_name` VALUES ('49', 'FB', 'Facebook');
INSERT INTO `company_name` VALUES ('50', 'MBA', 'CIBT Education Gr');

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

-- ----------------------------
-- Records of error_log
-- ----------------------------

-- ----------------------------
-- Table structure for `stock_data`
-- ----------------------------
DROP TABLE IF EXISTS `stock_data`;
CREATE TABLE `stock_data` (
  `stock_data_id` int(10) NOT NULL AUTO_INCREMENT,
  `fk_company_stock_id` int(10) NOT NULL,
  `stock_date` date NOT NULL,
  `stock_time` time NOT NULL,
  `stock_last_value` double NOT NULL,
  PRIMARY KEY (`stock_data_id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of stock_data
-- ----------------------------
INSERT INTO `stock_data` VALUES ('1', '20', '2009-01-28', '03:34:00', '6.74');
INSERT INTO `stock_data` VALUES ('2', '18', '2009-01-30', '11:34:00', '11.07');
INSERT INTO `stock_data` VALUES ('3', '19', '2009-01-30', '04:01:00', '14.74');
INSERT INTO `stock_data` VALUES ('4', '19', '2009-01-30', '11:41:00', '14.95');
INSERT INTO `stock_data` VALUES ('5', '17', '2009-01-30', '04:06:00', '29.54');
INSERT INTO `stock_data` VALUES ('6', '17', '2009-01-30', '11:33:00', '29.94');
INSERT INTO `stock_data` VALUES ('7', '16', '2009-01-30', '04:01:00', '91.65');
INSERT INTO `stock_data` VALUES ('8', '16', '2009-01-30', '11:35:00', '92');
INSERT INTO `stock_data` VALUES ('9', '18', '2009-01-30', '03:20:00', '11.05');
INSERT INTO `stock_data` VALUES ('10', '21', '2009-01-30', '12:06:00', '0.52');
INSERT INTO `stock_data` VALUES ('11', '22', '2009-01-30', '04:00:00', '8.3');
INSERT INTO `stock_data` VALUES ('12', '16', '2009-02-10', '04:01:00', '93.27');
INSERT INTO `stock_data` VALUES ('13', '19', '2009-02-10', '04:01:00', '15.49');
INSERT INTO `stock_data` VALUES ('14', '22', '2009-02-10', '04:00:00', '7.93');
INSERT INTO `stock_data` VALUES ('15', '16', '2009-02-11', '09:54:00', '94.09');
INSERT INTO `stock_data` VALUES ('16', '16', '2009-02-11', '11:35:00', '94.61');
INSERT INTO `stock_data` VALUES ('17', '22', '2009-02-11', '09:52:00', '8.02');
INSERT INTO `stock_data` VALUES ('18', '16', '2009-03-04', '04:00:00', '89.49');
INSERT INTO `stock_data` VALUES ('19', '21', '2009-03-04', '04:00:00', '0.51');
INSERT INTO `stock_data` VALUES ('20', '17', '2009-03-04', '04:04:00', '24.25');
INSERT INTO `stock_data` VALUES ('21', '18', '2009-03-04', '02:39:00', '12.16');
INSERT INTO `stock_data` VALUES ('22', '22', '2009-03-04', '04:00:00', '7.274');
INSERT INTO `stock_data` VALUES ('23', '19', '2009-03-04', '04:00:00', '9.46');
INSERT INTO `stock_data` VALUES ('24', '16', '2009-07-21', '10:12:00', '116.05');
INSERT INTO `stock_data` VALUES ('25', '16', '2009-07-22', '04:01:00', '115.57');
INSERT INTO `stock_data` VALUES ('26', '17', '2009-07-22', '04:02:00', '36.23');
INSERT INTO `stock_data` VALUES ('27', '18', '2009-07-22', '03:21:00', '13.06');
INSERT INTO `stock_data` VALUES ('28', '21', '2009-07-22', '04:00:00', '0.75');
INSERT INTO `stock_data` VALUES ('29', '23', '2008-07-24', '04:00:00', '19.05');
INSERT INTO `stock_data` VALUES ('30', '22', '2009-07-22', '04:00:00', '10.49');
INSERT INTO `stock_data` VALUES ('31', '16', '2009-07-24', '04:00:00', '117.64');
INSERT INTO `stock_data` VALUES ('32', '24', '2009-07-24', '04:00:00', '19.31');
INSERT INTO `stock_data` VALUES ('33', '25', '2009-07-24', '03:41:00', '11.798');
INSERT INTO `stock_data` VALUES ('34', '26', '2008-02-13', '03:00:00', '5.7');
INSERT INTO `stock_data` VALUES ('35', '18', '2009-07-24', '09:30:00', '13.1');
INSERT INTO `stock_data` VALUES ('36', '17', '2009-07-24', '04:03:00', '37.71');
INSERT INTO `stock_data` VALUES ('37', '19', '2009-07-24', '04:00:00', '18.93');
INSERT INTO `stock_data` VALUES ('38', '16', '2009-07-27', '04:00:00', '117.63');
INSERT INTO `stock_data` VALUES ('39', '22', '2009-07-27', '03:37:00', '11.2');
INSERT INTO `stock_data` VALUES ('40', '27', '2009-07-27', '04:00:00', '27.16');
INSERT INTO `stock_data` VALUES ('41', '28', '2009-07-27', '03:06:00', '6.5499');
INSERT INTO `stock_data` VALUES ('42', '16', '2009-07-30', '04:00:00', '117.86');
INSERT INTO `stock_data` VALUES ('43', '25', '2009-07-30', '04:00:00', '13.15');
INSERT INTO `stock_data` VALUES ('44', '28', '2009-07-31', '09:33:00', '6.63');
INSERT INTO `stock_data` VALUES ('45', '24', '2009-08-19', '04:00:00', '20.83');
INSERT INTO `stock_data` VALUES ('46', '25', '2009-08-19', '04:00:00', '14.1');
INSERT INTO `stock_data` VALUES ('47', '22', '2009-08-19', '04:00:00', '10.82');
INSERT INTO `stock_data` VALUES ('48', '27', '2009-08-19', '04:01:00', '27.94');
INSERT INTO `stock_data` VALUES ('49', '28', '2009-08-19', '04:00:00', '5.3077');
INSERT INTO `stock_data` VALUES ('50', '16', '2009-10-09', '04:00:00', '125.93');
INSERT INTO `stock_data` VALUES ('51', '29', '2009-10-09', '11:32:00', '3.3');
INSERT INTO `stock_data` VALUES ('52', '29', '2009-10-19', '03:40:00', '3.406');
INSERT INTO `stock_data` VALUES ('53', '16', '2009-10-20', '04:00:00', '122.82');
INSERT INTO `stock_data` VALUES ('54', '25', '2009-10-20', '04:00:00', '16.65');
INSERT INTO `stock_data` VALUES ('55', '25', '2010-03-08', '04:00:00', '20.26');
INSERT INTO `stock_data` VALUES ('56', '22', '2010-03-08', '04:00:00', '11.5699');
INSERT INTO `stock_data` VALUES ('57', '16', '2010-10-06', '04:00:00', '137.84');
INSERT INTO `stock_data` VALUES ('58', '29', '2010-10-06', '03:14:00', '3.88');
INSERT INTO `stock_data` VALUES ('59', '19', '2010-10-06', '04:00:00', '43.82');
INSERT INTO `stock_data` VALUES ('60', '16', '2010-10-20', '04:01:00', '139.07');
INSERT INTO `stock_data` VALUES ('61', '16', '2010-10-21', '04:00:00', '139.83');
INSERT INTO `stock_data` VALUES ('62', '16', '2010-10-22', '04:00:00', '139.67');
INSERT INTO `stock_data` VALUES ('63', '28', '2010-10-22', '04:02:00', '10.14');
INSERT INTO `stock_data` VALUES ('64', '29', '2010-10-22', '03:39:00', '4.1');
INSERT INTO `stock_data` VALUES ('65', '16', '2010-10-29', '04:00:00', '143.6');
INSERT INTO `stock_data` VALUES ('66', '17', '2010-10-29', '04:01:00', '61.03');
INSERT INTO `stock_data` VALUES ('67', '28', '2010-10-29', '04:01:00', '10.14');
INSERT INTO `stock_data` VALUES ('68', '16', '2011-01-12', '04:00:00', '149.1');
INSERT INTO `stock_data` VALUES ('69', '29', '2011-01-12', '03:41:00', '4.12');
INSERT INTO `stock_data` VALUES ('70', '22', '2011-01-12', '04:00:00', '15.0907');
INSERT INTO `stock_data` VALUES ('71', '21', '2011-01-12', '04:00:00', '2.01');
INSERT INTO `stock_data` VALUES ('72', '17', '2011-01-12', '04:03:00', '61.73');
INSERT INTO `stock_data` VALUES ('73', '23', '2008-07-24', '03:00:00', '19.05');
INSERT INTO `stock_data` VALUES ('74', '24', '2011-01-12', '04:00:00', '34.86');
            var_dump($soap_client_handle->__getTypes());
INSERT INTO `stock_data` VALUES ('75', '16', '2012-01-18', '04:01:00', '181.07');
INSERT INTO `stock_data` VALUES ('82', '25', '2012-01-18', '04:00:00', '24.78');
INSERT INTO `stock_data` VALUES ('87', '39', '2012-01-18', '04:01:00', '18.2');
INSERT INTO `stock_data` VALUES ('88', '28', '2012-01-18', '04:00:00', '8.73');
INSERT INTO `stock_data` VALUES ('89', '43', '2012-01-18', '04:01:00', '25.53');
INSERT INTO `stock_data` VALUES ('90', '44', '2012-01-18', '04:05:00', '7.69');
INSERT INTO `stock_data` VALUES ('91', '45', '2012-01-18', '04:01:00', '1.38');
INSERT INTO `stock_data` VALUES ('92', '46', '2012-01-18', '04:02:00', '15.01');
INSERT INTO `stock_data` VALUES ('93', '24', '2012-01-18', '04:00:00', '39.04');
INSERT INTO `stock_data` VALUES ('94', '47', '2012-01-18', '04:00:00', '16.78');
INSERT INTO `stock_data` VALUES ('95', '28', '2012-01-19', '10:39:00', '8.6164');
INSERT INTO `stock_data` VALUES ('96', '22', '2012-01-19', '04:00:00', '10.83');
INSERT INTO `stock_data` VALUES ('97', '16', '2012-01-19', '04:02:00', '180.52');
INSERT INTO `stock_data` VALUES ('98', '16', '2012-01-25', '05:34:00', '191.73');
INSERT INTO `stock_data` VALUES ('99', '48', '2012-01-26', '10:30:00', '14.61');
INSERT INTO `stock_data` VALUES ('100', '19', '2012-01-26', '10:34:00', '54.96');
INSERT INTO `stock_data` VALUES ('101', '16', '2012-01-26', '10:35:00', '191.76');
INSERT INTO `stock_data` VALUES ('102', '24', '2012-01-26', '10:37:00', '38.9');
INSERT INTO `stock_data` VALUES ('103', '16', '2012-01-26', '12:10:00', '191.68');
INSERT INTO `stock_data` VALUES ('104', '16', '2012-01-26', '12:11:00', '191.67');
INSERT INTO `stock_data` VALUES ('105', '16', '2012-01-26', '12:12:00', '191.68');
INSERT INTO `stock_data` VALUES ('106', '16', '2012-01-26', '12:14:00', '191.58');
INSERT INTO `stock_data` VALUES ('107', '16', '2012-01-26', '12:15:00', '191.55');
INSERT INTO `stock_data` VALUES ('108', '16', '2012-01-26', '12:16:00', '191.35');
INSERT INTO `stock_data` VALUES ('109', '16', '2012-01-26', '03:43:00', '190.87');
INSERT INTO `stock_data` VALUES ('110', '24', '2012-02-16', '04:00:00', '36.96');
INSERT INTO `stock_data` VALUES ('111', '16', '2012-02-16', '04:02:00', '193.02');
INSERT INTO `stock_data` VALUES ('112', '16', '2012-02-17', '04:01:00', '193.42');
INSERT INTO `stock_data` VALUES ('113', '28', '2012-02-17', '04:00:00', '9.69');
INSERT INTO `stock_data` VALUES ('114', '16', '2012-04-26', '09:56:00', '204.84');
INSERT INTO `stock_data` VALUES ('115', '43', '2012-04-26', '10:03:00', '25.7808');
INSERT INTO `stock_data` VALUES ('116', '46', '2012-04-26', '10:03:00', '13.4702');
INSERT INTO `stock_data` VALUES ('117', '24', '2012-04-26', '10:04:00', '37.06');
INSERT INTO `stock_data` VALUES ('118', '47', '2012-04-26', '10:46:00', '16.7');
INSERT INTO `stock_data` VALUES ('119', '39', '2012-04-26', '11:15:00', '15.78');
INSERT INTO `stock_data` VALUES ('120', '48', '2012-04-26', '11:14:00', '14.71');
INSERT INTO `stock_data` VALUES ('121', '27', '2012-04-26', '11:16:00', '55.84');
INSERT INTO `stock_data` VALUES ('122', '28', '2012-04-26', '10:42:00', '10.98');
INSERT INTO `stock_data` VALUES ('123', '25', '2012-04-26', '11:15:00', '25.43');
INSERT INTO `stock_data` VALUES ('124', '18', '2012-04-25', '04:00:00', '15.89');
INSERT INTO `stock_data` VALUES ('125', '21', '2012-04-26', '10:42:00', '2.001');
INSERT INTO `stock_data` VALUES ('126', '16', '2012-04-26', '11:17:00', '204.53');
INSERT INTO `stock_data` VALUES ('127', '19', '2012-04-26', '11:17:00', '61.7001');
INSERT INTO `stock_data` VALUES ('128', '49', '2012-05-21', '04:00:00', '34.03');
INSERT INTO `stock_data` VALUES ('129', '16', '2012-05-21', '04:01:00', '197.76');
INSERT INTO `stock_data` VALUES ('130', '28', '2012-05-21', '04:00:00', '9.61');
INSERT INTO `stock_data` VALUES ('131', '43', '2012-05-21', '04:01:00', '25.86');
INSERT INTO `stock_data` VALUES ('132', '50', '2012-05-17', '04:00:00', '0.25');
INSERT INTO `stock_data` VALUES ('133', '18', '2012-05-18', '03:23:00', '15.8113');
INSERT INTO `stock_data` VALUES ('134', '16', '2012-11-09', '04:00:00', '189.64');
INSERT INTO `stock_data` VALUES ('135', '28', '2012-11-09', '04:02:00', '12.05');
INSERT INTO `stock_data` VALUES ('136', '29', '2012-11-09', '04:00:00', '6.98');
