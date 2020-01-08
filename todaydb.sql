/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100408
 Source Host           : localhost:3306
 Source Schema         : test

 Target Server Type    : MySQL
 Target Server Version : 100408
 File Encoding         : 65001

 Date: 11/11/2019 15:47:48
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for customer
-- ----------------------------
DROP TABLE IF EXISTS `customer`;
CREATE TABLE `customer`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `mobile` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `country_id` int(11) NULL DEFAULT NULL,
  `state_id` int(11) NULL DEFAULT NULL,
  `city_id` int(11) NULL DEFAULT NULL,
  `area_id` int(11) NULL DEFAULT NULL,
  `block_id` int(11) NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `delevry_boy_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `employee_customer`(`delevry_boy_id`) USING BTREE,
  INDEX `user_customer`(`user_id`) USING BTREE,
  INDEX `master_customer_country`(`country_id`) USING BTREE,
  INDEX `master_customer_state`(`state_id`) USING BTREE,
  INDEX `master_customer_city`(`city_id`) USING BTREE,
  INDEX `master_customer_area`(`area_id`) USING BTREE,
  INDEX `master_customer_block`(`block_id`) USING BTREE,
  CONSTRAINT `employee_customer` FOREIGN KEY (`delevry_boy_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_customer_area` FOREIGN KEY (`area_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_customer_block` FOREIGN KEY (`block_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_customer_city` FOREIGN KEY (`city_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_customer_country` FOREIGN KEY (`country_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_customer_state` FOREIGN KEY (`state_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_customer` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customer
-- ----------------------------
INSERT INTO `customer` VALUES (1, 'aa', '0900', '2019-11-11 10:32:35', NULL, 51, 53, 68, 61, 63, 'xyz', 0, 2, 1);

-- ----------------------------
-- Table structure for employee
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee`  (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `mobile` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `supplier_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_employee`(`user_id`) USING BTREE,
  INDEX `supplier_employee`(`supplier_id`) USING BTREE,
  CONSTRAINT `supplier_employee` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_employee` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES (0, 'aa', NULL, NULL, '09000', 'xyz', 'xyz', 1, 3, 1);

-- ----------------------------
-- Table structure for master
-- ----------------------------
DROP TABLE IF EXISTS `master`;
CREATE TABLE `master`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `slug` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `extra` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  `order_num` int(11) NULL DEFAULT NULL,
  `parent` int(11) NULL DEFAULT NULL,
  `table_type` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 75 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master
-- ----------------------------
INSERT INTO `master` VALUES (1, 'table', NULL, NULL, NULL, 1, 1, 0, 0);
INSERT INTO `master` VALUES (2, 'country', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (3, 'state', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (4, 'city', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (5, 'area', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (6, 'block', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (7, 'category', NULL, 'product category', NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (8, 'unit', NULL, 'product unit', NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (9, 'role', NULL, 'user role', NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (10, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (11, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (12, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (13, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (14, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (15, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (16, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (17, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (18, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (19, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (20, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (21, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (22, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (23, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (24, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (25, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (26, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (27, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (28, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (29, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (30, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (31, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (32, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (33, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (34, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (35, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (36, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (37, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (38, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (39, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (40, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (41, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (42, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (43, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (44, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (45, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (46, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (47, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (48, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (49, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (50, 'table', NULL, NULL, NULL, 1, 1, 0, 1);
INSERT INTO `master` VALUES (51, 'pakistan', NULL, NULL, NULL, 1, 1, 0, 2);
INSERT INTO `master` VALUES (53, 'sindh', NULL, NULL, NULL, 1, 1, 51, 3);
INSERT INTO `master` VALUES (54, 'panjab', NULL, NULL, NULL, 1, 2, 51, 3);
INSERT INTO `master` VALUES (56, 'balochistan', NULL, NULL, NULL, 1, 3, 51, 3);
INSERT INTO `master` VALUES (57, 'kpk', NULL, NULL, NULL, 1, 4, 51, 3);
INSERT INTO `master` VALUES (58, 'karachi', NULL, NULL, NULL, 1, 1, 53, 4);
INSERT INTO `master` VALUES (59, 'hyderabad', NULL, NULL, NULL, 1, 2, 53, 4);
INSERT INTO `master` VALUES (60, 'faislabad', NULL, NULL, NULL, 1, 1, 54, 4);
INSERT INTO `master` VALUES (61, 'manzoor colony', NULL, NULL, NULL, 1, 1, 58, 5);
INSERT INTO `master` VALUES (62, 'mehmoodabad', NULL, NULL, NULL, 1, 1, 58, 5);
INSERT INTO `master` VALUES (63, 'sector e', NULL, NULL, NULL, 1, 1, 61, 6);
INSERT INTO `master` VALUES (64, 'can', NULL, NULL, NULL, 1, 1, 0, 7);
INSERT INTO `master` VALUES (65, 'bottle', NULL, NULL, NULL, 1, 2, 0, 7);
INSERT INTO `master` VALUES (66, 'gallon', NULL, NULL, NULL, 1, 3, 0, 7);
INSERT INTO `master` VALUES (67, 'other', NULL, NULL, NULL, 1, 4, 0, 7);
INSERT INTO `master` VALUES (68, 'millilitre', NULL, NULL, NULL, 1, 1, 0, 8);
INSERT INTO `master` VALUES (69, 'litre', NULL, NULL, NULL, 1, 2, 0, 8);
INSERT INTO `master` VALUES (70, 'gallon', NULL, '3.78 liter', NULL, 1, 3, 0, 8);
INSERT INTO `master` VALUES (71, 'admin', NULL, NULL, NULL, 1, 1, 0, 9);
INSERT INTO `master` VALUES (72, 'customer', NULL, NULL, NULL, 1, 2, 0, 9);
INSERT INTO `master` VALUES (73, 'employee', NULL, NULL, NULL, 1, 3, 0, 9);
INSERT INTO `master` VALUES (74, 'supplier', NULL, NULL, NULL, 1, 4, 0, 9);

-- ----------------------------
-- Table structure for master_employee
-- ----------------------------
DROP TABLE IF EXISTS `master_employee`;
CREATE TABLE `master_employee`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `master_id` int(11) NOT NULL,
  `employee_id` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `master_id`(`master_id`) USING BTREE,
  INDEX `master_employee_id`(`employee_id`) USING BTREE,
  CONSTRAINT `master_employee_block` FOREIGN KEY (`master_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employee` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of master_employee
-- ----------------------------
INSERT INTO `master_employee` VALUES (1, 6, 0);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `total_amount` float(11, 0) NULL DEFAULT NULL,
  `dis_amount` float(11, 0) NULL DEFAULT NULL,
  `grand_total` float(11, 0) NULL DEFAULT NULL,
  `customer_id` int(11) NULL DEFAULT NULL,
  `supplier_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `recieved_amount` float(11, 0) NULL DEFAULT NULL,
  `balance` float(11, 0) NULL DEFAULT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_order`(`customer_id`) USING BTREE,
  INDEX `supplier_order`(`supplier_id`) USING BTREE,
  INDEX `user_order`(`user_id`) USING BTREE,
  CONSTRAINT `customer_order` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `supplier_order` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `user_order` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for order_detail
-- ----------------------------
DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE `order_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `product_id` int(11) NULL DEFAULT NULL,
  `price` float(10, 2) NULL DEFAULT NULL,
  `discount` float(11, 0) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `order_id`(`order_id`) USING BTREE,
  INDEX `product_order`(`product_id`) USING BTREE,
  CONSTRAINT `product_order` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `order_order_detail` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `description` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `price` float(10, 2) NULL DEFAULT NULL,
  `category_id` int(11) NULL DEFAULT NULL,
  `supplier_id` int(11) NULL DEFAULT NULL,
  `unit_id` int(11) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `category_id`(`category_id`) USING BTREE,
  INDEX `master_product_unit`(`unit_id`) USING BTREE,
  INDEX `supplier_product`(`supplier_id`) USING BTREE,
  CONSTRAINT `master_product_category` FOREIGN KEY (`category_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `master_product_unit` FOREIGN KEY (`unit_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `supplier_product` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, 'aquafina', NULL, NULL, 'xyz', 80.00, 7, 1, 8, 1);

-- ----------------------------
-- Table structure for supplier
-- ----------------------------
DROP TABLE IF EXISTS `supplier`;
CREATE TABLE `supplier`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `country_id` int(11) NULL DEFAULT NULL,
  `state_id` int(11) NULL DEFAULT NULL,
  `area_id` int(11) NULL DEFAULT NULL,
  `block_id` int(11) NULL DEFAULT NULL,
  `address` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `email` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `user_supplier`(`user_id`) USING BTREE,
  CONSTRAINT `user_supplier` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of supplier
-- ----------------------------
INSERT INTO `supplier` VALUES (1, 'abc', NULL, NULL, NULL, NULL, NULL, NULL, 'malir', '09000', 'xyz', 2, 1);

-- ----------------------------
-- Table structure for transaction
-- ----------------------------
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction`  (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `total_amount` float(11, 0) NULL DEFAULT NULL,
  `dis_amount` float(11, 0) NULL DEFAULT NULL,
  `grand_total` float(11, 0) NULL DEFAULT NULL,
  `customer_id` int(11) NULL DEFAULT NULL,
  `supplier_id` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `recieved_amount` float(11, 0) NULL DEFAULT NULL,
  `balance` float(11, 0) NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `customer_order`(`customer_id`) USING BTREE,
  INDEX `supplier_order`(`supplier_id`) USING BTREE,
  INDEX `user_order`(`user_id`) USING BTREE,
  INDEX `transaction_order`(`order_id`) USING BTREE,
  CONSTRAINT `transaction_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_ibfk_2` FOREIGN KEY (`supplier_id`) REFERENCES `supplier` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `transaction_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for transaction_detail
-- ----------------------------
DROP TABLE IF EXISTS `transaction_detail`;
CREATE TABLE `transaction_detail`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `debit` float(11, 0) NULL DEFAULT NULL,
  `credit` float(10, 2) NULL DEFAULT NULL,
  `account_num` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `type` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `description` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `transaction_transaction_detail`(`transaction_id`) USING BTREE,
  CONSTRAINT `transaction_transaction_detail` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(15) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `created_date` timestamp(0) NULL DEFAULT current_timestamp(0),
  `updated_date` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0),
  `address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `phone` varchar(16) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `role_id` int(11) NULL DEFAULT NULL,
  `email_address` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `status` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  INDEX `master_user`(`role_id`) USING BTREE,
  CONSTRAINT `master_user` FOREIGN KEY (`role_id`) REFERENCES `master` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (1, 'iqra', NULL, NULL, 'manzoor', '333', '123', 71, 'gmail.com', 1);
INSERT INTO `user` VALUES (2, 'shazia', NULL, NULL, 'malir', '4444', '123', 72, 'gmail.com', 1);
INSERT INTO `user` VALUES (3, 'aba', NULL, NULL, 'xyz', '0900', '123', 73, 'gmail.com', 1);
INSERT INTO `user` VALUES (4, 'aca', NULL, NULL, 'xyz', '0900', '123', 74, 'gmail.com', 1);

SET FOREIGN_KEY_CHECKS = 1;
