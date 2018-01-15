<?php
/* inscriptionconfirmation.php */
session_start();

	$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)); 
	$login=htmlspecialchars($_POST['texte_login'], ENT_QUOTES); 
	$motdepasse=htmlspecialchars($_POST['texte_motdepasse'], ENT_QUOTES);
	$motdepasseconfirmation=htmlspecialchars($_POST['texte_confirmationmotdepasse'], ENT_QUOTES);
	$mail=htmlspecialchars($_POST['texte_mail'], ENT_QUOTES);
	$datenaissance = htmlspecialchars($_POST['texte_datedenaissance'],ENT_QUOTES);
	$securelvl = 5;
    
	// Vérification de la date : Précise le format YYYY/MM/DD
    $date1 = date('Y-m-d', time()); // Récupère la date actuelle
    $date2 = date('Y-m-d',strtotime($datenaissance)); // Utilise la date entrée par l'utilisateur
    //Découpe le string de la date pour pouvoir la tester
	// On va pouvoir utiliser la fonction checkdate de PHP pour tester si la date est valide
    $test_arr  = explode('-', $datenaissance); // le délimiteur est mis ici à '/' à changer selon le format
    if (count($test_arr) == 3) // Vérifie qu'on a bien récupéré 3 éléments
	{
		// Utilise checkdate de PHP pour tester la validité de la date, en plus on compare les deux dates pour voir si la date actuelle est bien supérieure (on ne nait pas dans le futur)
        if (checkdate($test_arr[1], $test_arr[2], $test_arr[0]) && $date1 > $date2) 
		{

        } 
		else // Date non valide
		{
			$_SESSION['code'] = 10;
			header("Location: inscription.php");
			exit;
        }
    } 
	else // Format de date non valide
	{
		$_SESSION['code'] = 11;
		header("Location: inscription.php");
		exit;
    }
	
	if ($motdepasse == $motdepasseconfirmation)
	{
		// Si preg_match retourne 1 alors c'est vrai, 0 si faux
		$TestLogin = (preg_match("^[a-z]{1,50}$^",$login)); 
		$TestMotDePasse = (preg_match("^[a-zA-Z0-9]{8,16}$^",$motdepasse));
		$TestMail = (preg_match("/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/",$mail));
		
		if(($TestLogin == 0) AND ($TestMotDePasse == 0))
		{
			$_SESSION['code'] = 5;
			header("Location: inscription.php");
			exit;
		}
		
		if($TestLogin == 0)
		{
			$_SESSION['code'] = 6;
			header("Location: inscription.php");
			exit;
		}
		
		if($TestMotDePasse == 0)
		{
			$_SESSION['code'] = 7;
			header("Location: inscription.php");
			exit;
		}
		
		if($TestMail == 0)
		{
			$_SESSION['code'] = 9;
			header("Location: inscription.php");
			exit;
		}
		
		if(($TestLogin == 1) AND ($TestMotDePasse == 1) AND ($TestMail == 1))
		{
			$motdepasse=sha1($_POST['texte_motdepasse']); // On hash le mot de passe une fois sûr qu'il correspond aux critères
			
			$proStock = $bdd->prepare("CALL AjouterUser(:pseudo, :mdp, :mail, :naiss, :secure, @reponse);");
	
			$proStock->bindParam(':pseudo', $login);
			$proStock->bindParam(':mdp', $motdepasse);
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
				$_SESSION['login'] = $login;
				$_SESSION['security_level'] = $securelvl;
				$_SESSION['code'] = 1;
				header("Location: index.php");
				exit;
			}
			elseif ($out == 2)
			{
				$_SESSION['code'] = 2;
				header("Location: inscription.php");
				exit;
			}
			elseif ($out == 3)
			{
				$_SESSION['code'] = 3;
				header("Location: inscription.php");
				exit;
			}
			elseif ($out == 4)
			{
				$_SESSION['code'] = 4;
				header("Location: inscription.php?code=4");
				exit;
			}
		}
	}
	else
	{
		$_SESSION['code'] = 8;
		header("Location: inscription.php");
		exit;
	}
	?>

