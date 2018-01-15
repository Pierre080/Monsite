
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <!-- jQuery library (served from Google) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <!-- bxSlider Javascript file -->
    <script src="jquery.bxslider.js"></script>
    <!-- bxSlider CSS file -->
    <link href="assets/css/jquery.bxslider.css" rel="stylesheet" />
    <script type="text/javascript">
        $(document).ready(function(){
            $('.bxslider').bxSlider({
                auto: true, // départ automatique
                autoStart : false,
                slideWidth: 2400,
                captions: true,
                adaptiveHeight: true,
                autoControls: true,
                stopAutoOnClick: true,
                pause: 5000,
                preloadImages: 'all',
                autoHover: true,
                controls: true,
                mode: 'fade',

            });
        });
        </script>
    <style type="text/css">
        .bxslider-wrap { width:100%; max-width:1296px; margin:0 auto; }
    </style>
</head>
<body>

<header>
    <nav id ="nav_quitter">
        <a href="index.php">
        <input type="image" alt="envoyer" src="images/croix50.png"value="Quitter" class="BoutonQuitter" onclick="window.close('index.php')">
        </a>
    </nav>
</header>
<?php
// 1/ RECUPERATION des IMAGES dans le DOSSIER
//nom du répertoire contenant les images à afficher
$repertoire = './images2';
$extensions_ok = array('gif','jpg','jpeg','png'); // extensions recherchées : images uniquement

//on ouvre le repertoire
$pointeur = opendir($repertoire);

//on stocke les noms des fichiers des images trouvées, dans un tableau
$tab_image = array();
while ($fichier = readdir($pointeur))
{
    if ( in_array( strtolower(pathinfo($fichier,PATHINFO_EXTENSION)), $extensions_ok) )
    {
        $tab_image[] = $fichier;
    }
}
//on ferme le répertoire
closedir($pointeur);
?>

<div class="bxslider-wrap">
    <ul class="bxslider">
        <?php
        // 2/ AFFICHAGE des IMAGES

        if( !empty(($tab_image)) )
        {
            // ordre aléatoire
            shuffle($tab_image);
            //affichage des images
            foreach( $tab_image as $image )
            {
                ?>
                <li>
                    <img src="<?php echo $repertoire.'/'.$image; ?>" alt="" />
                </li>
                <?php
            }
        }
        ?>
    </ul>

</body>
</html>