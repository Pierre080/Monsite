<?php
/* menuutilisateurmdp.php */

session_start();

	$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));  
	$motdepasse=sha1($_POST['texte_mot_de_passe']);
	$motdepasseconf=sha1($_POST['texte_mot_de_passe_confirmation']);
	
	if ($_SESSION['security_level']==10)
	{
			$login = $_POST['txt_pseudo'];
	}
	else {$login = $_SESSION['login'];}
	
	//$login = $_POST['txt_pseudo']; // $_SESSION['login'];
	/*if ($_SESSION['security_level']==10)
	{
			$login = $_POST['txt_pseudo'];
			Il faut que tu hash le mot de passe de ton utilisateur, 
			tu le stockes dans la bdd et lors de l'inscription du compare
			le mot de passe rentré hashé avec le mot de passe stocké dans la bdd.
	}
	else {$login = $_SESSION['login'];}*/
	
	if ($motdepasse == $motdepasseconf)
	{
		
		
		$proStock = $bdd->prepare("CALL ModifierMotDePasse(:pseudo, :mdp, @reponse);");
		$proStock->bindParam(':pseudo', $login);
		$proStock->bindParam(':mdp', $motdepasse);
		$proStock->execute();	
		$sortie = $bdd->prepare("SELECT @reponse");
		$sortie->execute();
		$G = $sortie->fetch(PDO::FETCH_ASSOC) ;
		$out = $G["@reponse"];
		
		if ($out == 1)
		{
			if ($_SESSION['security_level'] == 10)
			{
				$_SESSION['codemenuadmin'] = 8;
				header("Location: menuadmin.php");
				exit;
			}
			else
			{
				$_SESSION['codemenu'] = 5;
				header("Location: menuutilisateur.php");
				exit;
			}
		}
		else
		{
			if ($_SESSION['security_level'] == 10)
			{
				$_SESSION['codemenuadmin'] = 9;
				header("Location: menuadmin.php");
				exit;
			}
			else
			{
				$_SESSION['codemenu'] = 6;
				header("Location: menuutilisateur.php");
				exit;
			}
			
		}
	}
	else
	{
		if ($_SESSION['security_level'] == 10)
			{
				header("Location: menuadmin.php");
				exit;
			}
		header("Location: menuutilisateur.php");
		exit;
	}
	

?>
