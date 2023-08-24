-- drop database scoob;
create database scoob;
use scoob;

CREATE TABLE `systemadmins` (
  `email` varchar(50) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `systemadmins` VALUES ('joe@scoob','joe123'),('lawson@scoob','lawson123'), ('arshad@scoob','arshad123'), ('yx@scoob','yx123'), ('jaron@scoob','jaron123'),('uow@scoob','uow123');


CREATE TABLE `transports` (
  `appid` int NOT NULL AUTO_INCREMENT,
  `status` varchar(10) DEFAULT 'Pending',
  `name` varchar(50) DEFAULT NULL,
  `uen` int DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `timestamp` varchar(30) DEFAULT NULL,
  `actiontimestamp` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`appid`),
  UNIQUE KEY `uen` (`uen`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `schools` (
  `appid` int NOT NULL AUTO_INCREMENT,
  `status` varchar(10) DEFAULT 'Pending',
  `name` varchar(50) DEFAULT NULL,
  `uen` int DEFAULT NULL,
  `dismissal` varchar(4) DEFAULT NULL,
  `region` varchar(10) DEFAULT NULL,
  `size` varchar(20) DEFAULT NULL,
  `timestamp` varchar(30) DEFAULT NULL,
  `actiontimestamp` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`appid`),
  UNIQUE KEY `uen` (`uen`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `schooladmins` (
  `uen` int NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uen`),
  CONSTRAINT `schooladmin_uen_fk` FOREIGN KEY (`uen`) REFERENCES `schools` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `transportadmins` (
  `uen` int NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`uen`),
  CONSTRAINT `trabsportadmin_uen_fk` FOREIGN KEY (`uen`) REFERENCES `transports` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `bus` (
  `uen` int NOT NULL,
  `busid` varchar(10) NOT NULL,
  PRIMARY KEY (`uen`,`busid`),
  CONSTRAINT `uen_bus_fk` FOREIGN KEY (`uen`) REFERENCES `transports` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `driver` (
  `driverid` int NOT NULL,
  `uen` int DEFAULT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`driverid`),
  KEY `driver_uen_fk` (`uen`),
  CONSTRAINT `driver_uen_fk` FOREIGN KEY (`uen`) REFERENCES `transports` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `bus_driver` (
  `uen` int NOT NULL,
  `busid` varchar(10) NOT NULL,
  `driverid` int NOT NULL,
  `tripstatus` varchar(10) DEFAULT NULL,
  `area` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`uen`,`busid`,`driverid`),
  KEY `bus_driver_driver` (`driverid`),
  KEY `idx_bus_id` (`busid`),
  CONSTRAINT `bus_driver_driver` FOREIGN KEY (`driverid`) REFERENCES `driver` (`driverid`),
  CONSTRAINT `bus_driver_uen_busid` FOREIGN KEY (`uen`, `busid`) REFERENCES `bus` (`uen`, `busid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `school_transport` (
  `schooluen` int NOT NULL,
  `transportuen` int NOT NULL,
  PRIMARY KEY (`schooluen`,`transportuen`),
  KEY `fk_transportuen` (`transportuen`),
  CONSTRAINT `fk_schooluen` FOREIGN KEY (`schooluen`) REFERENCES `schools` (`uen`),
  CONSTRAINT `fk_transportuen` FOREIGN KEY (`transportuen`) REFERENCES `transports` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `class` (
  `class` varchar(10) NOT NULL,
  `uen` int DEFAULT NULL,
  PRIMARY KEY (`class`),
  KEY `classuen_fk` (`uen`),
  CONSTRAINT `classuen_fk` FOREIGN KEY (`uen`) REFERENCES `schools` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `teacher` (
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `uen` int NOT NULL,
  `class` varchar(10) DEFAULT NULL,
  `teacherid` varchar(45) NOT NULL,
  PRIMARY KEY (`teacherid`,`uen`),
  KEY `teacher_uen_fk` (`uen`),
  KEY `teacher_class_fk` (`class`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `student` (
  `studentid` varchar(10) NOT NULL,
  `parentid` varchar(50) DEFAULT NULL,
  `pcode` int DEFAULT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `class` varchar(10) DEFAULT NULL,
  `uen` int NOT NULL,
  `subscription` varchar(10) DEFAULT 'No',
  `pickupmode` tinyint(1) DEFAULT NULL,
  `pickupstatus` varchar(10) DEFAULT NULL,
  `busid` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`studentid`,`uen`),
  KEY `student_class_fk` (`class`),
  KEY `student_uen_fk` (`uen`),
  KEY `fk_busid` (`busid`),
  CONSTRAINT `student_uen_fk` FOREIGN KEY (`uen`) REFERENCES `schools` (`uen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `parentguardians` (
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `parentid` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `3pp` (
  `3ppid` varchar(50) DEFAULT NULL,
  `fname` varchar(30) DEFAULT NULL,
  `lname` varchar(30) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `parentid` varchar(50) NOT NULL,
  PRIMARY KEY (`parentid`),
  CONSTRAINT `3pp_parentid_fk` FOREIGN KEY (`parentid`) REFERENCES `parentguardians` (`parentid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

