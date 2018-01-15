-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Mar 29 Août 2017 à 08:53
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `monsite`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `AjouterUser` (IN `pseudo` VARCHAR(50), IN `mdp` VARCHAR(50), IN `mail` VARCHAR(100), IN `naiss` DATE, IN `secure` INT(2), OUT `reponse` INT(1))  NO SQL
BEGIN
	DECLARE VariablePseudo, VariableMail int;
    	SELECT COUNT(login) INTO VariablePseudo FROM membres WHERE login = pseudo;
    	SELECT COUNT(e_mail) INTO VariableMail FROM membres WHERE e_mail = mail;
      
    IF (VariablePseudo > 0 AND VariableMail >0)
    	THEN SELECT 4 INTO reponse;
        
    ELSEIF VariablePseudo > 0 
    	THEN SELECT 2 INTO reponse;
        
    ELSEIF VariableMail > 0 
    	THEN SELECT 3 INTO reponse;
    
	ELSE 
    	INSERT INTO membres VALUES (pseudo, mdp, mail, naiss, secure);
        SELECT 1 INTO reponse;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ModifierMotDePasse` (IN `pseudo` VARCHAR(50), IN `mdp` VARCHAR(50), OUT `reponse` INT(1))  NO SQL
BEGIN
	UPDATE membres SET mot_de_passe = mdp WHERE login = pseudo;
    SELECT 1 INTO reponse;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `ModifierUser` (IN `pseudo` VARCHAR(50), IN `mail` VARCHAR(100), IN `naiss` DATE, IN `secure` INT(2), OUT `reponse` INT(1))  NO SQL
BEGIN 
DECLARE VariableMail int;
    	SELECT COUNT(e_mail) INTO VariableMail FROM membres WHERE e_mail = mail AND login != pseudo;
        
   IF VariableMail > 0 
    	THEN SELECT 2 INTO reponse;    
	ELSE 
    	UPDATE membres SET e_mail = mail, date_naissance = naiss, security_level = secure where login = pseudo;
        SELECT 1 INTO reponse;
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `SupprimerUser` (IN `admin` VARCHAR(50), IN `mdp` VARCHAR(50), IN `userasuppr` VARCHAR(50), IN `secure` INT(2), OUT `reponse` INT(1))  NO SQL
BEGIN
	DECLARE VerificationAdmin int;
    DECLARE CheckSecure int;
    
    SELECT (security_level) INTO VerificationAdmin FROM membres WHERE login = admin AND mot_de_passe = mdp;
    
    SELECT COUNT(security_level) INTO CheckSecure FROM membres WHERE  security_level = secure AND login != admin;
        
    IF CheckSecure != 1 
    	THEN SELECT 2 INTO reponse;    
    ELSEIF VerificationAdmin != 10 
    	THEN SELECT 3 INTO reponse;
    ELSE 
    	DELETE FROM membres WHERE login = userasuppr;
        SELECT 1 INTO reponse;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `login` varchar(50) NOT NULL,
  `mot_de_passe` varchar(50) NOT NULL,
  `e_mail` varchar(100) NOT NULL,
  `date_naissance` date NOT NULL,
  `security_level` int(2) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `membres`
--

INSERT INTO `membres` (`login`, `mot_de_passe`, `e_mail`, `date_naissance`, `security_level`) VALUES
('azerty', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'test@test.testte', '1993-08-03', 5),
('f', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'f@test.gg', '1993-08-12', 5),
('admin', '345120426285ff8b1d43653a4d078170b4761f75', 'admin@gmail.com', '1993-08-03', 10),
('test', 'f7c3bc1d808e04732adf679965ccc34ca7ae3441', 'test@test.fr', '1999-12-12', 5),
('a', '287263ec9a8790c6265a140c3109a23f806acb4e', 'a@a.aa', '1999-02-04', 5);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`login`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
