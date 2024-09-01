<?php
require "connexion_base.php";
require "functions.php";
// augmente le nombre de pays affiché
$sets_count = 0;
$sets = array();

// Récupère la liste des pays et leurs infos
$sets = get_sets($pdo,$_POST["input"]);
// contenu html
$content = "";
$initial = "";

for ($i=0;$i<count($sets);$i++) {
    $s = $sets[$i];
    if($s["nomSet"][0] != $initial){
        $initial = $s["nomSet"][0];
        $content .= "<h2 id='title-" . $initial . "'>" . strtoupper($initial) . "</h2>";
    }
    $content .= "<a href='./crown_caps.php?set=" . $s["codeSet"] . "' title='" . $s["descriptionSet"] . "'>";
    $content .= $s["nomSet"];
    $content .= "<span>(" . $s["nbCapsules"] . ")</span>";
    $content .= "</a>";
}
$data = [
    "status" => true,
    "sets_count" => count($sets),
    "msg" => "success!",
    "data" => $content
];

echo str_replace("\/","/",json_encode($data));
?>