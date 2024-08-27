<?php
// définition des paramètres de connexion à la base de données
$config_base['hote'] = "localhost";
$config_base['utilisateur'] = "root";
$config_base['motdepasse'] = "root"; // si Wampserver, mettez "" ici
$config_base['nom_base'] = "crown_caps";
// connexion à la base de données
try {
$pdo = new PDO( "mysql:host={$config_base['hote']};
dbname={$config_base['nom_base']}",
"{$config_base['utilisateur']}",
"{$config_base['motdepasse']}");
// afficher les messages d'erreurs pour trouver les erreurs
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
// jeu de caractères : UTF-8
$pdo->query("SET NAMES utf8");
$pdo->query("SET CHARACTER SET utf8");
}
catch (PDOException $exception) {
echo "Connexion échouée : " . $exception->getMessage();
}
?>