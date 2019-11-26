-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Erstellungszeit: 12. Mrz 2019 um 14:13
-- Server-Version: 10.1.19-MariaDB
-- PHP-Version: 7.0.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `conjoint_results`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `choices`
--

CREATE TABLE `choices` (
  `Response_ID` int(11) NOT NULL,
  `Respondent_ID` int(11) NOT NULL,
  `PubIDs_Order_Displayed` varchar(128) NOT NULL,
  `PubIDs_Order_Chosen` varchar(128) NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `choice_sets`
--

CREATE TABLE `choice_sets` (
  `ID` int(32) NOT NULL,
  `Publication1` int(32) NOT NULL,
  `Publication2` int(32) NOT NULL,
  `Publication3` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `choice_sets`
--

INSERT INTO `choice_sets` (`ID`, `Publication1`, `Publication2`, `Publication3`) VALUES
(1, 627, 518, 372),
(2, 323, 627, 505),
(3, 55, 323, 89),
(4, 279, 55, 337),
(5, 675, 279, 682),
(6, 43, 675, 605),
(7, 472, 43, 212),
(8, 605, 472, 638),
(9, 212, 605, 407),
(10, 638, 212, 627),
(11, 407, 638, 323),
(12, 372, 407, 55),
(13, 505, 372, 279),
(14, 89, 505, 675),
(15, 337, 89, 43),
(16, 682, 337, 472),
(17, 15, 682, 228),
(18, 228, 15, 157),
(19, 157, 228, 518),
(20, 518, 157, 15);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `indicators`
--

CREATE TABLE `indicators` (
  `Indicator_ID` varchar(64) NOT NULL,
  `Indicator_Name` varchar(64) NOT NULL,
  `Image_Link` varchar(128) NOT NULL,
  `Description` varchar(256) NOT NULL,
  `Level0` varchar(48) NOT NULL,
  `Level1` varchar(48) NOT NULL,
  `Level2` varchar(48) NOT NULL,
  `Level3` varchar(48) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `indicators`
--

INSERT INTO `indicators` (`Indicator_ID`, `Indicator_Name`, `Image_Link`, `Description`, `Level0`, `Level1`, `Level2`, `Level3`) VALUES
('Altmetric_Score', 'Altmetric Score', 'img/amscore.jpg', '', 'n/a', '0', '5.2', '326.7'),
('Citations_(GS)', 'Citations (e.g., on GS)', 'img/citations.png', 'The citation count measures the number of publications that contain a reference to a respective publication.', 'n/a', '0', '5', '250'),
('EconStor_Downloads', 'Downloads', 'img/downloads.png', 'The download count measures the number of times a publication has been downloaded from its repository (e.g., on EconStor).', 'n/a', '0', '100', '5000'),
('Facebook_Mentions', 'Facebook mentions', 'img/facebook.png', 'Facebook mentions reflect interactions with postings about a publication on Facebook, namely Likes, comments and shares of such posts.', 'n/a', '0', '10', '500'),
('H_Index', 'h-Index', 'img/hindex.png', 'The h-index is an author-level metric based on the citations to that author''s publications. An h-index of x means that the respective author wrote x publications which received at least x citations each.', 'n/a', '0', '5', '30'),
('JIF', 'Journal Impact Factor', 'img/jif.png', 'The Journal Impact Factor is a journal-level metric and a measure reflecting the annual average (mean) number of citations to recent articles published in that journal.', 'n/a', '0', '5.0', '30.0'),
('Mendeley_Readers', 'Mendeley readers', 'img/mendeley.png', 'The count of Mendeley readers for a publication equals the number of Mendeley users who added a link to the publication to their personal library in the reference manager Mendeley.', 'n/a', '0', '10', '500'),
('PLoS_Views', 'Views (e.g. on PLoS)', 'img/views.jpg', '', 'n/a', '0', '100', '5000'),
('ResearchGate_Score', 'ResearchGate-Score', 'img/rgscore.png', 'The ResearchGate-Score is an author-level metric based on the author''s activities measured on the academic social network ResearchGate. It aggregates scores for numbers of publications, postings, and followers, among others.', 'n/a', '0', '5.0', '50.0'),
('Tweets', 'Tweets', 'img/tweets.png', 'The tweet count reflects the number of postings mentioning a respective publication on the microblogging service Twitter.', 'n/a', '0', '10', '500');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `publications`
--

CREATE TABLE `publications` (
  `Publication_ID` int(11) NOT NULL,
  `Title` varchar(64) NOT NULL,
  `Authors` varchar(64) NOT NULL,
  `Publication_Date` int(11) NOT NULL,
  `Document_Type` varchar(32) NOT NULL,
  `Citations_(GS)` int(11) NOT NULL,
  `Facebook_Mentions` int(11) NOT NULL,
  `Tweets` int(11) NOT NULL,
  `Mendeley_Readers` int(11) NOT NULL,
  `EconStor_Downloads` int(11) NOT NULL,
  `JIF` float NOT NULL,
  `PLoS_Views` int(11) NOT NULL,
  `Altmetric_Score` int(11) NOT NULL,
  `H_Index` int(32) NOT NULL,
  `ResearchGate_Score` int(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Daten für Tabelle `publications`
--

INSERT INTO `publications` (`Publication_ID`, `Title`, `Authors`, `Publication_Date`, `Document_Type`, `Citations_(GS)`, `Facebook_Mentions`, `Tweets`, `Mendeley_Readers`, `EconStor_Downloads`, `JIF`, `PLoS_Views`, `Altmetric_Score`, `H_Index`, `ResearchGate_Score`) VALUES
(15, '-', '-', 0, '-', 3, 0, 2, 2, 1, 1, 0, 0, 1, 0),
(43, '-', '-', 0, '-', 1, 0, 3, 2, 2, 1, 0, 0, 1, 0),
(55, '-', '-', 0, '-', 1, 0, 1, 1, 3, 1, 0, 0, 1, 0),
(89, '-', '-', 0, '-', 2, 0, 3, 1, 1, 2, 0, 0, 1, 0),
(157, '-', '-', 0, '-', 1, 0, 2, 3, 3, 2, 0, 0, 1, 0),
(212, '-', '-', 0, '-', 2, 0, 2, 3, 2, 3, 0, 0, 1, 0),
(228, '-', '-', 0, '-', 3, 0, 1, 2, 3, 3, 0, 0, 1, 0),
(279, '-', '-', 0, '-', 3, 0, 3, 1, 2, 1, 0, 0, 2, 0),
(323, '-', '-', 0, '-', 2, 0, 3, 3, 3, 1, 0, 0, 2, 0),
(337, '-', '-', 0, '-', 1, 0, 2, 2, 1, 2, 0, 0, 2, 0),
(372, '-', '-', 0, '-', 3, 0, 1, 3, 2, 2, 0, 0, 2, 0),
(407, '-', '-', 0, '-', 2, 0, 1, 1, 1, 3, 0, 0, 2, 0),
(472, '-', '-', 0, '-', 1, 0, 2, 2, 3, 3, 0, 0, 2, 0),
(505, '-', '-', 0, '-', 1, 0, 1, 3, 1, 1, 0, 0, 3, 0),
(518, '-', '-', 0, '-', 2, 0, 2, 1, 2, 1, 0, 0, 3, 0),
(605, '-', '-', 0, '-', 2, 0, 1, 2, 2, 2, 0, 0, 3, 0),
(627, '-', '-', 0, '-', 3, 0, 2, 1, 3, 2, 0, 0, 3, 0),
(638, '-', '-', 0, '-', 2, 0, 3, 2, 3, 2, 0, 0, 3, 0),
(675, '-', '-', 0, '-', 3, 0, 3, 3, 1, 3, 0, 0, 3, 0),
(682, '-', '-', 0, '-', 1, 0, 3, 1, 2, 3, 0, 0, 3, 0);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `reimbursement`
--

CREATE TABLE `reimbursement` (
  `Name` varchar(64) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Sub_Email` varchar(64) DEFAULT NULL,
  `ID` int(11) NOT NULL,
  `Code` varchar(48) NOT NULL,
  `Want_drawing` varchar(4) NOT NULL,
  `Want_results` varchar(4) NOT NULL,
  `Want_general_info` varchar(4) NOT NULL,
  `Want_invitations` varchar(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `respondents`
--

CREATE TABLE `respondents` (
  `Respondent_ID` int(11) NOT NULL,
  `Session_ID` varchar(128) NOT NULL,
  `Date_Started` datetime NOT NULL,
  `Date_Submitted` datetime NOT NULL,
  `Last_Page` int(11) NOT NULL,
  `Date_Last_Action` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `IP_Address` varchar(48) NOT NULL,
  `Discipline` varchar(128) NOT NULL,
  `Branch_Economics` varchar(128) NOT NULL,
  `Branch_SocSci` varchar(128) NOT NULL,
  `Role` varchar(128) NOT NULL,
  `Workplace` varchar(128) NOT NULL,
  `Total_Time` int(11) NOT NULL,
  `Features` varchar(1000) NOT NULL,
  `Other_Features` varchar(1000) NOT NULL,
  `FavIndicator` varchar(64) NOT NULL,
  `Comments` varchar(1000) NOT NULL,
  `Sub_Comments` varchar(1000) DEFAULT NULL,
  `Gender` varchar(32) NOT NULL,
  `Birthyear` int(11) NOT NULL,
  `Years_of_AE` int(11) NOT NULL,
  `Country` varchar(64) NOT NULL,
  `Email` varchar(64) NOT NULL,
  `Newsletter` varchar(32) NOT NULL,
  `Indicatorset` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `sub_choices`
--

CREATE TABLE `sub_choices` (
  `Response_ID` int(11) NOT NULL,
  `Respondent_ID` int(11) NOT NULL,
  `PubIDs_Order_Displayed` varchar(128) NOT NULL,
  `PubIDs_Order_Chosen` varchar(128) NOT NULL,
  `Timestamp` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `choices`
--
ALTER TABLE `choices`
  ADD PRIMARY KEY (`Response_ID`);

--
-- Indizes für die Tabelle `choice_sets`
--
ALTER TABLE `choice_sets`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `indicators`
--
ALTER TABLE `indicators`
  ADD PRIMARY KEY (`Indicator_ID`);

--
-- Indizes für die Tabelle `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`Publication_ID`);

--
-- Indizes für die Tabelle `reimbursement`
--
ALTER TABLE `reimbursement`
  ADD PRIMARY KEY (`ID`);

--
-- Indizes für die Tabelle `respondents`
--
ALTER TABLE `respondents`
  ADD PRIMARY KEY (`Respondent_ID`),
  ADD UNIQUE KEY `Session_ID` (`Session_ID`);

--
-- Indizes für die Tabelle `sub_choices`
--
ALTER TABLE `sub_choices`
  ADD PRIMARY KEY (`Response_ID`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `choices`
--
ALTER TABLE `choices`
  MODIFY `Response_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4580;
--
-- AUTO_INCREMENT für Tabelle `choice_sets`
--
ALTER TABLE `choice_sets`
  MODIFY `ID` int(32) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT für Tabelle `publications`
--
ALTER TABLE `publications`
  MODIFY `Publication_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=683;
--
-- AUTO_INCREMENT für Tabelle `reimbursement`
--
ALTER TABLE `reimbursement`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=335;
--
-- AUTO_INCREMENT für Tabelle `respondents`
--
ALTER TABLE `respondents`
  MODIFY `Respondent_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300;
--
-- AUTO_INCREMENT für Tabelle `sub_choices`
--
ALTER TABLE `sub_choices`
  MODIFY `Response_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=947;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
