<?php

function createCarTables(){

global $wpdb

$query['wp_cars_new1']="CREATE TABLE `wp_cars_new1` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `id_cars_mark` int(3) unsigned NOT NULL,
  `id_cars_model` int(3) unsigned NOT NULL,
  `stock_id` varchar(16) NOT NULL,
  `check_pics` tinyint(1) NOT NULL,
  `lot_number` int(5) unsigned NOT NULL,
  `year` int(4) unsigned NOT NULL,
  `mileage` int(4) unsigned NOT NULL,
  `start_price` int(8) unsigned NOT NULL,
  `id_trans` int(2) unsigned NOT NULL,
  `id_auction_hall` int(3) unsigned NOT NULL,
  `transmission` varchar(10) NOT NULL,
  `engine_cc` int(5) unsigned NOT NULL,
  `color` varchar(24) NOT NULL,
  `id_color` int(3) unsigned NOT NULL,
  `date` varchar(24) NOT NULL,
  `auction_time` date DEFAULT NULL,
  `lot_number_and_hall` varchar(255) NOT NULL,
  `model_grade` varchar(24) NOT NULL,
  `chassis_and_accecories` varchar(24) NOT NULL,
  `result` int(9) unsigned NOT NULL,
  `auction_grade` varchar(4) NOT NULL,
  `row_checked` varchar(1) NOT NULL DEFAULT '0',
  `post_to_fb` tinyint(1) NOT NULL,
  `make` varchar(50) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  `pictures_url` varchar(350) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `row_checked` (`row_checked`),
  KEY `id_cars_mark` (`id_cars_mark`),
  KEY `year` (`year`),
  KEY `id_cars_model` (`id_cars_model`),
  KEY `mileage` (`mileage`),
  KEY `start_price` (`start_price`),
  KEY `id_trans` (`id_trans`),
  KEY `transmission` (`transmission`),
  KEY `engine_cc` (`engine_cc`),
  KEY `color` (`color`),
  KEY `auction_hall` (`id_auction_hall`),
  KEY `id_color` (`id_color`),
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$query['wp_cars_mark']="CREATE TABLE `wp_cars_mark` (
  `id` int(3) unsigned NOT NULL AUTO_INCREMENT,
  `mark` varchar(52) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$query['wp_cars_model']="CREATE TABLE `wp_cars_model` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `id_cars_mark` int(3) unsigned NOT NULL,
  `model` varchar(60) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cars_mark` (`id_cars_mark`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";


$query['wp_cars_color']="CREATE TABLE `wp_cars_color` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `car_color` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

$query['wp_cars_auction_hall']="CREATE TABLE `wp_cars_auction_hall` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `auction_hall` varchar(50) NOT NULL,
  `state` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=IinnoDB DEFAULT CHARSET=utf8";


$query['wp_cars_img']="CREATE TABLE `wp_cars_img` (
  `stock_id` varchar(16) NOT NULL,
  `photo_url` varchar(255) NOT NULL,
  KEY `stock_id` (`stock_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8";

foreach ($query as $table=>$qr){

	if ($wpdb->query('DROP TABLE IF EXISTS `'.$table.'`') || $wpdb->query($qr)) {
		echo " err Table creation `".$table."` failed: (" .$wpdb->errno. ") " . $wpdb->error;
               	die();
	}
}
}

