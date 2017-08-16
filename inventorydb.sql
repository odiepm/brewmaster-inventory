-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2017 at 04:02 AM
-- Server version: 10.1.19-MariaDB
-- PHP Version: 5.6.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventorydb`
--

-- --------------------------------------------------------

--
-- Table structure for table `bs_activity_log`
--

CREATE TABLE `bs_activity_log` (
  `activity_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_activity_log`
--

INSERT INTO `bs_activity_log` (`activity_id`, `description`, `date`) VALUES
(1, 'Adminbs made a withdrawal with salesman: Michael Jordan', '2017-03-22 08:56:47am'),
(2, 'Adminbs made a withdrawal with salesman: Kendrick Lamar', '2017-03-22 09:48:43am');

-- --------------------------------------------------------

--
-- Table structure for table `bs_cart`
--

CREATE TABLE `bs_cart` (
  `product_id` int(11) NOT NULL,
  `cartProdname` varchar(255) NOT NULL,
  `cartProdcode` varchar(255) NOT NULL,
  `cartProdempty` tinyint(1) NOT NULL,
  `cartProdcat` int(11) NOT NULL,
  `cartProdesc` varchar(255) NOT NULL,
  `cartUnitper` int(11) NOT NULL,
  `cartProdsell` double NOT NULL,
  `cartProdexp` varchar(255) NOT NULL,
  `quantityCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bs_customer`
--

CREATE TABLE `bs_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_info_id` int(11) NOT NULL,
  `customer_distribution_id` int(11) NOT NULL,
  `customer_sws_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_product_id` int(11) NOT NULL,
  `customer_case_id` int(11) NOT NULL,
  `customer_product_name` varchar(255) NOT NULL,
  `customer_product_des` varchar(255) NOT NULL,
  `customer_product_code` varchar(255) NOT NULL,
  `customer_product_exp` varchar(255) NOT NULL,
  `customer_product_qty` int(11) NOT NULL,
  `customer_isEmpty` int(11) NOT NULL,
  `customer_empty_qty` int(11) NOT NULL,
  `customer_product_price` double NOT NULL,
  `customer_salesman_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_customer`
--

INSERT INTO `bs_customer` (`customer_id`, `customer_info_id`, `customer_distribution_id`, `customer_sws_id`, `customer_name`, `customer_address`, `customer_contact`, `customer_product_id`, `customer_case_id`, `customer_product_name`, `customer_product_des`, `customer_product_code`, `customer_product_exp`, `customer_product_qty`, `customer_isEmpty`, `customer_empty_qty`, `customer_product_price`, `customer_salesman_id`) VALUES
(1, 1, 1, 1, 'Abel Store', 'West Fairview, Q.C', '09152719909', 1, 0, 'Absolute', '350mL', 'ABS0001', '2020-01-01', 4, 0, 0, 756, 11),
(2, 1, 1, 1, 'Abel Store', 'West Fairview, Q.C', '09152719909', 2, 0, 'Absolute', '500mL', 'ABS0002', '2017-06-01', 10, 0, 0, 840, 11),
(3, 1, 1, 1, 'Abel Store', 'West Fairview, Q.C', '09152719909', 3, 0, 'Cobra Red', '450mL', 'COB0003', '2021-01-01', 5, 1, 14, 940.8, 11),
(4, 1, 1, 1, 'Abel Store', 'West Fairview, Q.C', '09152719909', 4, 0, 'Cobra Blue', '450mL', 'COB0004', '2021-02-03', 10, 1, 25, 840, 11),
(5, 1, 1, 1, 'Abel Store', 'West Fairview, Q.C', '09152719909', 5, 0, 'Red Horse', '500mL', 'RED0005', '2030-01-01', 10, 1, 36, 1008, 11),
(6, 3, 2, 1, 'Geraldo Store', 'Sampaguita St., Q.C', '0195723463', 1, 0, 'Absolute', '350mL', 'ABS0001', '2020-01-01', 6, 0, 0, 756, 11),
(7, 3, 2, 1, 'Geraldo Store', 'Sampaguita St., Q.C', '0195723463', 2, 0, 'Absolute', '500mL', 'ABS0002', '2017-06-01', 10, 0, 0, 840, 11),
(8, 3, 2, 1, 'Geraldo Store', 'Sampaguita St., Q.C', '0195723463', 3, 0, 'Cobra Red', '450mL', 'COB0003', '2021-01-01', 5, 1, 10, 940.8, 11),
(9, 3, 2, 1, 'Geraldo Store', 'Sampaguita St., Q.C', '0195723463', 4, 0, 'Cobra Blue', '450mL', 'COB0004', '2021-02-03', 5, 1, 20, 840, 11),
(10, 3, 2, 1, 'Geraldo Store', 'Sampaguita St., Q.C', '0195723463', 5, 0, 'Red Horse', '500mL', 'RED0005', '2030-01-01', 5, 1, 30, 1008, 11);

-- --------------------------------------------------------

--
-- Table structure for table `bs_customer_info`
--

CREATE TABLE `bs_customer_info` (
  `customer_info_id` int(11) NOT NULL,
  `customer_info_name` varchar(255) NOT NULL,
  `customer_info_number` varchar(255) NOT NULL,
  `customer_info_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_customer_info`
--

INSERT INTO `bs_customer_info` (`customer_info_id`, `customer_info_name`, `customer_info_number`, `customer_info_address`) VALUES
(1, 'Abel Store', '09152719909', 'West Fairview, Q.C'),
(2, 'John Store', '0997466221', 'Regalado Hwy, Q.C'),
(3, 'Geraldo Store', '0195723463', 'Sampaguita St., Q.C'),
(4, 'Shen Store', '091572392111', 'Batasan Hills, Q.C');

-- --------------------------------------------------------

--
-- Table structure for table `bs_forecast`
--

CREATE TABLE `bs_forecast` (
  `forecast_id` int(11) NOT NULL,
  `forecast_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bs_orders`
--

CREATE TABLE `bs_orders` (
  `order_id` int(11) NOT NULL,
  `order_num` int(255) NOT NULL,
  `Salesman` varchar(255) NOT NULL,
  `salesman_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_orders`
--

INSERT INTO `bs_orders` (`order_id`, `order_num`, `Salesman`, `salesman_name`, `date`, `status`) VALUES
(1, 1, '11', 'Michael Jordan', '03/22/2017', 'Completed'),
(2, 2, '6', 'Kendrick Lamar', '03/22/2017', 'Out for Delivery');

-- --------------------------------------------------------

--
-- Table structure for table `bs_products`
--

CREATE TABLE `bs_products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_branch` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_per` int(11) NOT NULL DEFAULT '0',
  `markup_percent` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `sell_price` double NOT NULL,
  `supplier_price` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `isEmpty` tinyint(1) NOT NULL,
  `empties` int(11) NOT NULL DEFAULT '0',
  `damages` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_products`
--

INSERT INTO `bs_products` (`product_id`, `product_code`, `product_branch`, `product_name`, `description`, `unit_per`, `markup_percent`, `quantity`, `sell_price`, `supplier_price`, `category_id`, `expiry_date`, `date`, `isEmpty`, `empties`, `damages`) VALUES
(1, 'ABS0001', 'BS', 'Absolute', '350mL', 24, 50, 9800, 756, 450, 1, '2020-01-01', '2017-03-21', 0, 0, 1),
(2, 'ABS0002', 'BS', 'Absolute', '500mL', 12, 50, 9800, 840, 500, 1, '2017-06-01', '2017-03-21', 0, 0, 2),
(3, 'COB0003', 'BS', 'Cobra Red', '450mL', 12, 50, 9800, 940.8, 560, 4, '2021-01-01', '2017-03-21', 1, 52, 8),
(4, 'COB0004', 'BS', 'Cobra Blue', '450mL', 24, 50, 9800, 840, 500, 4, '2021-02-03', '2017-03-21', 1, 136, 14),
(5, 'RED0005', 'BS', 'Red Horse', '500mL', 12, 50, 9800, 1008, 600, 2, '2030-01-01', '2017-03-21', 1, 166, 17);

-- --------------------------------------------------------

--
-- Table structure for table `bs_reports`
--

CREATE TABLE `bs_reports` (
  `report_id` int(11) NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `report_supplier` varchar(255) NOT NULL,
  `report_description` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `report_expiry` varchar(255) NOT NULL,
  `report_product` varchar(255) NOT NULL,
  `report_quantity` int(11) NOT NULL,
  `report_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bs_settings`
--

CREATE TABLE `bs_settings` (
  `settings_id` int(11) NOT NULL,
  `vat_percent` double NOT NULL,
  `sellprice_percent` double NOT NULL DEFAULT '0',
  `markup_percentage` int(11) NOT NULL,
  `markUpIsCheck` int(11) NOT NULL,
  `target_sales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_settings`
--

INSERT INTO `bs_settings` (`settings_id`, `vat_percent`, `sellprice_percent`, `markup_percentage`, `markUpIsCheck`, `target_sales`) VALUES
(1, 12, 15, 50, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `bs_supplier`
--

CREATE TABLE `bs_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_city` varchar(255) NOT NULL,
  `supplier_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bs_sws`
--

CREATE TABLE `bs_sws` (
  `sws_id` int(11) NOT NULL,
  `sws_number` int(255) NOT NULL,
  `sws_procode` varchar(255) NOT NULL,
  `sws_proname` varchar(255) NOT NULL,
  `sws_isEmpty` tinyint(1) NOT NULL,
  `sws_category` int(11) NOT NULL,
  `sws_unitprice` double NOT NULL,
  `sws_prodesc` varchar(255) NOT NULL,
  `sws_unit_per` int(11) NOT NULL,
  `sws_proexp` varchar(255) NOT NULL,
  `sws_vat` tinyint(1) NOT NULL,
  `date` varchar(255) NOT NULL,
  `sws_salesman` varchar(255) NOT NULL,
  `sws_route` varchar(255) NOT NULL,
  `sws_smname` varchar(255) NOT NULL,
  `sws_driver` varchar(255) NOT NULL,
  `sws_plate` varchar(255) NOT NULL,
  `sws_vehicle` varchar(255) NOT NULL,
  `sws_load` int(255) NOT NULL,
  `sws_productid` int(255) NOT NULL,
  `sws_quantity` int(255) NOT NULL,
  `sws_true_quantity` int(11) NOT NULL,
  `sws_branch` varchar(255) NOT NULL DEFAULT 'BS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_sws`
--

INSERT INTO `bs_sws` (`sws_id`, `sws_number`, `sws_procode`, `sws_proname`, `sws_isEmpty`, `sws_category`, `sws_unitprice`, `sws_prodesc`, `sws_unit_per`, `sws_proexp`, `sws_vat`, `date`, `sws_salesman`, `sws_route`, `sws_smname`, `sws_driver`, `sws_plate`, `sws_vehicle`, `sws_load`, `sws_productid`, `sws_quantity`, `sws_true_quantity`, `sws_branch`) VALUES
(1, 1, 'ABS0001', 'Absolute', 0, 1, 756, '350mL', 24, '2020-01-01', 0, '03/22/2017', '11', '1', 'Michael Jordan', 'Jolo Calinap', 'UUI 4451', '3', 1, 1, 90, 80, 'BS'),
(2, 1, 'ABS0002', 'Absolute', 0, 1, 840, '500mL', 12, '2017-06-01', 0, '03/22/2017', '11', '1', 'Michael Jordan', 'Jolo Calinap', 'UUI 4451', '3', 1, 2, 80, 60, 'BS'),
(3, 1, 'COB0003', 'Cobra Red', 1, 4, 940.8, '450mL', 12, '2021-01-01', 0, '03/22/2017', '11', '1', 'Michael Jordan', 'Jolo Calinap', 'UUI 4451', '3', 1, 3, 70, 60, 'BS'),
(4, 1, 'COB0004', 'Cobra Blue', 1, 4, 840, '450mL', 24, '2021-02-03', 0, '03/22/2017', '11', '1', 'Michael Jordan', 'Jolo Calinap', 'UUI 4451', '3', 1, 4, 60, 45, 'BS'),
(5, 1, 'RED0005', 'Red Horse', 1, 2, 1008, '500mL', 12, '2030-01-01', 0, '03/22/2017', '11', '1', 'Michael Jordan', 'Jolo Calinap', 'UUI 4451', '3', 1, 5, 50, 35, 'BS'),
(8, 2, 'ABS0001', 'Absolute', 0, 1, 756, '350mL', 24, '2020-01-01', 0, '03/22/2017', '6', '1', 'Kendrick Lamar', 'Ian Adajar', 'EWX 4511', '2', 1, 1, 80, 80, 'BS'),
(9, 2, 'ABS0002', 'Absolute', 0, 1, 840, '500mL', 12, '2017-06-01', 0, '03/22/2017', '6', '1', 'Kendrick Lamar', 'Ian Adajar', 'EWX 4511', '2', 1, 2, 60, 60, 'BS'),
(10, 2, 'COB0003', 'Cobra Red', 1, 4, 940.8, '450mL', 12, '2021-01-01', 0, '03/22/2017', '6', '1', 'Kendrick Lamar', 'Ian Adajar', 'EWX 4511', '2', 1, 3, 60, 60, 'BS'),
(11, 2, 'COB0004', 'Cobra Blue', 1, 4, 840, '450mL', 24, '2021-02-03', 0, '03/22/2017', '6', '1', 'Kendrick Lamar', 'Ian Adajar', 'EWX 4511', '2', 1, 4, 45, 45, 'BS'),
(12, 2, 'RED0005', 'Red Horse', 1, 2, 1008, '500mL', 12, '2030-01-01', 0, '03/22/2017', '6', '1', 'Kendrick Lamar', 'Ian Adajar', 'EWX 4511', '2', 1, 5, 35, 35, 'BS');

-- --------------------------------------------------------

--
-- Table structure for table `bs_vehicles`
--

CREATE TABLE `bs_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_lastname` varchar(255) NOT NULL,
  `vehicle_firstname` varchar(255) NOT NULL,
  `vehicle_plateno` varchar(255) NOT NULL,
  `vehicle_isUsed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bs_vehicles`
--

INSERT INTO `bs_vehicles` (`vehicle_id`, `vehicle_lastname`, `vehicle_firstname`, `vehicle_plateno`, `vehicle_isUsed`) VALUES
(1, 'Christian', 'Dale', 'GGG 2445', 0),
(2, 'Adajar', 'Ian', 'EWX 4511', 0),
(3, 'Calinap', 'Jolo', 'UUI 4451', 0),
(4, 'Cantuba', 'Vember', 'PPL 1177', 0);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(1, 'Water'),
(2, 'Alcohol'),
(3, 'Softdrinks'),
(4, 'Energy Drinks'),
(6, 'Juice Drink'),
(8, 'Coffee & Tea');

-- --------------------------------------------------------

--
-- Table structure for table `fv_activity_log`
--

CREATE TABLE `fv_activity_log` (
  `activity_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_cart`
--

CREATE TABLE `fv_cart` (
  `product_id` int(11) NOT NULL,
  `cartProdname` varchar(255) NOT NULL,
  `cartProdcode` varchar(255) NOT NULL,
  `cartProdempty` tinyint(1) NOT NULL,
  `cartProdcat` int(11) NOT NULL,
  `cartProdesc` varchar(255) NOT NULL,
  `cartUnitper` int(11) NOT NULL,
  `cartProdsell` double NOT NULL,
  `cartProdexp` varchar(255) NOT NULL,
  `quantityCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_customer`
--

CREATE TABLE `fv_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_info_id` int(11) NOT NULL,
  `customer_distribution_id` int(11) NOT NULL,
  `customer_sws_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_product_id` int(11) NOT NULL,
  `customer_case_id` int(11) NOT NULL,
  `customer_product_name` varchar(255) NOT NULL,
  `customer_product_des` varchar(255) NOT NULL,
  `customer_product_code` varchar(255) NOT NULL,
  `customer_product_exp` varchar(255) NOT NULL,
  `customer_product_qty` int(11) NOT NULL,
  `customer_isEmpty` int(11) NOT NULL,
  `customer_empty_qty` int(11) NOT NULL,
  `customer_product_price` double NOT NULL,
  `customer_salesman_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_customer_info`
--

CREATE TABLE `fv_customer_info` (
  `customer_info_id` int(11) NOT NULL,
  `customer_info_name` varchar(255) NOT NULL,
  `customer_info_number` varchar(255) NOT NULL,
  `customer_info_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_forecast`
--

CREATE TABLE `fv_forecast` (
  `forecast_id` int(11) NOT NULL,
  `forecast_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_orders`
--

CREATE TABLE `fv_orders` (
  `order_id` int(11) NOT NULL,
  `order_num` int(255) NOT NULL,
  `Salesman` varchar(255) NOT NULL,
  `salesman_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_products`
--

CREATE TABLE `fv_products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_branch` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_per` int(11) NOT NULL DEFAULT '0',
  `markup_percent` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `sell_price` double NOT NULL,
  `supplier_price` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `isEmpty` tinyint(1) NOT NULL,
  `empties` int(11) NOT NULL DEFAULT '0',
  `damages` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_reports`
--

CREATE TABLE `fv_reports` (
  `report_id` int(11) NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `report_supplier` varchar(255) NOT NULL,
  `report_description` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `report_expiry` varchar(255) NOT NULL,
  `report_product` varchar(255) NOT NULL,
  `report_quantity` int(11) NOT NULL,
  `report_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_settings`
--

CREATE TABLE `fv_settings` (
  `settings_id` int(11) NOT NULL,
  `vat_percent` double NOT NULL,
  `sellprice_percent` double NOT NULL DEFAULT '0',
  `markup_percentage` int(11) NOT NULL,
  `markUpIsCheck` int(11) NOT NULL,
  `target_sales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fv_settings`
--

INSERT INTO `fv_settings` (`settings_id`, `vat_percent`, `sellprice_percent`, `markup_percentage`, `markUpIsCheck`, `target_sales`) VALUES
(1, 12, 15, 50, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `fv_supplier`
--

CREATE TABLE `fv_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_city` varchar(255) NOT NULL,
  `supplier_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_sws`
--

CREATE TABLE `fv_sws` (
  `sws_id` int(11) NOT NULL,
  `sws_procode` varchar(255) NOT NULL,
  `sws_proname` varchar(255) NOT NULL,
  `sws_isEmpty` tinyint(1) NOT NULL,
  `sws_category` int(11) NOT NULL,
  `sws_unitprice` double NOT NULL,
  `sws_prodesc` varchar(255) NOT NULL,
  `sws_unit_per` int(11) NOT NULL,
  `sws_proexp` varchar(255) NOT NULL,
  `sws_vat` tinyint(1) NOT NULL,
  `sws_number` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `sws_salesman` varchar(255) NOT NULL,
  `sws_route` varchar(255) NOT NULL,
  `sws_smname` varchar(255) NOT NULL,
  `sws_driver` varchar(255) NOT NULL,
  `sws_plate` varchar(255) NOT NULL,
  `sws_vehicle` varchar(255) NOT NULL,
  `sws_load` int(255) NOT NULL,
  `sws_productid` int(255) NOT NULL,
  `sws_quantity` int(255) NOT NULL,
  `sws_true_quantity` int(11) NOT NULL,
  `sws_branch` varchar(255) NOT NULL DEFAULT 'BS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `fv_vehicles`
--

CREATE TABLE `fv_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_lastname` varchar(255) NOT NULL,
  `vehicle_firstname` varchar(255) NOT NULL,
  `vehicle_plateno` varchar(255) NOT NULL,
  `vehicle_isUsed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `stock_transfer`
--

CREATE TABLE `stock_transfer` (
  `transfer_id` int(11) NOT NULL,
  `transfer_number` int(11) NOT NULL,
  `transfer_status` varchar(255) NOT NULL,
  `transfer_frombranch` varchar(255) NOT NULL,
  `transfer_product_id` int(11) NOT NULL,
  `transfer_product_code` varchar(255) NOT NULL,
  `st_unit_per` int(11) NOT NULL,
  `transfer_quantity` int(11) NOT NULL,
  `stocks_transferred` int(11) NOT NULL,
  `transfer_tobranch` varchar(255) NOT NULL,
  `transfer_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_activity_log`
--

CREATE TABLE `td_activity_log` (
  `activity_id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_cart`
--

CREATE TABLE `td_cart` (
  `product_id` int(11) NOT NULL,
  `cartProdname` varchar(255) NOT NULL,
  `cartProdcode` varchar(255) NOT NULL,
  `cartProdempty` tinyint(1) NOT NULL,
  `cartProdcat` int(11) NOT NULL,
  `cartProdesc` varchar(255) NOT NULL,
  `cartUnitper` int(11) NOT NULL,
  `cartProdsell` double NOT NULL,
  `cartProdexp` varchar(255) NOT NULL,
  `quantityCart` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_customer`
--

CREATE TABLE `td_customer` (
  `customer_id` int(11) NOT NULL,
  `customer_info_id` int(11) NOT NULL,
  `customer_distribution_id` int(11) NOT NULL,
  `customer_sws_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` varchar(255) NOT NULL,
  `customer_contact` varchar(255) NOT NULL,
  `customer_product_id` int(11) NOT NULL,
  `customer_case_id` int(11) NOT NULL,
  `customer_product_name` varchar(255) NOT NULL,
  `customer_product_des` varchar(255) NOT NULL,
  `customer_product_code` varchar(255) NOT NULL,
  `customer_product_exp` varchar(255) NOT NULL,
  `customer_product_qty` int(11) NOT NULL,
  `customer_isEmpty` int(11) NOT NULL,
  `customer_empty_qty` int(11) NOT NULL,
  `customer_product_price` double NOT NULL,
  `customer_salesman_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_customer_info`
--

CREATE TABLE `td_customer_info` (
  `customer_info_id` int(11) NOT NULL,
  `customer_info_name` varchar(255) NOT NULL,
  `customer_info_number` varchar(255) NOT NULL,
  `customer_info_address` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_forecast`
--

CREATE TABLE `td_forecast` (
  `forecast_id` int(11) NOT NULL,
  `forecast_percentage` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_orders`
--

CREATE TABLE `td_orders` (
  `order_id` int(11) NOT NULL,
  `order_num` int(255) NOT NULL,
  `Salesman` varchar(255) NOT NULL,
  `salesman_name` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_products`
--

CREATE TABLE `td_products` (
  `product_id` int(11) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `product_branch` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `unit_per` int(11) NOT NULL DEFAULT '0',
  `markup_percent` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `sell_price` double NOT NULL,
  `supplier_price` double NOT NULL,
  `category_id` int(11) NOT NULL,
  `expiry_date` varchar(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `isEmpty` tinyint(1) NOT NULL,
  `empties` int(11) NOT NULL DEFAULT '0',
  `damages` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_reports`
--

CREATE TABLE `td_reports` (
  `report_id` int(11) NOT NULL,
  `report_type` varchar(255) NOT NULL,
  `report_supplier` varchar(255) NOT NULL,
  `report_description` varchar(255) NOT NULL,
  `product_code` varchar(255) NOT NULL,
  `report_expiry` varchar(255) NOT NULL,
  `report_product` varchar(255) NOT NULL,
  `report_quantity` int(11) NOT NULL,
  `report_date` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_settings`
--

CREATE TABLE `td_settings` (
  `settings_id` int(11) NOT NULL,
  `vat_percent` double NOT NULL,
  `sellprice_percent` double NOT NULL DEFAULT '0',
  `markup_percentage` int(11) NOT NULL,
  `markUpIsCheck` int(11) NOT NULL,
  `target_sales` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `td_settings`
--

INSERT INTO `td_settings` (`settings_id`, `vat_percent`, `sellprice_percent`, `markup_percentage`, `markUpIsCheck`, `target_sales`) VALUES
(1, 12, 15, 50, 1, 50);

-- --------------------------------------------------------

--
-- Table structure for table `td_supplier`
--

CREATE TABLE `td_supplier` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_address` varchar(255) NOT NULL,
  `supplier_city` varchar(255) NOT NULL,
  `supplier_contact` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_sws`
--

CREATE TABLE `td_sws` (
  `sws_id` int(11) NOT NULL,
  `sws_procode` varchar(255) NOT NULL,
  `sws_proname` varchar(255) NOT NULL,
  `sws_isEmpty` tinyint(1) NOT NULL,
  `sws_category` int(11) NOT NULL,
  `sws_unitprice` double NOT NULL,
  `sws_prodesc` varchar(255) NOT NULL,
  `sws_unit_per` int(11) NOT NULL,
  `sws_proexp` varchar(255) NOT NULL,
  `sws_vat` tinyint(1) NOT NULL,
  `sws_number` int(255) NOT NULL,
  `date` varchar(255) NOT NULL,
  `sws_salesman` varchar(255) NOT NULL,
  `sws_route` varchar(255) NOT NULL,
  `sws_smname` varchar(255) NOT NULL,
  `sws_driver` varchar(255) NOT NULL,
  `sws_plate` varchar(255) NOT NULL,
  `sws_vehicle` varchar(255) NOT NULL,
  `sws_load` int(255) NOT NULL,
  `sws_productid` int(255) NOT NULL,
  `sws_quantity` int(255) NOT NULL,
  `sws_true_quantity` int(11) NOT NULL,
  `sws_branch` varchar(255) NOT NULL DEFAULT 'BS'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `td_vehicles`
--

CREATE TABLE `td_vehicles` (
  `vehicle_id` int(11) NOT NULL,
  `vehicle_lastname` varchar(255) NOT NULL,
  `vehicle_firstname` varchar(255) NOT NULL,
  `vehicle_plateno` varchar(255) NOT NULL,
  `vehicle_isUsed` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `branch` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `user_role` varchar(255) NOT NULL,
  `isLogged` tinyint(1) NOT NULL,
  `isUserManagement` int(11) NOT NULL,
  `isProductManagement` int(11) NOT NULL,
  `isStockManagement` int(11) NOT NULL,
  `isSalesmanWithdrawal` int(11) NOT NULL,
  `isOrderManagement` int(11) NOT NULL,
  `isReports` int(11) NOT NULL,
  `isSettings` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `branch`, `firstname`, `lastname`, `email`, `contact`, `username`, `password`, `user_role`, `isLogged`, `isUserManagement`, `isProductManagement`, `isStockManagement`, `isSalesmanWithdrawal`, `isOrderManagement`, `isReports`, `isSettings`) VALUES
(1, 'BS', 'admin', 'admin', 'admin@yahoo.com', '09152719909', 'adminbs', 'adminbs', 'Admin', 0, 0, 0, 0, 0, 0, 0, 0),
(2, 'TD', 'admin', 'admin', 'admin@yahoo.com', '09152871990', 'admintd', 'admintd', 'Admin', 0, 0, 0, 0, 0, 0, 0, 0),
(3, 'FV', 'admin', 'admin', 'admin@yahoo.com', '09152719909', 'adminfv', 'adminfv', 'Admin', 0, 0, 0, 0, 0, 0, 0, 0),
(4, 'BS', 'Lebron', 'James', 'salesmanbs@gmail.com', '09157219909', 'salesmanbs', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(5, 'BS', 'Carl', 'Dizon', 'carl@yahoo.com', '09157293123', 'carldizon', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(6, 'BS', 'Kendrick', 'Lamar', 'ken@yahoo.com', '09157829312', 'kendricklamar', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(7, 'FV', 'Dwayne', 'Wade', 'dwade@yahoo.com', '09123456789', 'dwade03', '12345', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(8, 'FV', 'Derick', 'Rose', 'drose@yahoo.com', '09055789546', 'drose', '12345', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(9, 'FV', 'Arwin', 'Santos', 'asantos@yahoo.com', '09451758565', 'asantos', '12345', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(10, 'FV', 'Teddy', 'Bear', 'tbear@yahoo.com', '094532188567', 'tbear', '12345', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(11, 'BS', 'Michael', 'Jordan', 'mic@yahoo.com', '09123741232', 'micjordan', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(12, 'BS', 'Joshua', 'Fontiveros', 'joshfonts@yahoo.com', '09152719909', 'joshfonts', 'joshfonts', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(13, 'BS', 'David', 'Blaine', 'blainebs@yahoo.com', '09148232321', 'blainebs', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(14, 'BS', 'Ian', 'Adajar', 'ianadajar@yahoo.com', '09158232112', 'ianadajar', 'ianadajar', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0),
(15, 'TD', 'jocelyn', 'fajardo', 'j@yahoo.com', '091237231', 'jfajardo', '123456', 'Salesman', 0, 0, 1, 0, 1, 0, 1, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bs_activity_log`
--
ALTER TABLE `bs_activity_log`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `bs_cart`
--
ALTER TABLE `bs_cart`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `bs_customer`
--
ALTER TABLE `bs_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `bs_customer_info`
--
ALTER TABLE `bs_customer_info`
  ADD PRIMARY KEY (`customer_info_id`);

--
-- Indexes for table `bs_forecast`
--
ALTER TABLE `bs_forecast`
  ADD PRIMARY KEY (`forecast_id`);

--
-- Indexes for table `bs_orders`
--
ALTER TABLE `bs_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `bs_products`
--
ALTER TABLE `bs_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `bs_reports`
--
ALTER TABLE `bs_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `bs_settings`
--
ALTER TABLE `bs_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `bs_supplier`
--
ALTER TABLE `bs_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `bs_sws`
--
ALTER TABLE `bs_sws`
  ADD PRIMARY KEY (`sws_id`);

--
-- Indexes for table `bs_vehicles`
--
ALTER TABLE `bs_vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fv_activity_log`
--
ALTER TABLE `fv_activity_log`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `fv_cart`
--
ALTER TABLE `fv_cart`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `fv_customer`
--
ALTER TABLE `fv_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `fv_customer_info`
--
ALTER TABLE `fv_customer_info`
  ADD PRIMARY KEY (`customer_info_id`);

--
-- Indexes for table `fv_forecast`
--
ALTER TABLE `fv_forecast`
  ADD PRIMARY KEY (`forecast_id`);

--
-- Indexes for table `fv_orders`
--
ALTER TABLE `fv_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `fv_products`
--
ALTER TABLE `fv_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `fv_reports`
--
ALTER TABLE `fv_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `fv_settings`
--
ALTER TABLE `fv_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `fv_supplier`
--
ALTER TABLE `fv_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `fv_sws`
--
ALTER TABLE `fv_sws`
  ADD PRIMARY KEY (`sws_id`);

--
-- Indexes for table `fv_vehicles`
--
ALTER TABLE `fv_vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  ADD PRIMARY KEY (`transfer_id`);

--
-- Indexes for table `td_activity_log`
--
ALTER TABLE `td_activity_log`
  ADD PRIMARY KEY (`activity_id`);

--
-- Indexes for table `td_cart`
--
ALTER TABLE `td_cart`
  ADD UNIQUE KEY `product_id` (`product_id`);

--
-- Indexes for table `td_customer`
--
ALTER TABLE `td_customer`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `td_customer_info`
--
ALTER TABLE `td_customer_info`
  ADD PRIMARY KEY (`customer_info_id`);

--
-- Indexes for table `td_forecast`
--
ALTER TABLE `td_forecast`
  ADD PRIMARY KEY (`forecast_id`);

--
-- Indexes for table `td_orders`
--
ALTER TABLE `td_orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `td_products`
--
ALTER TABLE `td_products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `td_reports`
--
ALTER TABLE `td_reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Indexes for table `td_settings`
--
ALTER TABLE `td_settings`
  ADD PRIMARY KEY (`settings_id`);

--
-- Indexes for table `td_supplier`
--
ALTER TABLE `td_supplier`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `td_sws`
--
ALTER TABLE `td_sws`
  ADD PRIMARY KEY (`sws_id`);

--
-- Indexes for table `td_vehicles`
--
ALTER TABLE `td_vehicles`
  ADD PRIMARY KEY (`vehicle_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bs_activity_log`
--
ALTER TABLE `bs_activity_log`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_customer`
--
ALTER TABLE `bs_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `bs_customer_info`
--
ALTER TABLE `bs_customer_info`
  MODIFY `customer_info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `bs_forecast`
--
ALTER TABLE `bs_forecast`
  MODIFY `forecast_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bs_orders`
--
ALTER TABLE `bs_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `bs_products`
--
ALTER TABLE `bs_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `bs_reports`
--
ALTER TABLE `bs_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bs_settings`
--
ALTER TABLE `bs_settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `bs_supplier`
--
ALTER TABLE `bs_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `bs_sws`
--
ALTER TABLE `bs_sws`
  MODIFY `sws_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `bs_vehicles`
--
ALTER TABLE `bs_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `fv_activity_log`
--
ALTER TABLE `fv_activity_log`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_customer`
--
ALTER TABLE `fv_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_customer_info`
--
ALTER TABLE `fv_customer_info`
  MODIFY `customer_info_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_forecast`
--
ALTER TABLE `fv_forecast`
  MODIFY `forecast_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_orders`
--
ALTER TABLE `fv_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_products`
--
ALTER TABLE `fv_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_reports`
--
ALTER TABLE `fv_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_settings`
--
ALTER TABLE `fv_settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `fv_supplier`
--
ALTER TABLE `fv_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_sws`
--
ALTER TABLE `fv_sws`
  MODIFY `sws_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `fv_vehicles`
--
ALTER TABLE `fv_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `stock_transfer`
--
ALTER TABLE `stock_transfer`
  MODIFY `transfer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_activity_log`
--
ALTER TABLE `td_activity_log`
  MODIFY `activity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_customer`
--
ALTER TABLE `td_customer`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_customer_info`
--
ALTER TABLE `td_customer_info`
  MODIFY `customer_info_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_forecast`
--
ALTER TABLE `td_forecast`
  MODIFY `forecast_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_orders`
--
ALTER TABLE `td_orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_products`
--
ALTER TABLE `td_products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_reports`
--
ALTER TABLE `td_reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_settings`
--
ALTER TABLE `td_settings`
  MODIFY `settings_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `td_supplier`
--
ALTER TABLE `td_supplier`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_sws`
--
ALTER TABLE `td_sws`
  MODIFY `sws_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `td_vehicles`
--
ALTER TABLE `td_vehicles`
  MODIFY `vehicle_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
