CREATE TABLE `song_subgenres`
(
  `id` int
(11) NOT NULL AUTO_INCREMENT,
  `song_id` int
(11) NOT NULL,
  `genre_id` int
(11) NOT NULL,
  PRIMARY KEY
(`id`),
  KEY `FK_genre_GenreID`
(`genre_id`),
  KEY `FK_songs_SongID`
(`song_id`),
  CONSTRAINT `FK_genre_GenreID` FOREIGN KEY
(`genre_id`) REFERENCES `genre`
(`id`),
  CONSTRAINT `FK_songs_SongID` FOREIGN KEY
(`song_id`) REFERENCES `songs`
(`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1278 DEFAULT CHARSET=utf8