CREATE TABLE `ticket` (
  `ticketID` int(11) NOT NULL,
  `titel` varchar(255) NOT NULL,
  `gueltigVon` datetime DEFAULT NULL,
  `gueltigBis` datetime DEFAULT NULL,
  `erstelltam` datetime DEFAULT NULL,
  `nutzerid` int(10) UNSIGNED NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  `datei` LONGBLOB DEFAULT NULL
)
CREATE TABLE `users` (
  `nutzerid` int(11) NOT NULL,
  `Benutzername` varchar(20) NOT NULL,
  `Passwort` varchar(255) NOT NULL
);
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticketID`);
