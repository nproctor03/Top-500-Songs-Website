CREATE TABLE `songs`
(
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `ranking` int
(11) NOT NULL,
  `year` varchar
(4) NOT NULL,
  `album` varchar
(200) NOT NULL,
  `artist` varchar
(200) NOT NULL,
  `genre` int
(11) NOT NULL,
  `url` varchar
(255) NOT NULL,
  PRIMARY KEY
(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=501 DEFAULT CHARSET=utf8