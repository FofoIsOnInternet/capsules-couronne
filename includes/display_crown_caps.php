<?php
require "connexion_base.php";
require "functions.php";
// page demandé
$page = $_POST["pagecount"];
// index de la dernière capsule
$end = 25 * $page;
// index de la première capsule
$start = 25 * $page -25;
// liste des capsules
$capsules = array();
// WHERE clause pour un possible pays
$country = "";
if(isset($_POST["country"])){
    $country = "AND isoAlpha2='" . $_POST["country"] . "'";
}

// Récupère les capsules à afficher
if(isset($_POST["search"])){ // appel à l'algorithme de recherche
    $capsules = search_cap($pdo,urldecode($_POST["search"]));
}elseif(isset($_POST["doublon"])){ // requette pour doublons
    $capsules = get_duplicates($pdo,$country);
}else{ // requete classique pour les capsules
    $capsules = get_crown_caps($pdo,$country);
}

// Consoit le contenu HTML
$content = "";
for ($i=$start;$i<min($end,count($capsules));$i++) { 
    $cap = $capsules[$i];
    $content .= "<a class='crown' href='./cap.php?id=". $cap["codeCapsule"] ."' title='" . $cap["texteJupe"] . "'>";
        $content .= "<img class='capsule-normal' src='images/capsules/" . to_valid_img_url($cap['imageCapsule'],"Capsule") . "'>";
        $images = get_crown_cap_images($pdo, $cap['codeCapsule']);
        if(sizeof($images) > 1){
            $content .= "<img class='capsule-inside' src='images/capsules/" . to_valid_img_url($images[1]["ImageCapsule"],"Capsule") . "'>";
        }
        $content .= "<div>";
        $content .= "</div>";
    $content .= "</a>";
}
// Créer le résultat JSON 
$data = [
    "status" => true,
    "start" => $start,
    "end" => min($end,count($capsules)),
    "maxed" => min($end,count($capsules)) == count($capsules),
    "mined" => $page == 1,
    "msg" => "success!",
    "data" => $content
];
// Return
echo str_replace("\/","/",json_encode($data));
?>