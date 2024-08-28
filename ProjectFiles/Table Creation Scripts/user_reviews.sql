CREATE TABLE `user_reviews`
(
  `review_id` int
(11) NOT NULL AUTO_INCREMENT,
  `account_id` int
(11) NOT NULL,
  `song_id` int
(11) NOT NULL,
  `rating` double NOT NULL,
  `review` varchar
(255) NOT NULL,
  `admin_approved` tinyint
(1) NOT NULL,
  `datecreated` timestamp NOT NULL DEFAULT current_timestamp
() ON
UPDATE current_timestamp(),
  PRIMARY KEY
(`review_id`),
  KEY `FK_rating_song_songID`
(`song_id`),
  KEY `FK_rating_user_userID`
(`account_id`),
  CONSTRAINT `FK_rating_user_userID` FOREIGN KEY
(`account_id`) REFERENCES `account`
(`account_id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8