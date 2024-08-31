<?php
    session_start();
    require_once("includes/connexion_base.php");
    require("includes/functions.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titre_page;?></title>
    <!-- CSS général  -->
    <link rel="stylesheet" type="text/css" href="style/index.css">
    <!-- CSS spécifique à la page  -->
    <?php
        if(isset($page_css)){
            echo "<link rel='stylesheet' type='text/css' href='style/" . $page_css . "'>";
        } 
    ?>
</head>
<body>
    <header>
        <a href="./index.php"><img src="./images/baner.jpg" alt="banière du site"></a>
        <img src="./images/icones/menu.png">
        <nav>
            <ul>
                <li><a href="./index.php">Acceuil</a></li>
                <li><a>Parcourrir la collection</a><ul>
                    <li><a href="./crown_caps.php">Toutes les capsules</a></li>
                    <li><a href="./countries.php">Par région</a></li>
                    <li><a href="./sets.php">Par série</a></li>
                    <li><a href="./crown_caps.php?search=">Rechercher</a></li>
                </ul></li>
                <li><a>Doublons</a><ul>
                    <li><a href="./crown_caps.php?doublon=1">Tous les doublons</a></li>
                    <li><a href="./countries.php?doublon=1">Par région</a></li>
                    <li><a href="./echange.php">Echanger</a></li>
                </ul></li>
            </ul>
        </nav>
        <input id="search" placeholder="Rechercher une capsule" name="query" value="<?php echo $_GET["search"] ?>">
    </header>
    <div>&nbsp;</div>
    <div>&nbsp;</div>
    