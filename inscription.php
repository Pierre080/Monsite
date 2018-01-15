<?php
/*inscription*/
session_start();
ini_set('display_errors','off');
$login = $_POST['texte_login'];
$motdepasse = $_POST['texte_mot_de_passe'];
$email = $_POST['texte_mail'];

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />

    <link rel="stylesheet" href="assets/css/main.css" />
    <title>Inscription</title>
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


        function VerificationForm(f)
        {
            var LoginOk = VerificationLogin(document.getElementById("login"));
            var MailOk = VerificationMail(document.getElementById("mail"));
            var Mdp1Ok = VerificationMdp(document.getElementById("mdp1"));
            var Mdp2Ok = VerificationMdp(document.getElementById("mdp2"));
            if(LoginOk && MailOk && Mdp1Ok && Mdp2Ok)
            {
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
            <li class="active"><a href=inscription.php">Inscription</a></li>
            <?php
            if (isset($_SESSION['security_level']))
            {
            if($_SESSION['security_level'] == 1)
            {?>
                <li><a href="inscription.php">Articles</a></li>
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

        <div id="inscriptionformulaire">
            <h2>
                Inscrivez-vous !
            </h2><br/>
            <form name="inscriptionformulaire" onsubmit="return VerificationForm(this)" method="post" action="inscriptionconfirmation.php" >
                <p>
                    <label for="login">Votre pseudo:</label>
                    <input type="text" id="login" name="texte_login" value="<?php echo $_POST['texte_login']; ?>"  placeholder="login: max 50 caractères [a-z]" size="41" onblur="VerificationLogin(this)"/> <br/>	<br/>

                    <label for="motdepasse">Votre mot de passe:</label>
                    <input type="password" id="mdp1" name="texte_motdepasse" value="<?php echo $_POST['texte_mot_de_passe']; ?>" maxlength="16"  placeholder="Mot de passe: 8 à 16 caractères [a-zA-Z-0-9]" size="41" onblur="VerificationMdp(this)"/> <!--required pattern="^[a-zA-Z0-9]{8,16}$"--> <br/> <br/>

                    <label for="motdepasse">Confirmation mot de passe:</label>
                    <input type="password" id="mdp2" name="texte_confirmationmotdepasse"  placeholder="Confirmation du mot de passe" size="41" maxlength="16" onblur="VerificationMdp(this)"/> <br/> <br/>

                    <label for="email">Votre e-mail:</label>
                    <input type="text" id="mail" name="texte_mail"  placeholder="exemple@gmail.com" size="41" onblur="VerificationMail(this)" <!--required pattern="^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$"--> <br/> <br/>

                    <label for="date">Votre date de naissance:</label>
                    <input type="date" name="texte_datedenaissance"  placeholder="1993/03/25 au format US" size="41"/> <br/> <br/>

                    <input class="Envoyer" type="submit" value="Envoyer" />
                </p>
            </form>
        </div>
        <br/>
        <?php
        if (isset($_SESSION['code']))
        {
            $cas = ($_SESSION['code']);
            switch($cas)
            {
                case '1':
                    break;
            case '2':
                ?> <script> alert('Le pseudo est déjà enregistré') </script> <?php
            echo '<p style="text-align: center;">Le pseudo est déjà enregistré, veuillez en choisir un autre</p>';
            $_SESSION['code'] = 0;
            break;
            case '3':
            ?> <script> alert('L\'adresse mail est déjà enregistrée') </script> <?php
            echo '<p style="text-align: center;">L\'adresse mail est déjà enregistrée, veuillez en choisir une autre</p>';
            $_SESSION['code'] = 0;
            break;
            case '4':
            ?> <script> alert('Le pseudo et l\'adresse mail sont déjà enregistrés') </script> <?php
            echo '<p style="text-align: center;">Le pseudo ainsi que l\'adresse mail sont déjà utilisés</p>';
            $_SESSION['code'] = 0;
            break;
            case '5':
            ?> <script> alert('Le login doit contenir des caractères [a-z] uniquement et le mot de passe doit contenir entre 8 et 16 caractères, sans symbole') </script> <?php
            echo '<p style="text-align: center;">Veuillez entrer un login contenant des caractères [a-z] et d\'un longueur maximal de 50 caractères, ainsi qu\'un mot de passe contenant des caractères [a-zA-Z0-9]</p>';
            $_SESSION['code'] = 0;
            break;
            case '6':
            ?> <script> alert('Le login doit contenir des caractères [a-z] uniquement') </script> <?php
            echo '<p style="text-align: center;">Veuillez entrer un login contenant des caractères [a-z] et d\'un longueur maximal de 50 caractères</p>';
            $_SESSION['code'] = 0;
            break;
            case '7':
            ?> <script> alert('Le mot de passe doit contenir entre 8 et 16 caractères, sans symbole') </script> <?php
            echo '<p style="text-align: center;">Veuillez entrer un mot de passe contenant des caractères [a-zA-Z0-9]</p>';
            $_SESSION['code'] = 0;
            break;
            case '8':
            ?> <script> alert('Vous avez tapé deux mots de passe différents') </script> <?php
            echo '<p style="text-align: center;">Veuillez entrer deux fois le même mot de passe</p>';
            $_SESSION['code'] = 0;
            break;
            case '9':
            ?> <script> alert('Veuillez entrer une adresse mail au format US YYYY/MM/DD') </script> <?php
            echo '<p style="text-align: center;">Veuillez entrer une adresse mail respectant le format US YYYY/MM/DD</p>';
            $_SESSION['code'] = 0;
            break;
            case '10':
            ?> <script> alert('Date non valide') </script> <?php
            echo '<p style="text-align: center;">La date ne peut être une date du futur</p>';
            $_SESSION['code'] = 0;
            break;
            case '11':
            ?> <script> alert('Format de la date non valide') </script> <?php
                echo '<p style="text-align: center;">Le format de la date n\'est pas valide</p>';
                $_SESSION['code'] = 0;
                break;
                default:
                    break;
            }
        }
        /*if (isset($_GET['code']))
        {
            $cas = ($_GET['code']);
            switch ($cas)
            {
                case '1':
                    break;
                case '2':
                    ?> <script> alert('Le pseudo est déjà enregistré') </script> <?php
                    echo '<p style="text-align: center;">Le pseudo est déjà enregistré, veuillez en choisir un autre</p>';
                    break;
                case '3':
                    ?> <script> alert('L\'adresse mail est déjà enregistrée') </script> <?php
                    echo '<p style="text-align: center;">L\'adresse mail est déjà enregistrée, veuillez en choisir une autre</p>';
                    break;
                case '4':
                    ?> <script> alert('Le pseudo et l\'adresse mail sont déjà enregistrés') </script> <?php
                    echo '<p style="text-align: center;">Le pseudo ainsi que l\'adresse mail sont déjà utilisés</p>';
                    break;
                case '5':
                    ?> <script> alert('Le login doit contenir des caractères [a-z] uniquement et le mot de passe doit contenir entre 8 et 16 caractères, sans symbole') </script> <?php
                    echo '<p style="text-align: center;">Veuillez entrer un login contenant des caractères [a-z] et d\'un longueur maximal de 50 caractères, ainsi qu\'un mot de passe contenant des caractères [a-zA-Z0-9]</p>';
                    break;
                case '6':
                    ?> <script> alert('Le login doit contenir des caractères [a-z] uniquement') </script> <?php
                    echo '<p style="text-align: center;">Veuillez entrer un login contenant des caractères [a-z] et d\'un longueur maximal de 50 caractères</p>';
                    break;
                case '7':
                    ?> <script> alert('Le mot de passe doit contenir entre 8 et 16 caractères, sans symbole') </script> <?php
                    echo '<p style="text-align: center;">Veuillez entrer un mot de passe contenant des caractères [a-zA-Z0-9]</p>';
                    break;
                case '8':
                    ?> <script> alert('Vous avez tapé deux mots de passe différents') </script> <?php
                    echo '<p style="text-align: center;">Veuillez entrer deux fois le même mot de passe</p>';
                    break;
                case '9':
                    ?> <script> alert('Veuillez entrer une adresse mail au format US YYYY/MM/DD') </script> <?php
                    echo '<p style="text-align: center;">Veuillez entrer une adresse mail respectant le format US YYYY/MM/DD</p>';
                    break;
                case '10':
                    ?> <script> alert('Date non valide') </script> <?php
                    echo '<p style="text-align: center;">La date ne peut être une date du futur</p>';
                    break;
                case '11':
                    ?> <script> alert('Format de la date non valide') </script> <?php
                    echo '<p style="text-align: center;">Le format de la date n\'est pas valide</p>';
                    break;
                default:
                    break;
            }
        }*/
        ?>
        <!--$login = htmlspecialchars($_POST['texte_login'], ENT_QUOTES);-->

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