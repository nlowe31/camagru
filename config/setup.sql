CREATE DATABASE IF NOT EXISTS camagru;

USE camagru;

CREATE TABLE IF NOT EXISTS users (
    `uid` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    `username` varchar(255) UNIQUE COLLATE utf8_unicode_ci NOT NULL,    
    `email` varchar(255) UNIQUE COLLATE utf8_unicode_ci NOT NULL,
    `firstName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `lastName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `registration` varchar(255) COLLATE utf8_unicode_ci,
    `confirmed` tinyint(1) NOT NULL DEFAULT 0,
    `notifications` tinyint(1) NOT NULL DEFAULT 1,
    UNIQUE (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS posts (
    `pid` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `uid` int(11) NOT NULL,
    `src` varchar(255),
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `confirmed` tinyint(1) NOT NULL DEFAULT 0,
    KEY (`uid`),
    CONSTRAINT `posts_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS comments (
    `cid` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `pid` int(11) NOT NULL,
    `uid` int(11) NOT NULL,
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `text` text COLLATE utf8_unicode_ci NOT NULL,
    KEY (`uid`),
    KEY (`pid`),
    CONSTRAINT `comments_pid` FOREIGN KEY (`pid`) REFERENCES `posts` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `comments_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS likes (
    `lid` int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    `pid` int(11) NOT NULL,
    `uid` int(11) NOT NULL,
    `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    KEY (`uid`),
    KEY (`pid`),
    CONSTRAINT `likes_pid` FOREIGN KEY (`pid`) REFERENCES `posts` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `likes_uid` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;