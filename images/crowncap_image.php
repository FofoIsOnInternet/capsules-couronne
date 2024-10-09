<?php
if(!isset($_GET["id"]) || strlen($_GET["id"]) == 0){
    echo "No image";
    exit();
}

require "./../connexion_base.php";

$sql = "SELECT imageBlob FROM image WHERE codeImage=:id";
$requete = $pdo->prepare($sql);
$requete->execute([':id'=>$_GET["id"]]);
echo $requete->fetch()[0];