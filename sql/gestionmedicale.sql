-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 14 mars 2022 à 09:58
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionmedicale`
--

-- --------------------------------------------------------

--
-- Structure de la table `medecin`
--

DROP TABLE IF EXISTS `medecin`;
CREATE TABLE IF NOT EXISTS `medecin` (
  `id_medecin` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `civilite` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_medecin`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `medecin`
--

INSERT INTO `medecin` (`id_medecin`, `prenom`, `nom`, `civilite`) VALUES
(1, 'Léa', 'Chauveau', 'Madame'),
(2, 'Romy', 'Blanc', 'Monsieur'),
(3, 'Martin', 'Guillon', 'Monsieur'),
(4, 'Ruben', 'Foucher', 'Monsieur'),
(5, 'Antonin', 'Voisin', 'Monsieur'),
(6, 'Léon', 'Jeannin', 'Monsieur'),
(7, 'Imran', 'Godefroy', 'Monsieur'),
(8, 'Nino', 'Lassalle', 'Monsieur'),
(9, 'Charles', 'Gomis', 'Monsieur'),
(10, 'Eva', 'Roch', 'Madame'),
(11, 'Maxime', 'Bureau', 'Monsieur'),
(12, 'Gabriel', 'Bureau', 'Monsieur'),
(13, 'Hugo', 'Michaux', 'Monsieur'),
(14, 'Emilie', 'Bourreau', 'Madame'),
(15, 'Noam', 'Lacaze', 'Monsieur'),
(16, 'Lisa', 'Lafont', 'Madame'),
(17, 'Manon', 'Lagrange', 'Madame'),
(18, 'Lisa', 'Gallet', 'Madame'),
(19, 'Rose', 'Courtois', 'Madame');

-- --------------------------------------------------------

--
-- Structure de la table `patient`
--

DROP TABLE IF EXISTS `patient`;
CREATE TABLE IF NOT EXISTS `patient` (
  `id_patient` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `civilite` varchar(50) DEFAULT NULL,
  `adresse` varchar(50) DEFAULT NULL,
  `code_postal` int(6) DEFAULT NULL,
  `ville` varchar(50) DEFAULT NULL,
  `date_naissance` bigint(20) DEFAULT NULL,
  `lieu_naissance` varchar(50) DEFAULT NULL,
  `num_ss` char(15) DEFAULT NULL,
  `id_medecin` int(11) DEFAULT NULL,
  PRIMARY KEY (`id_patient`),
  KEY `Id_Medecin` (`id_medecin`)
) ENGINE=MyISAM AUTO_INCREMENT=109 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `patient`
--

INSERT INTO `patient` (`id_patient`, `nom`, `prenom`, `civilite`, `adresse`, `code_postal`, `ville`, `date_naissance`, `lieu_naissance`, `num_ss`, `id_medecin`) VALUES
(1, 'Eikenboom', 'Kevyn', 'Monsieur', '578-1921 Ante. Road', 96836, 'Mâcon', 19780709125850, 'Vitrolles', '268944922381194', 18),
(2, 'Achthoven', 'Tyler', 'Madame', '524-1864 Risus St.', 83622, 'Bordeaux', 19800614074718, 'Le Puy-en-Velay', '337432333086231', 15),
(3, 'Monet', 'Galena', 'Madame', '916-127 Nec, St.', 38746, 'Rennes', 19870114111206, 'Brive-la-Gaillarde', '104172314645764', 4),
(4, 'Hendrix', 'Elvis', 'Madame', '833-1257 Sed St.', 15952, 'Vandoeuvre-lès-Nancy', 19820406153425, 'Aulnay-sous-Bois', '342258283045399', 9),
(5, 'Eikenboom', 'Kevyn', 'Monsieur', '578-1921 Ante. Road', 96836, 'Mâcon', 19780709125850, 'Vitrolles', '268944922381194', 18),
(6, 'Achthoven', 'Tyler', 'Madame', '524-1864 Risus St.', 83622, 'Bordeaux', 19800614074718, 'Le Puy-en-Velay', '337432333086231', 15),
(7, 'Monet', 'Galena', 'Madame', '916-127 Nec, St.', 38746, 'Rennes', 19870114111206, 'Brive-la-Gaillarde', '104172314645764', 4),
(8, 'Hendrix', 'Elvis', 'Madame', '833-1257 Sed St.', 15952, 'Vandoeuvre-lès-Nancy', 19820406153425, 'Aulnay-sous-Bois', '342258283045399', 9),
(9, 'Maes', 'Clementine', 'Madame', 'Ap #851-3909 Per Road', 53243, 'Orléans', 179301297, 'Lanester', '573731270785562', 10),
(10, 'Segal', 'Colton', 'Madame', 'Ap #507-8418 Nunc Ave', 76176, 'Saint-Louis', 714781735, 'Montauban', '525413570563872', 3),
(11, 'Victor', 'Chaney', 'Monsieur', '551-2962 Suscipit, Road', 81199, 'Draguignan', 706609496, 'Besançon', '469831472656566', 7),
(12, 'Neuville', 'Tana', 'Madame', 'Ap #907-8189 Sit St.', 18222, 'Ajaccio', 507729959, 'Charleville-Mézières', '789540771352056', 8),
(13, 'Travers', 'Rana', 'Madame', 'Ap #389-9505 Nam Road', 94518, 'Le Petit-Quevilly', 400045940, 'Vierzon', '146583515283955', 11),
(14, 'Cruyssen', 'Bethany', 'Madame', '876-5445 Eu, Road', 51478, 'Montigny-lès-Metz', 560886690, 'Nevers', '176268766958523', 10),
(15, 'Beauchene', 'Lenore', 'Monsieur', 'P.O. Box 399, 3958 Consectetuer, Rd.', 37035, 'Rouen', 362678932, 'Ajaccio', '395750467428089', 4),
(16, 'Duval', 'Tatiana', 'Monsieur', '5927 Gravida Av.', 71202, 'Nevers', 220160698, 'Rezé', '809870835648404', 17),
(17, 'Janssens', 'Hashim', 'Madame', 'Ap #455-7280 Nec St.', 11317, 'Montpellier', 1194882, 'La Roche-sur-Yon', '831510824495519', 11),
(18, 'Lavigne', 'Dai', 'Monsieur', '5460 Penatibus Rd.', 25350, 'Saint-Quentin', 509890303, 'Brive-la-Gaillarde', '702422148184155', 16),
(19, 'Mertens', 'Rhea', 'Monsieur', '810-5108 Id, Road', 86844, 'Brest', 323987148, 'Sens', '405885109711316', 4),
(20, 'Dumont', 'Mohammad', 'Madame', 'Ap #512-4716 Scelerisque St.', 16350, 'Asnières-sur-Seine', -91033319, 'Sarreguemines', '138820011063870', 10),
(21, 'Deforest', 'Molly', 'Madame', 'Ap #634-6107 Augue. Rd.', 33257, 'Lille', 746042564, 'Brive-la-Gaillarde', '822898731035673', 1),
(22, 'Chastain', 'Gregory', 'Monsieur', '8162 Lacus. Ave', 92481, 'Bastia', 268111372, 'Dreux', '862852326707035', 7),
(23, 'Ter Avest', 'Stella', 'Monsieur', '8875 Donec Rd.', 45704, 'Orléans', 15697268, 'Schiltigheim', '187853827713665', 5),
(24, 'Lemaire', 'Yael', 'Monsieur', 'Ap #966-2297 Libero Av.', 78586, 'Limoges', 558141419, 'Limoges', '155246488279155', 1),
(25, 'Rietveld', 'Maile', 'Monsieur', '106-3559 Nec Rd.', 41773, 'Courbevoie', 426835826, 'Laon', '481885671915688', 15),
(26, 'Plourde', 'Anjolie', 'Madame', '806-5464 Lorem Av.', 66417, 'Saint-Malo', 621305462, 'Mulhouse', '779126875313061', 6),
(27, 'Hendrix', 'Kim', 'Madame', '5833 Cursus. Av.', 63848, 'Troyes', 394098319, 'Boulogne-Billancourt', '344538611769727', 14),
(28, 'Deforest', 'Cally', 'Madame', 'P.O. Box 961, 3252 Ut, Rd.', 32538, 'Brest', 435905515, 'Châteauroux', '675632377164919', 13),
(29, 'De Witte', 'Jaden', 'Monsieur', '6287 Tortor. St.', 21024, 'Schiltigheim', 715276077, 'Nancy', '752308564179463', 18),
(30, 'Klein', 'Flynn', 'Madame', '322-3467 Ornare St.', 50264, 'Pontarlier', 590043137, 'Clermont-Ferrand', '652034144925433', 10),
(31, 'Petit', 'Merrill', 'Monsieur', '170 Tempor Rd.', 7410, 'Châlons-en-Champagne', 175960850, 'Orléans', '372240957709347', 18),
(32, 'Rademaker', 'Francesca', 'Madame', 'P.O. Box 361, 4861 Dictum Ave', 40439, 'Vandoeuvre-lès-Nancy', 167666929, 'Brive-la-Gaillarde', '167259347068052', 4),
(33, 'Poirier', 'Jane', 'Madame', '596-2853 Felis Avenue', 74483, 'Villenave-d\'Ornon', 443236585, 'Perpignan', '523470617744352', 7),
(34, 'Lavigne', 'Josephine', 'Monsieur', '8769 Nascetur Ave', 67666, 'Épinal', 269502739, 'Hérouville-Saint-Clair', '760657839982953', 18),
(35, 'Klein', 'Fitzgerald', 'Madame', '366-4795 Lacinia Rd.', 12782, 'Brive-la-Gaillarde', 627274313, 'Roubaix', '605925184030300', 18),
(36, 'Achterberg', 'Justin', 'Madame', '7424 Malesuada St.', 38348, 'Limoges', 40677412, 'Anglet', '769104242295275', 17),
(37, 'Chaput', 'Shaeleigh', 'Monsieur', 'Ap #797-9459 A, St.', 88926, 'La Roche-sur-Yon', 518864868, 'Reims', '433513623522508', 10),
(38, 'Poirier', 'Ezra', 'Madame', '872-4906 Neque Rd.', 54411, 'Dole', 156706730, 'Ajaccio', '487297813666162', 15),
(39, 'Savatier', 'Iola', 'Monsieur', 'Ap #821-1173 Auctor Avenue', 20322, 'Auxerre', -4506473, 'Noisy-le-Grand', '958278613365274', 16),
(40, 'Janssens', 'Cassady', 'Monsieur', '8962 Vulputate Av.', 63892, 'Compiègne', 357385765, 'Mont-de-Marsan', '828632338914646', 18),
(41, 'Van Aalsburg', 'Ray', 'Monsieur', 'Ap #528-7302 Integer Rd.', 32727, 'Saint-Médard-en-Jalles', -88247803, 'Tournefeuille', '883477490487443', 2),
(42, 'Hoedemaker', 'Macon', 'Madame', '414-6079 Pede. St.', 87432, 'Béziers', 294014944, 'Agen', '825864027577161', 5),
(43, 'Hoedemaker', 'Baxter', 'Monsieur', '261-6140 Malesuada Avenue', 84823, 'Saint-Lô', 697978704, 'Cannes', '821717126085320', 13),
(44, 'Koopman', 'Uma', 'Madame', '9586 Vivamus Rd.', 91953, 'Dijon', 332187783, 'Le Cannet', '304374130452567', 13),
(45, 'Cruyssen', 'Tobias', 'Monsieur', 'Ap #763-1703 Quisque Street', 15236, 'Rouen', 3108027, 'Draguignan', '323214454524141', 9),
(46, 'Archambault', 'Britanney', 'Madame', 'Ap #524-8006 Eu, Street', 55853, 'Rueil-Malmaison', 184442049, 'Brive-la-Gaillarde', '228163335987894', 18),
(47, 'Fontaine', 'Alexa', 'Madame', '984-7971 Ut St.', 75741, 'Carcassonne', 581233570, 'Brive-la-Gaillarde', '782986542256482', 12),
(48, 'Maes', 'Maggy', 'Madame', 'Ap #391-4971 Vehicula Road', 62332, 'Charleville-Mézières', 64584540, 'Cannes', '863830751863411', 12),
(49, 'Achterberg', 'Blythe', 'Monsieur', 'P.O. Box 674, 2720 Elit. St.', 41345, 'Poitiers', 321764416, 'Pontarlier', '314304457926528', 18),
(50, 'Eikenboom', 'Quinlan', 'Madame', 'Ap #662-986 Odio. Street', 47818, 'Saint-Malo', 496851744, 'Quimper', '271464271480177', 19),
(51, 'Chevalier', 'Jasmine', 'Monsieur', 'Ap #339-9779 Sit Avenue', 98128, 'Reims', 366294700, 'Roubaix', '166377473841740', 11),
(52, 'Leroux', 'Emerald', 'Monsieur', 'Ap #766-9271 Ligula. St.', 87192, 'Saintes', 245037965, 'Blois', '334452110129771', 4),
(53, 'Garcon', 'Geoffrey', 'Madame', '9189 Vitae, Road', 34030, 'Tarbes', 508205508, 'Épernay', '615135766244466', 11),
(54, 'Tremblay', 'Claire', 'Monsieur', 'Ap #730-2098 Nec St.', 34855, 'Le Havre', 487022051, 'Marseille', '582165524886717', 9),
(55, 'Blanc', 'Camille', 'Monsieur', '450 Morbi Av.', 91444, 'Vernon', -93566847, 'Bordeaux', '388561364487067', 4),
(56, 'Monet', 'Tarik', 'Monsieur', 'P.O. Box 294, 5502 Nunc Avenue', 84168, 'Saint-Sébastien-sur-Loire', 185062152, 'Vitrolles', '827251813378100', 9),
(57, 'Duval', 'Sonya', 'Monsieur', 'Ap #801-2717 Curabitur Av.', 26346, 'Dieppe', 203902984, 'Schiltigheim', '737143473424839', 12),
(58, 'Leroux', 'Jasper', 'Monsieur', '299-4043 Quis Av.', 21678, 'Agen', 278504862, 'Rueil-Malmaison', '250162183691430', 7),
(59, 'Kloet', 'Kiona', 'Monsieur', '137-6885 Arcu. Rd.', 74220, 'Châlons-en-Champagne', 295016930, 'Bayonne', '525768875539310', 13),
(60, 'Van Aalsburg', 'Cassady', 'Monsieur', 'P.O. Box 697, 7095 Viverra. Avenue', 11755, 'Saint-Dizier', 500666525, 'Talence', '326602731402693', 16),
(61, 'Hoedemaker', 'Jelani', 'Madame', 'P.O. Box 717, 2259 Neque Ave', 36899, 'Besançon', 497392902, 'Metz', '212684980951712', 8),
(62, 'Aakster', 'Shelly', 'Monsieur', 'Ap #611-3747 Nunc Street', 58744, 'Laon', 580389322, 'Saint-Brieuc', '266385974347286', 9),
(63, 'Chevalier', 'Kaitlin', 'Madame', '339-2217 Non, Rd.', 93746, 'Orvault', 94501389, 'Épernay', '452265518833825', 8),
(64, 'Klein', 'Hector', 'Monsieur', 'Ap #900-1436 Magna. Rd.', 65796, 'Vichy', 349952653, 'Lunel', '721795691488146', 11),
(65, 'Chevalier', 'Yardley', 'Madame', '572-8953 Amet Rd.', 74217, 'Saint-Dizier', 348734109, 'Dieppe', '475367736414034', 9),
(66, 'Tailler', 'Harrison', 'Madame', 'Ap #685-5135 Facilisis. Road', 24862, 'Maubeuge', 145095509, 'Toulouse', '590216486471803', 9),
(67, 'Tremblay', 'Octavius', 'Monsieur', '373-473 Augue Road', 51692, 'Vernon', 63102093, 'Troyes', '363651255475257', 3),
(68, 'Ter Avest', 'Clementine', 'Madame', 'P.O. Box 142, 6951 Adipiscing Ave', 58633, 'Saint-Dié-des-Vosges', -28393194, 'Tourcoing', '571520621307526', 1),
(69, 'Garcon', 'Xavier', 'Madame', '982-8415 Sit Road', 93667, 'Besançon', 176151618, 'Vertou', '553531527480684', 10),
(70, 'Bouwmeester', 'Camden', 'Madame', 'Ap #994-3619 Adipiscing Street', 71889, 'Bergerac', -14207019, 'Pau', '025178159054433', 9),
(71, 'Chaput', 'Akeem', 'Madame', '307-6148 Et Avenue', 97103, 'Lanester', 15905909, 'Schiltigheim', '956032472634388', 15),
(72, 'Beaulieu', 'Brynne', 'Madame', '588-2028 Fames St.', 84585, 'Dunkerque', 77339258, 'Caen', '735104824249709', 19),
(73, 'Offermans', 'Hu', 'Madame', '156-2812 Eu Rd.', 10910, 'Le Grand-Quevilly', 591313607, 'Illkirch-Graffenstaden', '388431212520016', 14),
(74, 'Chevalier', 'William', 'Madame', '376-6635 Lacus Street', 78429, 'Laval', 550008178, 'Montluçon', '767431767723371', 9),
(75, 'Lachapelle', 'Sydnee', 'Monsieur', '412-1669 Vestibulum Ave', 24693, 'Charleville-Mézières', 151117924, 'Poitiers', '137548612314636', 13),
(76, 'Langlais', 'Isabelle', 'Monsieur', '533-2646 Turpis Av.', 42053, 'Reims', 549734932, 'Lorient', '264114455371747', 10),
(77, 'Chaput', 'Tanner', 'Madame', '401-9937 Ipsum Avenue', 37703, 'Brive-la-Gaillarde', 746328339, 'Hérouville-Saint-Clair', '576186643598785', 19),
(78, 'Chastain', 'Willa', 'Monsieur', '747-8362 Consectetuer Rd.', 42335, 'Besançon', 481613332, 'Tours', '352787378224771', 5),
(79, 'Aaldenberg', 'Katell', 'Monsieur', '655-3999 Lacus. Avenue', 60983, 'Moulins', 520325506, 'Bergerac', '935167183312365', 7),
(80, 'Lamar', 'Alden', 'Madame', '336-8422 Vivamus Rd.', 5760, 'Quimper', 486411664, 'Hérouville-Saint-Clair', '522976934316121', 5),
(81, 'De Witte', 'Adrienne', 'Madame', '6379 Placerat Road', 64486, 'Chartres', 633870672, 'Angoulême', '275822383041153', 2),
(82, 'Vincent', 'Josiah', 'Madame', '258-7403 Magna. Avenue', 50822, 'Évreux', 184407732, 'Soissons', '108693208437127', 7),
(83, 'Van Der Aart', 'Connor', 'Monsieur', '6114 Et Avenue', 25485, 'Orléans', 337222887, 'Metz', '920325430723515', 5),
(84, 'Peeters', 'Callum', 'Madame', '466-1054 Volutpat St.', 54576, 'Dijon', 32028305, 'Montigny-lès-Metz', '529123623279142', 8),
(85, 'Bakhuizen', 'Leo', 'Monsieur', '874-2895 In Rd.', 65546, 'Sotteville-lès-Rouen', 1006517, 'Dieppe', '793625826078627', 8),
(86, 'Boivin', 'Merrill', 'Monsieur', 'P.O. Box 762, 6704 Vestibulum Avenue', 51191, 'Aulnay-sous-Bois', 10955881, 'Brive-la-Gaillarde', '748340543233363', 5),
(87, 'De Witte', 'Whilemina', 'Madame', 'Ap #179-1971 Sit Avenue', 77573, 'Chalon-sur-Saône', -99836072, 'Brive-la-Gaillarde', '380765257748543', 3),
(88, 'Cruyssen', 'Jayme', 'Madame', '5239 Semper Ave', 75842, 'Creil', 629186449, 'Niort', '724145018516377', 10),
(89, 'Heeren', 'Chanda', 'Monsieur', '991-149 Erat Rd.', 82135, 'Ajaccio', 346837362, 'Limoges', '413620260306285', 2),
(90, 'Roggeveen', 'Carissa', 'Monsieur', '216-6497 Diam St.', 77857, 'Moulins', 636651588, 'Mâcon', '868523218096154', 5),
(91, 'Bezuindenhout', 'Christen', 'Monsieur', 'Ap #510-3731 Tincidunt Rd.', 15272, 'Vichy', -65951080, 'Cannes', '454721532469463', 8),
(92, 'Fontaine', 'Hakeem', 'Monsieur', 'Ap #956-6216 Sem St.', 40691, 'Haguenau', 104183696, 'Limoges', '869887918662031', 13),
(93, 'Neuville', 'Winifred', 'Madame', '649-9144 Eros. Rd.', 65894, 'Pontarlier', -49274042, 'Bastia', '727023172629047', 3),
(94, 'Achthoven', 'Lars', 'Monsieur', '5625 Et Street', 84506, 'Alès', 223566284, 'Lens', '744319892636921', 7),
(95, 'Beaulieu', 'Harper', 'Madame', 'Ap #487-2710 Lobortis Rd.', 35168, 'Mâcon', -4784183, 'Anglet', '470263408813717', 14),
(96, 'Marchand', 'Desiree', 'Monsieur', 'Ap #707-957 Vehicula Av.', 54041, 'Rodez', 374382683, 'Châlons-en-Champagne', '483118184684336', 13),
(97, 'Haak', 'Wayne', 'Madame', 'P.O. Box 614, 4379 Nulla. St.', 33425, 'Poitiers', 524403035, 'Brive-la-Gaillarde', '117663021151287', 5),
(98, 'Kappel', 'Alexis', 'Madame', '716-583 Semper Ave', 3336, 'Évreux', 374713954, 'Ajaccio', '452415886440283', 4),
(99, 'Geelen', 'Laurel', 'Monsieur', '990-525 Purus St.', 11587, 'Le Havre', -114433461, 'Reims', '485047484276252', 8),
(100, 'Poulin', 'Geraldine', 'Monsieur', '897-475 Dui. Ave', 18331, 'Perpignan', 233772356, 'Brive-la-Gaillarde', '481078733666542', 18),
(101, 'Dumont', 'Anthony', 'Madame', 'Ap #504-5658 Orci, Av.', 64972, 'Tourcoing', 692527939, 'Ajaccio', '126282461457487', 16),
(102, 'Klein', 'Alexa', 'Madame', 'P.O. Box 809, 1806 Bibendum Rd.', 33976, 'Cannes', 151650024, 'Brive-la-Gaillarde', '054219243838596', 9),
(103, 'Hoedemaker', 'Samson', 'Madame', 'P.O. Box 404, 557 A Avenue', 80536, 'Montauban', 35104673, 'Pontarlier', '312339442856156', 7),
(104, 'Bouwmeester', 'Herrod', 'Madame', 'Ap #727-3250 Proin St.', 76956, 'Mâcon', 147617112, 'Lunel', '562636468745769', 9),
(105, 'Offermans', 'Neve', 'Monsieur', '180 In, Ave', 52878, 'Mérignac', 560293312, 'Rouen', '716138112731017', 14),
(106, 'Tremble', 'Amy', 'Madame', '8180 Aliquet. Road', 75153, 'Brive-la-Gaillarde', 659955860, 'Moulins', '326565487816458', 5),
(107, 'Fabre', 'Karina', 'Monsieur', 'Ap #465-4086 Sed Avenue', 65536, 'Bordeaux', 221472023, 'Mâcon', '796716567057613', 15),
(108, 'Berg', 'Kareem', 'Madame', '8158 Eu, St.', 37723, 'Auxerre', 100700078, 'Nevers', '746333538151497', 17);

-- --------------------------------------------------------

--
-- Structure de la table `rendezvous`
--

DROP TABLE IF EXISTS `rendezvous`;
CREATE TABLE IF NOT EXISTS `rendezvous` (
  `id_medecin` int(11) NOT NULL,
  `dateheure` bigint(20) NOT NULL,
  `duree` bigint(20) DEFAULT '0',
  `id_patient` int(11) NOT NULL,
  PRIMARY KEY (`id_medecin`,`dateheure`),
  KEY `Id_Patient` (`id_patient`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `rendezvous`
--

INSERT INTO `rendezvous` (`id_medecin`, `dateheure`, `duree`, `id_patient`) VALUES
(9, 1649505600, 1800, 62),
(4, 1649865600, 900, 52),
(9, 1649512800, 1800, 62),
(7, 1650533400, 1800, 94),
(3, 1651251600, 1800, 67),
(15, 1650963600, 1800, 2),
(13, 1649401200, 1800, 43),
(7, 1649934000, 1800, 11),
(8, 1649160000, 900, 91),
(18, 1649953800, 1800, 34),
(9, 1650898800, 1800, 102);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
