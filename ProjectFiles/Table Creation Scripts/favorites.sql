CREATE TABLE `favourites`
(
  `favourite_id` int
(11) NOT NULL AUTO_INCREMENT,
  `account_id` int
(11) NOT NULL,
  `song_id` int
(11) NOT NULL,
  `favourite` tinyint
(1) NOT NULL,
  PRIMARY KEY
(`favourite_id`),
  KEY `FK_favourites_songs_songID`
(`song_id`),
  KEY `FK_favourites_users_userID`
(`account_id`),
  CONSTRAINT `FK_favourites_users_userID` FOREIGN KEY
(`account_id`) REFERENCES `account`
(`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8