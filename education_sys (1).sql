-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 12 Oca 2022, 21:41:01
-- Sunucu sürümü: 10.4.21-MariaDB
-- PHP Sürümü: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `education_sys`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `consents`
--

CREATE TABLE `consents` (
  `consentid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `result` int(11) NOT NULL,
  `message` varchar(80) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `consents`
--

INSERT INTO `consents` (`consentid`, `studentid`, `courseid`, `result`, `message`) VALUES
(2, 4, 1, 0, NULL),
(3, 3, 1, 1, 'Please'),
(4, 3, 1, 0, 'I am into web dev!'),
(6, 12, 1, 0, 'Please accept:)');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `courses`
--

CREATE TABLE `courses` (
  `course_code` varchar(11) NOT NULL,
  `course_name` text NOT NULL,
  `course_professor` text NOT NULL,
  `course_info` text NOT NULL,
  `course_quota` int(11) NOT NULL,
  `course_finaldate` date NOT NULL,
  `course_consent` text NOT NULL,
  `courseid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `courses`
--

INSERT INTO `courses` (`course_code`, `course_name`, `course_professor`, `course_info`, `course_quota`, `course_finaldate`, `course_consent`, `courseid`) VALUES
('MIS111', 'Economics', 'Tükel', 'Microeconomics and Macroeconomics', 50, '2022-01-20', 'Not required', 3),
('MIS112', 'Economics ll', 'Tükel', 'Economical concepts', 60, '2022-01-13', 'Not required', NULL),
('MIS131', 'Algorithms', 'Taşkın', 'Java', 60, '2022-01-05', 'Not required', NULL),
('MIS233', 'Web Based Application Programming', 'Coskun', 'HTML, CSS, JS, jQuery, mySql, PHP', 80, '2022-01-18', 'Required', 1),
('MIS335', 'Database Systems', 'Durahim', 'SQL, Relational Algebra', 65, '2022-01-20', 'Not required', 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `studentscourses`
--

CREATE TABLE `studentscourses` (
  `entryid` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `courseid` int(11) NOT NULL,
  `Grade` char(30) NOT NULL DEFAULT 'Not Submitted'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `studentscourses`
--

INSERT INTO `studentscourses` (`entryid`, `studentid`, `courseid`, `Grade`) VALUES
(2, 4, 2, 'Failed'),
(102, 3, 1, 'Passed'),
(103, 3, 2, 'Not Submitted'),
(104, 4, 1, 'Passed'),
(105, 9, 0, 'Not Submitted'),
(107, 3, 0, 'Not Submitted');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `systemparameters`
--

CREATE TABLE `systemparameters` (
  `MinPwd` int(11) NOT NULL,
  `MaxPwd` int(11) NOT NULL,
  `MaxCourse` int(11) NOT NULL,
  `MaxStuCourse` int(11) NOT NULL,
  `MaxProfCourse` int(11) NOT NULL,
  `adminName` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `systemparameters`
--

INSERT INTO `systemparameters` (`MinPwd`, `MaxPwd`, `MaxCourse`, `MaxStuCourse`, `MaxProfCourse`, `adminName`) VALUES
(8, 15, 5, 5, 3, 'lamia');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `UserType` text NOT NULL,
  `rName` text NOT NULL,
  `Surname` text NOT NULL,
  `Username` text NOT NULL,
  `Password` text NOT NULL,
  `uid` int(11) NOT NULL,
  `UserStatus` varchar(20) NOT NULL DEFAULT 'Active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`UserType`, `rName`, `Surname`, `Username`, `Password`, `uid`, `UserStatus`) VALUES
('Admin', 'Lamia', 'Demirok', 'lamia', 'lamialamia', 1, 'Active'),
('Professor', 'Mustafa', 'Coskun', 'mustafacoskun', 'mustafa123', 2, 'Active'),
('Student', 'Ege', 'Tosun', 'egetosun', 'ege28tos', 3, 'Active'),
('Student', 'Efe', 'Mor', 'efemor', 'mrefe1234', 4, 'Active'),
('Professor', 'Ahmet Onur', 'Durahim', 'aodurahim', 'drhmonr.1', 5, 'Active'),
('Professor', 'Ali', 'Tükel', 'alitkl', 'al45tkl65', 7, 'Active'),
('Student', 'Melis', 'Sevinç', 'melissvnc', 'melsmels12', 9, 'Active'),
('Student', 'Şebnem', 'Karabıçak', 'sebnemkrbck', 'seboseb12', 12, 'Active'),
('Professor', 'Nazım', 'Taşkın', 'nazimtaskin', 'nzm123tskn', 13, 'Active');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `consents`
--
ALTER TABLE `consents`
  ADD PRIMARY KEY (`consentid`);

--
-- Tablo için indeksler `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`course_code`);

--
-- Tablo için indeksler `studentscourses`
--
ALTER TABLE `studentscourses`
  ADD PRIMARY KEY (`entryid`);

--
-- Tablo için indeksler `systemparameters`
--
ALTER TABLE `systemparameters`
  ADD PRIMARY KEY (`adminName`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `consents`
--
ALTER TABLE `consents`
  MODIFY `consentid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `studentscourses`
--
ALTER TABLE `studentscourses`
  MODIFY `entryid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
