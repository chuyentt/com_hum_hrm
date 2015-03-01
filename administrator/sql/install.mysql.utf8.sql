CREATE TABLE IF NOT EXISTS `#__humg_hrm_employee` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`lastname` VARCHAR(255)  NOT NULL ,
`firstname` VARCHAR(255)  NOT NULL ,
`fullname` VARCHAR(255)  NOT NULL ,
`gender` VARCHAR(255)  NOT NULL ,
`department_guid` VARCHAR(255)  NOT NULL ,
`birthdate` DATE NOT NULL DEFAULT '0000-00-00',
`idtype_guid` VARCHAR(255)  NOT NULL ,
`idtype_number` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__humg_hrm_position` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`employee_guid` VARCHAR(255)  NOT NULL ,
`positiontype_guid` VARCHAR(255)  NOT NULL ,
`department_guid` VARCHAR(255)  NOT NULL ,
`start` DATE NOT NULL DEFAULT '0000-00-00',
`end` DATE NOT NULL DEFAULT '0000-00-00',
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__humg_hrm_department` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`department_guid` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__humg_hrm_positiontype` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`description` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__humg_hrm_idtype` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`description` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

CREATE TABLE IF NOT EXISTS `#__humg_hrm_contact` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`guid` VARCHAR(255)  NOT NULL ,
`employee_guid` VARCHAR(255)  NOT NULL ,
`info` TEXT NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;
