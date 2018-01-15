<?php /* menuutilisateur.php */
session_start();

if (!isset($_SESSION['security_level']) OR $_SESSION['security_level'] == 1 OR $_SESSION['security_level'] == 5)
{
	header("Location:index.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />

        <link rel="stylesheet" href="assets/css/main.css" />
        <title>Menu admin</title>
		
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
			  //alert('probleme');
			  surligne(arg, true);
			  return false;
		   }
		   else
		   {
			  //alert('pas de probleme');
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
			  surligne(arg, true);
			  return false;
		   }
		   else
		   {
			  if (MotDePasse1.value == '' || MotDePasse2.value == '')
			  {
				surligne(arg, false);
				return true;
			  }
			  if (MotDePasse1.value != MotDePasse2.value) 
			  {
				alert('Veuillez faire correspondre votre mot de passe avec la vérification');
				surligne(arg, true);
				return false;
			  }
			  if(MotDePasse1.value == MotDePasse2.value)
			  {
					surligne(arg, false);
					return true;
			  }
		    }
		}
		
		function VerificationSecuriteLevel(arg)
		{
			var SecuriteLevelOk = document.getElementById("securite");
			
			if((SecuriteLevelOk.value == 5) || (SecuriteLevelOk.value == 10))
			{
				surligne(arg, false);
				return true;
			}
			else
			{
				surligne(arg, true);
				return false;
			}
		}
		
		function VerificationForm(f)
		{
		   var MailOk = VerificationMail(document.getElementById("mail"));
		   var SecuriteLevelOk = VerificationSecuriteLevel(document.getElementById("securite"));
		   
		   if(MailOk && SecuriteLevelOk)
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
		
		function VerificationForm2(f)
		{
		   var Mdp1Ok = VerificationMdp(document.getElementById("mdp1"));
		   var Mdp2Ok = VerificationMdp(document.getElementById("mdp2"));
		   
		   if(Mdp1Ok && Mdp2Ok)
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
	

	<?php
	
	if (isset($_SESSION['codemenuadmin']))
		{
			$cas = ($_SESSION['codemenuadmin']);
			switch($cas)
			{
				case '1': 
				    ?><script> alert('L\'utilisateur a bien été supprimé') </script>
					<br/> <?php echo '<p style="text-align: center;">L\'utilisateur a bien été supprimé</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '2': 
				    ?><script> alert('Impossible de supprimer le dernier administrateur') </script>
					<br/> <?php echo '<p style="text-align: center;">Au moins un administrateur doit être présent dans la base de données</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '3': 
				    ?><script> alert('Seul un administrateur peut supprimer un utilisateur') </script>
					<br/> <?php echo '<p style="text-align: center;">Seul un administrateur peut supprimer un utilisateur</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '4': 
				    ?><script> alert('La date n\'est pas valide') </script>
					<br/> <?php echo '<p style="text-align: center;">La date n\'est pas valide</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '5': 
				    ?><script> alert('Le format de la date n\'est pas valide') </script>
					<br/> <?php echo '<p style="text-align: center;">Veuillez entrer une date au format US : YYYY-MM-DD</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '6': 
				    ?><script> alert('Les informations ont bien été mis à jours') </script>
					<br/> <?php echo '<p style="text-align: center;">Les informations ont bien été mis à jours</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '7': 
				    ?><script> alert('Le mail est déjà utilisé par un autre utilisateur') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mail est déjà utilisé par un autre utilisateur</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '8': 
				    ?><script> alert('Le mot de passe a bien été changé') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mot de passe a bien été changé</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				case '9': 
				    ?><script> alert('Le mot de passe n\'est pas correct') </script>
					<br/> <?php echo '<p style="text-align: center;">Le mot de passe n\'est pas correct</p>';
					$_SESSION['codemenuadmin'] = 0;
					break;
				default:
				break;
			}
	}
	
	
	$bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	$requete = $bdd->prepare('SELECT * FROM membres ORDER BY login ASC'); //WHERE login = :login
	$requete->execute(array('login' => $_SESSION['login']));
	?>
	<?php 
		if (isset($_GET['codeadmin']))
		{
			if ($_GET['codeadmin'] == 2)
			{
				echo ("Problème");
			}
		}	
	?>
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
                <li class="active"><a href="index.php">Articles</a></li>
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
                    <li><a href="menuutilisateur.php">Profil</a></li>
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
            <div id="FormulaireUserAdmin">
                <form name=formupdateutilisateurs action="menuadminverification.php" method="post">
                    <table class="FormulaireCentrer">
                        <caption>Informations concernant les utilisateurs du site :</caption> <br/>

                        <tr>
                            <th>Login</th>
                            <th>Mot de passe</th>
                            <th>Mail</th>
                            <th>Date de naissance</th>
                            <th>Security_Level</th>
                        </tr>

                        <?php

                        while ($donnees = $requete->fetch())
                        {
                            ?>
                            <tr>
                                <td> <?php echo $donnees['login'] ?></td>
                                <td> <?php echo ("************") ?> </td>
                                <td> <?php echo $donnees['e_mail'] ?> </td>
                                <td> <?php echo $donnees['date_naissance'] ?> </td>
                                <td> <?php echo $donnees['security_level'] ?> </td>
                            </tr>
                            <?php
                        } ?>
                        <?php
                        $requete->closeCursor();
                        ?>
                    </table>
                </form>
            </div>

            <br/>

            <?php
            if(isset($_POST['utilisateurs']))
            {
                $users = $_POST['utilisateurs'];
            }
            else
            {
                $users = $_SESSION['login'];
            }
            ?>

            <?php
            $requete = $bdd->prepare('SELECT * FROM membres Where login = :login');
            $requete->execute(array( 'login' => $users));
            ?>
            <div id="InfosUsers">
                <form name='form2' ACTION= "menuutilisateurverification.php"  METHOD="post" onsubmit="return VerificationForm(this)">
                        <?php
                        while ($donnees = $requete->fetch())
                        {
                            $login = $donnees['login'];
                            ?>

                            <input type="hidden" value = "<?php  echo $users; ?>" name="texte_login" />
                            <label for="login">Login : </label>
                            <input type="text" name="login" size="25" value="<?php echo $donnees['login'] ?>"readonly/>


                             <label for="email"> E-mail à changer:</label>
                            <input type="text" id="mail" name="texte_mail"  size="41"  value="<?php echo $donnees['e_mail']; ?>" onblur="VerificationMail(this)" /> <br/> <br/>


                            <label for="date">Date de naissance à changer:</label>
                            <input type="date" name="texte_date_de_naissance"  size="41" value="<?php echo $donnees['date_naissance']; ?>"/> <br/> <br/>

                            <label for="number"> Niveau de sécurité à changer:</label>
                            <select name ="texte_niveau_de_securite">
                                <option value="<?php echo $donnees['security_level']; ?>"onblur="VerificationSecuriteLevel(this)">5</option>
                                <option value="<?php echo $donnees['security_level']; ?>"onblur="VerificationSecuriteLevel(this)">10</option>
                            </select>
                           <input type="number" id="securite" name="texte_niveau_de_securite"  size="41" value="<?php echo $donnees['security_level']; ?>" onblur="VerificationSecuriteLevel(this)"/> <br/> <br/>
                            <?php
                        }
                        $requete->closeCursor();
                        ?>

                    <input type="submit" value="Mettre à jour les informations" class="Envoyer">
                </form>
            </div>


            <div id="InfosMdp">
                <form name='formupdatemdputilisateur' method="post" action="menuutilisateurmdp.php" onsubmit="return VerificationForm2(this)">

                    <input type="hidden" value = "<?php  echo $users; ?>" name="txt_pseudo" >
                    <label for="mdp">Mot de passe à changer : </label>
                    <input name="texte_mot_de_passe" id="mdp1" size=25 type="password"  onblur="VerificationMdp(this)"  /> <br/> <br/>
                    <label for="mdpconf">Confirmation : </label>
                    <input name="texte_mot_de_passe_confirmation" id="mdp2" size=25 type="password" onblur="VerificationMdp(this)" /> <br/> <br/>

                    <input type="submit" value="Mettre à jour le mot de passe" class="Envoyer" />
                </form>
            </div>

            <br/>

            <div id="InfosChargement">
                <form name='form3' ACTION= "menuadmin.php"  METHOD="post">
                    <select name ="utilisateurs">
                        <?php
                        $requete = $bdd->query('select * from membres');
                        while ($donnees = $requete->fetch())
                        {
                            ?> <option value ="<?php echo $donnees['login'] ?>"> <?php echo $donnees['login'] ?> </option> <?php
                        }
                        ?>
                    </select>

                    <INPUT TYPE="submit" value="Charger un utilisateur">
                    <?php $requete->closeCursor(); ?>
                </form>
            </div>


            <div id="InfosSuppression">
                <form name='formsupr' action= "SupprimerUtilisateur.php"  method="post">

                    <input type="hidden" value="<?php echo $login ?>" name="utilisateurasupprimer">
                    <label>Mot de passe admin:</label> <input type="password" name="texte_confirmation_mot_de_passe" size=12  required/></br>
                    <input type="submit" value="Supprimer l'utilisateur" class="Envoyer"/>
                </form>
            </div>



        </div>


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
					
	
					