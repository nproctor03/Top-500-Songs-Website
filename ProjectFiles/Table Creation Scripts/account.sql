CREATE TABLE `account`
(
  `account_id` int
(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar
(255) NOT NULL,
  `last_name` varchar
(255) NOT NULL,
  `user_name` varchar
(255) NOT NULL,
  `email` varchar
(255) NOT NULL,
  `password` varbinary
(255) NOT NULL,
  `account_type_id` int
(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp
() ON
UPDATE current_timestamp(),
  PRIMARY KEY
(`account_id`),
  UNIQUE KEY `user_name`
(`user_name`),
  UNIQUE KEY `email`
(`email`),
  KEY `FK_account_accountType_accountTypeID`
(`account_type_id`),
  CONSTRAINT `FK_account_accountType_accountTypeID` FOREIGN KEY
(`account_type_id`) REFERENCES `account_type`
(`account_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8