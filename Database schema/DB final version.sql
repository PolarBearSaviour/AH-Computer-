CREATE DATABASE SiteDatabase;
USE Sitedatabase;

CREATE TABLE users(
  `userID` int unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `hash` varchar(60) NOT NULL,
  UNIQUE KEY `username` (`username`),
  PRIMARY KEY(`userID`)
)ENGINE = INNODB;

CREATE TABLE loggedIn(
  `token` varchar(100) NOT NULL,
  `userID` int unsigned NOT NULL,
  PRIMARY KEY(`token`),
  FOREIGN KEY(`userID`) REFERENCES users(`userID`)
)ENGINE = INNODB;

CREATE TABLE subject(
  `subjectID` int unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(150) NOT NULL,
  PRIMARY KEY(`subjectID`)
)ENGINE = INNODB;

CREATE TABLE level(
  `levelID` int unsigned NOT NULL AUTO_INCREMENT,
  `level` varchar(25),
  PRIMARY KEY(`levelID`)
)ENGINE = INNODB;

CREATE TABLE QuestionInfo(
  `questionID` int unsigned NOT NULL AUTO_INCREMENT,
  `userID` int unsigned NOT NULL,
  `subjectID` int unsigned NOT NULL,
  `levelID` int unsigned NOT NULL,
  `questionTitle` varchar(50) NOT NULL,
  `questionTimeStamp` timestamp NOT NULL,
  PRIMARY KEY(`questionID`),
  FOREIGN KEY(`userID`) REFERENCES users(`userID`) ON DELETE CASCADE,
  FOREIGN KEY(`subjectID`) REFERENCES subject(`subjectID`) ON DELETE CASCADE,
  FOREIGN KEY(`levelID`) REFERENCES level(`levelID`) ON DELETE CASCADE
)ENGINE = INNODB;

CREATE TABLE questions(
  `questionID` int unsigned NOT NULL,
  `question` varchar(5000),
  FOREIGN KEY (`questionID`) REFERENCES questionInfo (`questionID`) ON DELETE CASCADE
)ENGINE=INNODB;

CREATE TABLE answerInfo(
  `answerID` int unsigned NOT NULL,
  `userID` int unsigned NOT NULL,
  `questionID` int unsigned NOT NULL,
  `answerTimestamp` timestamp NOT NULL,
  PRIMARY KEY(`answerID`),
  FOREIGN KEY(`userID`) REFERENCES users(`userID`) ON DELETE CASCADE,
  FOREIGN KEY(`questionID`) REFERENCES QuestionInfo(`questionID`) ON DELETE CASCADE
)ENGINE = INNODB;

CREATE TABLE answer(
  `answerID` int unsigned NOT NULL AUTO_INCREMENT,
  `answer` varchar(5000),
  FOREIGN KEY (`answerID`) REFERENCES answerInfo(`answerID`) ON DELETE CASCADE
)ENGINE = INNODB;

CREATE TABLE answerRight(
  `ID` INT unsigned NOT NULL AUTO_INCREMENT,
  `answerID` int unsigned NOT NULL,
  `answerRight` boolean NOT NULL,
  PRIMARY KEY (`ID`),
  FOREIGN KEY (`answerID`) REFERENCES answerInfo(`answerID`) ON DELETE CASCADE
)ENGINE = INNODB;
