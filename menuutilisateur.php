<?php /* menuutilisateur.php */
session_start();

if (!isset($_SESSION['security_level']) OR $_SESSION['security_level'] == 1)
{
	header("Location:index.php");
	exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="assets/css/main.css" />
        <title>Menu utilisateur</title>
		<script>
		function surligne(champ, erreur)
		{
		   if(erreur)
		   {
			  champ.style.backgroundColor = "#fba";
		   }
			    
		   else
		   {
			  champ.style.backgroundColor = "";
		   }
		}
		 function VerificationMail(arg)
		{
		   var emailRegex = new RegExp("^([a-z0-9_\\.-]+)@([\\da-z\\.-]+)\\.([a-z\\.]{2,6})$");
		   
		   if(!emailRegex.test(arg.value))
		   {
			  surligne(arg, true);
			  return false;
		   }
		   else
		   {
			  surligne(arg, false);
			  return true;
		   }
		}

		function VerificationLogin(arg)
		{
			var loginRegex = new RegExp("^[a-z]{1,50}$");
			
			if(!loginRegex.test(arg.value))
		   {
			  surligne(arg, true);
			  return false;
		   }
		   else
		   {
			  surligne(arg, false);
			  return true;
		   }
		}

		function VerificationMdp(arg)
		{
		   var mdpRegex = new RegExp("^[a-zA-Z0-9]{8,16}$");
		   var MotDePasse1 = document.getElementById("mdp1");
		   var MotDePasse2 = document.getElementById("mdp2");
	
		   if(!mdpRegex.test(arg.value))
		   {
			   //alert('probleme');
			  surligne(arg, true);
			  return false;
		   }
		   else
		   {
			  if (MotDePasse1.value == '' || MotDePasse2.value == '')
			  {
				alert('Veuillez remplir les deux champs');
				surligne(arg, false);
				return false;
			  }
			  if (MotDePasse1.value != MotDePasse2.value) 
			  {
				alert('Veuillez faire correspondre votre mot de passe avec la vérification');
				surligne(arg, true);
				return false;
			  }
			  if(MotDePasse1.value == MotDePasse2.value)
			  {
				  //alert('c est bon');
					surligne(arg, false);
					return true;
			  }
		    }
		}
		

		function VerificationForm(f)
		{
		   var MailOk = VerificationMail(document.getElementById("mail"));
		   
		   if(MailOk)
		   {
			   //alert("Ok");
			   return true;
		   }      
		   else
		   {
			  alert("Veuillez remplir correctement tous les champs");
			  return false;
		   }
		}
		</script>
	</head>

    <body class="is-loading">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">

        <!-- Intro -->
        <div id="intro">
            <h1>Pierre Blavier<br />
                Photography</h1>
            <p>Landscape, portrait and event photographer </a>.</p>
            <ul class="actions">
                <li><a href="#header" class="button icon solo fa-arrow-down scrolly">Continue</a></li>
            </ul>
        </div>

        <!-- Header -->
        <header id="header">
            <a href="index.php" class="logo">P.B.Photography</a>
        </header>

        <!-- Nav -->
        <nav id="nav">
            <ul class="links">
                <li class="active"><a href="menuutilisateur.php">Profil</a></li>
                <?php
                if (isset($_SESSION['security_level']))
                {
                if($_SESSION['security_level'] == 1)
                {?>
                    <li><a href="inscription.php">Inscription</a></li>
                    <?php
                if (!isset($_SESSION['security_level']) OR ($_SESSION['security_level'] == 1)) // Si personne n'est connecté ou que l'on est en anonyme, on procède à la suite du code
                {?>
                    <li><a href="membres.php">Membres inscrits</a></li>

                    <?php
                }
                    ?>
                    <?php
                }
                if($_SESSION['security_level'] == 5)
                {?>
                    <li><a href="index.php">Articles</a></li>
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                    <?php
                }
                if($_SESSION['security_level'] == 1 OR ($_SESSION['security_level'] == 5) OR ($_SESSION['security_level'] == 10))
                {?>

                    <li><a href="diapo.php">Galerie</a></li>
                    <li><a href="http://localhost:3000">Chat</a></li>
                    <?php
                }
                if($_SESSION['security_level'] == 10)
                {?>
                    <li><a href="menuadmin.php">Profil Admin</a></li>
                    <li><a href="deconnexion.php">Deconnexion</a></li>
                <?php
                }

                }
                else
                {
                if (!isset($_SESSION['security_level']))
                {?>
                    <script> alert('Vous vous êtes bien déconnecté') </script>
                    <li><a href="inscription.php">Inscription</a></li>
                    <li><a href="membres.php">Membres inscrits</a></li>
                    <?php
                }
                }?>

            </ul>
            <ul class="icons">
                <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon fa-github"><span class="label">GitHub</span></a></li>
            </ul>
        </nav>

        <!-- Main -->
        <div id="main">
	<?php 
	$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$requete = $bdd->prepare('SELECT * FROM membres WHERE login = :login');
	$requete->execute(array('login' => $_SESSION['login']));
	?>
	
	<div id="modificationmaildateformulaire">

        <h2>Modification de vos informations personnel :</h2><br/>

	<form name=formupdateutilisateur action="menuutilisateurverification.php" method="post" onsubmit="return VerificationForm(this)"> 
			<?php 
			while ($donnees = $requete->fetch())
			{
			?>
                <label for="login">Login : </label>
                <input type="text" name="login" size="25" value="<?php echo $donnees['login'] ?>"readonly /> <br/><br/>

				
				<label for="email">Votre e-mail à changer:</label>
				<input type="text" id="mail" name="texte_mail"  size="41" onblur="VerificationMail(this)" value="<?php echo $donnees['e_mail']; ?>" /> <br/> <br/>
			    
				<label for="date">Votre date de naissance:</label>
				<input type="date" name="texte_date_de_naissance"  size="41" value="<?php echo $donnees['date_naissance']; ?>" /> <br/> <br/>
				
			<?php
			}
			$requete->closeCursor();
			?>
		<input type="submit" value="Modification paramètres" class="ModifParam"/>
	</form>
	</div>

	</br>
	<?php 
		
	
	if (isset($_SESSION['codemenu']))
		{
			$cas = ($_SESSION['codemenu']);
			switch($cas)
			{
				case '1': 
				    ?><script> alert('Le mail a bien été mis à jour') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mail a bien été mis à jour</p>';
					$_SESSION['codemenu'] = 0;
					break;
				case '2':
					?> <script> alert('Le mail est déjà enregistré') </script> <?php
					echo '<p style="text-align: center;">Le mail est déjà enregistré, veuillez en choisir un autre</p>';
					$_SESSION['codemenu'] = 0;
					break;
				case '3': 
				    ?><script> alert('La date n\'est pas valide') </script>
					<br/> <?php echo '<p style="text-align: center;">Vous avez entré une date invalide</p>';
					$_SESSION['codemenu'] = 0;
					break;
				case '4': 
				    ?><script> alert('Le format de la date ne respecte pas la norme US') </script>
					<br/> <?php echo '<p style="text-align: center;">Veuillez respecter le format US : YYYY/MM/DD</p>';
					$_SESSION['codemenu'] = 0;
					break;
				case '5': 
				    ?><script> alert('Le mot de passe a bien été changé') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mot de passe a bien été changé</p>';
					$_SESSION['codemenu'] = 0;
					break;
				case '6': 
				    ?><script> alert('Le mot de passe n\a pas été changé') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mot de passe n\a pas été changé</p>';
					$_SESSION['codemenu'] = 0;
					break;
				default:
				break;
			}
	}
	?>
	</br>
	</br>
	<div id="modificationmdpformulaire">
		<form name=formupdatemdputilisateur action="menuutilisateurmdp.php" method="post" onsubmit="return VerificationMdp(this)">
			<label for="motdepasse">Votre mot de passe:</label>
			<input type="password" id="mdp1" name="texte_mot_de_passe"  maxlength="16"  placeholder="Mot de passe: 8 à 16 caractères [a-zA-Z-0-9]" size="41" onblur="VerificationMdp(this)"/> <br/> <br/>
			
			<label for="motdepasse">Confirmation mot de passe:</label>
			<input type="password" id="mdp2" name="texte_mot_de_passe_confirmation"  placeholder="Confirmation du mot de passe" size="41" maxlength="16" onblur="VerificationMdp(this)"/> <br/> <br/>
				
		<input type="submit" value="Modification mot de passe" class="ModifMdp"/> <br/> <br/>
	</form>
	</div>
        </div>
	</body>

    <!-- Copyright -->
    <div id="copyright">
        <ul><li>&copy; Pierre Blavier</li></ul>
    </div>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

    </body>
					
</html>
					