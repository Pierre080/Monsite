<?php
/*
 * SupprimerUtilisateur.php
 */
session_start();

//$motdepasse = htmlspecialchars(sha1($_POST['texte_confirmation_mot_de_passe'], ENT_QUOTES));
$motdepasse = sha1($_POST['texte_confirmation_mot_de_passe']);
$utilisateurasupprimer = $_POST['utilisateurasupprimer'];
//$utilisateurasupprimer = htmlspecialchars($_POST['utilisateurasupprimer'], ENT_QUOTES);
$secure = 10;
echo $motdepasse;
$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8', 'root', '');

$requete = $bdd->prepare('SELECT mot_de_passe FROM membres Where login = :login');
		$requete->execute(array(
			'login' => $_SESSION['login']
			));
			
while ($donnees = $requete->fetch())
{					
	if ($donnees['mot_de_passe'] != $motdepasse)
	{
//echo $_SESSION['login'];
		$_SESSION['codemenuadmin'] = 9;
		header("Location: menuadmin.php");
		exit;
	}			
	else
	{
		$proStock = $bdd->prepare("CALL SupprimerUser(:admin, :mdp, :userasuppr, :secure, @reponse);");
	
		$proStock->bindParam(':admin', $_SESSION['login']);
		$proStock->bindParam(':mdp', $motdepasse);
		$proStock->bindParam(':userasuppr', $utilisateurasupprimer); 
		$proStock->bindParam(':secure', $secure); 
		
		$proStock->execute();
						
		$sortie = $bdd->prepare("SELECT @reponse");
		$sortie->execute();
		$G = $sortie->fetch(PDO::FETCH_ASSOC);

		$out = $G["@reponse"];
		
		if ($out == 1)
		{
			$_SESSION['codemenuadmin'] = 1;
			header("Location: menuadmin.php");
			exit;
		}
		if ($out == 2)
		{
			$_SESSION['codemenuadmin'] = 2;
			header("Location: menuadmin.php");
			exit;
		}
		if ($out == 3)
		{
			$_SESSION['codemenuadmin'] = 3;
			header("Location: menuadmin.php");
			exit;
		}
	}
}
?>
