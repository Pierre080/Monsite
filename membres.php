<?php /* membres.php */
session_start();
?>

!DOCTYPE HTML>

<html>
<head>
    <title>Generic Page - Massively by HTML5 UP</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="is-loading">

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    <header id="header">
        <a href="index.php" class="logo">P.B.Photography</a>
    </header>

    <!-- Nav -->
    <nav id="nav">
        <ul class="links">
            <li><a href="index.php">Articles</a></li>
            <li class="active"><a href="generic.html">Membres</a></li>
            <li><a href="elements.html">Elements Reference</a></li>
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

        <!-- Post -->
        <section class="post">
            <header class="major">
                <span class="date">Membres inscrits:</span>

                <?php
                $bdd = new PDO('mysql:host=localhost;dbname=monsite;charset=utf8','root','', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                $requete = $bdd->prepare('SELECT * FROM membres ORDER BY login ASC');
                $requete->execute();
                ?>

                <table class="centrer">

                    <tr>
                        <th>login</th>
                    </tr>
                    <tr>
                        <?php
                        while ($donnees = $requete->fetch())
                        {?>
                    <tr>
                        <td><?php echo $donnees['login'];?></td>
                    </tr>
                    <?php
                    }
                    ?>
                    </tr>
                </table>
                </br>


            </header>
        </section>

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
                <p>1234 Somewhere Road #87257<br />
                    Nashville, TN 00000-0000</p>
            </section>
            <section>
                <h3>Phone</h3>
                <p><a href="#">(000) 000-0000</a></p>
            </section>
            <section>
                <h3>Email</h3>
                <p><a href="#">info@untitled.tld</a></p>
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
        <ul><li>&copy; Untitled</li><li>Design: <a href="https://html5up.net">HTML5 UP</a></li><li>Distributor: <a href="https://themewagon.com/">ThemeWagon</a></li></ul>
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

					
	
					