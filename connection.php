<?php
/* connexion */
session_start(); // on va enregistrer le pseudo et le securtiy level
	
	$login = htmlspecialchars($_POST['texte_login'], ENT_QUOTES); // il va aller chercher le txt pseudo de la page précédente comme pour le mdp
	$motdepasse = htmlspecialchars(sha1($_POST['texte_mot_de_passe']), ENT_QUOTES); // sha1 pour le hash
	 
	try 
	{
		$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8', 'root', ''); // creer une instance ou je mets l ouverture de la bdd
	}
	catch(Exception $e)
	{
        die('Erreur : '.$e->getMessage());
	}
	$requete = $bdd->prepare("SELECT login, security_level FROM membres WHERE login = :login AND mot_de_passe = :mot_de_passe"); // variable requete j appelle ma bdd je fais une requete prepare ou je fais ce que je veux dedans . :pseudo = valeur qu on aura plus loin
	$requete->execute(array('login'=>$login,'mot_de_passe'=>$motdepasse)); // je vais chercher pseudo fleche variable pseudo et mdp pseudo = nom de la bdd comme mdp et après la fleche c est la variable déclaré plus haut . je vérifie si j ai des donnéées dans ma requete si c est le cas dans variable session pseudo elle va devenir la variable donnée du pseudo et pur le security level idem
	
	if ($donnees = $requete->fetch())
	{
		$_SESSION['login'] = $donnees['login'];
		$_SESSION['security_level'] = $donnees['security_level'];	
		$_SESSION['reussite'] = 1;
		header("Location: index.php");
		exit;		
	}
	else 
	{ 
		$_SESSION['erreur'] = 1;
		header("Location: index.php");
		exit;
	}
	$requete->closeCursor();	
?>