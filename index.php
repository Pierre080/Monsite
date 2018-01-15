<?php
/* index.php*/
session_start(); // On va enregistrer le pseudo et le securtiy level en commencant une session
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Acceuil</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
        <?php
        if (isset($_SESSION['erreur']) AND ($_SESSION['erreur']) == 1)
        {?>
            <script> alert('Erreur de connexion : mauvais mot de passe ou login') </script>
            <?php $_SESSION['erreur'] = 0;
        }?>
        <?php
        if (isset($_SESSION['reussite']) AND ($_SESSION['reussite']) == 1)
        {?>
            <script> alert('Connexion réussie') </script>
            <?php $_SESSION['reussite'] = 0;
        }?>
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
                        <?php
                        if (!isset($_SESSION['security_level']) OR ($_SESSION['security_level'] == 1)) // Si personne n'est connecté ou que l'on est en anonyme, on procède à la suite du code
                        {?>
                        <nav id="nav_connection">
                                <h3>Connectez-vous !</h3>

                                <div id="connexion">
                                    <form method="post" action= "connection.php" >

                                        <tr><td>Login :<br><input type="text" name="texte_login" size=10><p></td></tr>

                                        <tr><td>Mot de passe :<br><input type="password" name="texte_mot_de_passe" size=10><p></td></tr>

                                        <tr><br><input type="submit" alt="envoyer" value="Connection" class="BoutonFormulaire"></tr>
                                    </form>
                                </div>
                        </nav>
                            <?php
                        }
                        ?>
                        <article><header class="major"><h2><a>
                    <?php
                    if (isset($_SESSION['security_level']) AND isset($_SESSION['login'])) // si une variable security_level est affectée et qu'une variable login est affectée
                    {
                        echo 'Welcome ' . $_SESSION['login'] . ' !'; // On annonce la bienvenue à l'utilisateur connecté
                    }
                    else
                    {
                        $_SESSION['security_level'] = 1; // Sinon c'est que personne n'est connecté
                        echo 'Welcome anonymous'; // On annonce la bienvenue à anonyme
                    }
                    ?>
                                </a></h2></header></article>
						<!-- Featured Post -->
							<article class="post featured">
								<header class="major">
									<span class="date">April 25, 2017</span>
									<h2><a href="#">And this is a<br />
									massive headline</a></h2>
									<p>Aenean ornare velit lacus varius enim ullamcorper proin aliquam<br />
									facilisis ante sed etiam magna interdum congue. Lorem ipsum dolor<br />
									amet nullam sed etiam veroeros.</p>
								</header>
								<a href="#" class="image main"><img src="images/pic01.jpg" alt="" /></a>
								<ul class="actions">
									<li><a href="#" class="button big">Full Story</a></li>
								</ul>
							</article>

						<!-- Posts -->
							<section class="posts">
								<article>
									<header>
										<span class="date">April 24, 2017</span>
										<h2><a href="#">Sed magna<br />
										ipsum faucibus</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic02.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">April 22, 2017</span>
										<h2><a href="#">Primis eget<br />
										imperdiet lorem</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic03.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">April 18, 2017</span>
										<h2><a href="#">Ante mattis<br />
										interdum dolor</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic04.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">April 14, 2017</span>
										<h2><a href="#">Tempus sed<br />
										nulla imperdiet</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic05.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">April 11, 2017</span>
										<h2><a href="#">Odio magna<br />
										sed consectetur</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic06.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
								<article>
									<header>
										<span class="date">April 7, 2017</span>
										<h2><a href="#">Augue lorem<br />
										primis vestibulum</a></h2>
									</header>
									<a href="#" class="image fit"><img src="images/pic07.jpg" alt="" /></a>
									<p>Donec eget ex magna. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque venenatis dolor imperdiet dolor mattis sagittis magna etiam.</p>
									<ul class="actions">
										<li><a href="#" class="button">Full Story</a></li>
									</ul>
								</article>
							</section>

						<!-- Footer -->
							<footer>
								<div class="pagination">
									<!--<a href="#" class="previous">Prev</a>-->
									<a href="#" class="page active">1</a>
									<a href="#" class="page">2</a>
									<a href="#" class="page">3</a>
									<span class="extra">&hellip;</span>
									<a href="#" class="page">8</a>
									<a href="#" class="page">9</a>
									<a href="#" class="page">10</a>
									<a href="#" class="next">Next</a>
								</div>
							</footer>

					</div>

				<!-- Footer -->
					<footer id="footer">
						<section>
							<form method="post" action="#">
								<div class="field">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" />
								</div>
								<div class="field">
									<label for="email">Email</label>
									<input type="text" name="email" id="email" />
								</div>
								<div class="field">
									<label for="message">Message</label>
									<textarea name="message" id="message" rows="3"></textarea>
								</div>
								<ul class="actions">
									<li><input type="submit" value="Send Message" /></li>
								</ul>
							</form>
						</section>
						<section class="split contact">
							<section class="alt">
								<h3>Address</h3>
								<p>Arlon<br />
								6700</p>
							</section>
							<section>
								<h3>Phone</h3>
								<p><a href="#">+32499XXXX</a></p>
							</section>
							<section>
								<h3>Email</h3>
								<p><a href="#">pierre_blavierphotography@XXXX.fr</a></p>
							</section>
							<section>
								<h3>Social</h3>
								<ul class="icons alt">
									<li><a href="#" class="icon alt fa-twitter"><span class="label">Twitter</span></a></li>
									<li><a href="#" class="icon alt fa-facebook"><span class="label">Facebook</span></a></li>
									<li><a href="#" class="icon alt fa-instagram"><span class="label">Instagram</span></a></li>
									<li><a href="#" class="icon alt fa-github"><span class="label">GitHub</span></a></li>
								</ul>
							</section>
						</section>
					</footer>

				<!-- Copyright -->
					<div id="copyright">
						<ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li><li>Distributor: <a href="https://themewagon.com">ThemeWagon</a></li></ul>
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