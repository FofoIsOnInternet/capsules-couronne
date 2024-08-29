<?php
require "connexion_base.php";
require "functions.php";
// augmente le nombre de pays affiché
$coutry_count = $_POST["coutrycount"] + 100;
$countries = array();

// functions
function isDuplicates(){
    return isset($_POST["doublon"]) && $_POST["doublon"] == 1;
}

// Récupère la liste des pays et leurs infos
$countries = get_countries($pdo,isDuplicates(),$_POST["order"],$_POST["continent"]);
// contenu html
$content = "";
// Total de capsule en fonction de : doublon et continent
if($_POST["continent"] == "Tous"){
    $total_caps = (isDuplicates()) ? total_duplicates($pdo) : total_crown_caps($pdo);
}else{
    $total_caps = (isDuplicates()) ? total_duplicates_continent($pdo,$_POST["continent"]) : total_crown_caps_continent($pdo,$_POST["continent"]);
}

for ($i=$_POST["coutrycount"];$i<min($coutry_count,count($countries));$i++) {
    $c = $countries[$i];
    $content .= "<tr continent='" . $c['nomContinentFR'] . "'>";
        $content .= "<th>";
            $content .= "<a href='crown_caps.php?country=" . $c["isoAlpha2"];
            $content .= (isDuplicates()) ? "&doublon=1" : "";
            $content .= "'>";
                $content .= "<img src='images/drapeaux/" . $c['isoAlpha2']  . ".png'>";
                $content .= "<span>" . $c['nomPaysFR'] . "</span>";
            $content .= "</a>";
        $content .= "</th>";
        $content .= "<td>";
            $content .= $c['nbCapsules'];
        $content .= "</td>";
        $content .= "<td>";
            if($total_caps != 0){
                $content .= strval(round(intval($c['nbCapsules']) / $total_caps * 100,2)) . "%";
            }else{
                $content .= "0%";
            }
        $content .= "</td>";
    $content .= "</tr>";
}
$data = [
    "status" => true,
    "country_count" => min($coutry_count,count($countries)),
    "maxed" => min($coutry_count,count($countries)) == count($countries),
    "msg" => "success!",
    "data" => $content
];

echo str_replace("\/","/",json_encode($data));
?>