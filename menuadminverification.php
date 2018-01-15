<?php
/*
 * menuutilisateurverification.php 
 */
session_start();

	$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));	
	// *****  POST des valeurs a ajouter *****  
	$login=$_SESSION['login'];
	$mail=$_POST['e_mail'];
	$datenaissance = $_POST['date_naissance'];
	$securelvl = 5;
	
	// Vérification de la date : Précise le format YYYY/MM/DD
    $date1 = date('Y/m/d', time()); // Récupère la date actuelle
    $date2 = date('Y/m/d',strtotime($datenaissance)); // Utilise la date entrée par l'utilisateur
    //Découpe le string de la date pour pouvoir la tester
	// On va pouvoir utiliser la fonction checkdate de PHP pour tester si la date est valide
    $test_arr  = explode('/', $datenaissance); // le délimiteur est mis ici à '/' à changer selon le format
    if (count($test_arr) == 3) // Vérifie qu'on a bien récupéré 3 éléments
	{
		// Utilise checkdate de PHP pour tester la validité de la date, en plus on compare les deux dates pour voir si la date actuelle est bien supérieure (on ne nait pas dans le futur)
        if (checkdate($test_arr[1], $test_arr[2], $test_arr[0]) && $date1 > $date2) 
		{

        } 
		else // Date non valide
		{
			$_SESSION['codeadmin'] = 3;
			header("Location: menuadmin.php");
			exit;
        }
    } 
	else // Format de date non valide
	{
		$_SESSION['codeadmin'] = 4;
		header("Location: menuadmin.php");
		exit;
    }
	/*if ($_SESSION['security_level'] ==10)
	{
			$login = $_POST['texte_login'];
	}
	else 
	{
		$login = $_SESSION['login'];
	}*/
	
		$proStock = $bdd->prepare("CALL ModifierUser(:pseudo, :mail, :naiss, :secure, @reponse);");
	
		$proStock->bindParam(':pseudo', $login);
		$proStock->bindParam(':mail', $mail);
		$proStock->bindParam(':naiss', $datenaissance);
		$proStock->bindParam(':secure', $securelvl);
	
		$proStock->execute();
	
		$sortie = $bdd->prepare("SELECT @reponse");
		$sortie->execute();
		$G = $sortie->fetch(PDO::FETCH_ASSOC) ;
		
		$out = $G["@reponse"];
		
		
		if ($out == 1)
		{
			$_SESSION['codeadmin'] = 1;
			header("Location: menuadmin.php");
			exit;
		}
		elseif ($out == 2)
		{
			$_SESSION['codeadmin'] = 2;
			header("Location: menuadmin.php");
			exit;
		}
		
			
	 
	
	?>

