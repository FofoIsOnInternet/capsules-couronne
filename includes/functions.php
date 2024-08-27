<?php

function to_valid_img_url($img_name,$table_origine){
    // Récupère les chemins d'accès aux répertoires d'images
    $json_string = file_get_contents("scripts/repertoires-images.json");
    $repertoires_images = json_decode($json_string,true);
    $temp = $repertoires_images[$table_origine] . "/" .str_replace("+","%20",urlencode($img_name));
    return $temp;
}

function total_crown_caps($pdo){
    $requete = "SELECT COUNT(*) AS 'TOTAL' FROM capsule;";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $result = $reponse -> fetchAll();
    return intval($result[0]["TOTAL"]);
}

function total_duplicates($pdo){
    $requete = "
        SELECT COUNT(*) AS 'TOTAL' 
        FROM Labelliser 
        WHERE codeEtiquette= (SELECT codeEtiquette FROM Etiquette WHERE libeleEtiquette='Doublon');
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $result = $reponse -> fetchAll();
    return intval($result[0]["TOTAL"]);
}

function get_duplicates($pdo,$country=""){
    $requete = "SELECT * 
            FROM Capsule 
            LEFT JOIN Image ON Image.codeCapsule = Capsule.codeCapsule 
            LEFT JOIN Rangement ON Rangement.codeRangement = Capsule.codeRangement
            LEFT JOIN Doublure ON Doublure.codeDoublure = Capsule.codeDoublure
            LEFT JOIN Pays ON Pays.codePays = Capsule.codePays
            LEFT JOIN Fabriquant ON Fabriquant.codeFabriquant = Capsule.codeFabriquant
            LEFT JOIN Echange ON Echange.codeEchange = capsule.codeEchange
            LEFT JOIN SetCapsule ON SetCapsule.codeSet = Capsule.codeSet
            LEFT JOIN Partenaire ON Echange.codePartenaire = Partenaire.codePartenaire
            LEFT JOIN Continent ON Pays.codeContinent = Continent.codeContinent
            LEFT JOIN labelliser ON labelliser.codeCapsule = capsule.codeCapsule
            WHERE Image.estPrincipal=1 " . $country . " AND codeEtiquette = (SELECT codeEtiquette FROM Etiquette WHERE libeleEtiquette='Doublon')
            ORDER BY Emplacement";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $capsules = $reponse -> fetchAll();
    return $capsules;
}

function get_crown_caps($pdo,$country=""){
    $requete = "SELECT * 
            FROM Capsule 
            LEFT JOIN Image ON Image.codeCapsule = Capsule.codeCapsule 
            LEFT JOIN Rangement ON Rangement.codeRangement = Capsule.codeRangement
            LEFT JOIN Doublure ON Doublure.codeDoublure = Capsule.codeDoublure
            LEFT JOIN Pays ON Pays.codePays = Capsule.codePays
            LEFT JOIN Fabriquant ON Fabriquant.codeFabriquant = Capsule.codeFabriquant
            LEFT JOIN Echange ON Echange.codeEchange = capsule.codeEchange
            LEFT JOIN SetCapsule ON SetCapsule.codeSet = Capsule.codeSet
            LEFT JOIN Partenaire ON Echange.codePartenaire = Partenaire.codePartenaire
            LEFT JOIN Continent ON Pays.codeContinent = Continent.codeContinent
            WHERE Image.estPrincipal=1 " . $country . "
            ORDER BY Emplacement";             
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $capsules = $reponse -> fetchAll();
    return $capsules;
}

function get_random_crown_caps($pdo,$amount=5){
    $requete = "
        SELECT codeCapsule 
        FROM capsule
        ORDER BY RAND()
        LIMIT " . $amount . ";
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $capsules = $reponse -> fetchAll();
    return $capsules;
}

function get_crown_cap_info($pdo,$codeCapsule){
    $requete = "
        SELECT * 
        FROM Capsule
        JOIN Pays ON Capsule.codePays = Pays.codePays
        LEFT JOIN Fabriquant ON Fabriquant.codeFabriquant = capsule.codeFabriquant
        WHERE Capsule.codeCapsule = ". $codeCapsule ."
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $cap_info = $reponse -> fetchAll();
    return $cap_info[0];
}

function get_crown_cap_images($pdo,$codeCapsule){
    $requete = "
        SELECT ImageCapsule, estPrincipal
        FROM Image
        WHERE codeCapsule= ". $codeCapsule ."
        ORDER BY estPrincipal DESC
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $images = $reponse -> fetchAll();
    return $images;
}

function get_crown_cap_labels($pdo,$codeCapsule){
    $requete = "
        SELECT *
        FROM Labelliser
        JOIN Etiquette ON Etiquette.codeEtiquette = Labelliser.codeEtiquette
        WHERE Labelliser.codeCapsule= ". $codeCapsule ."
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $labels = $reponse -> fetchAll();
    return $labels;
}

function get_country_info($pdo,$iso_alpha2){
    $country = "'" . $iso_alpha2 . "'";
    $requete = "
            SELECT isoAlpha2,nomPaysFR,nomPaysEN,count(codeCapsule) AS 'nbCapsules'
            FROM Pays 
            JOIN capsule ON capsule.codePays = Pays.codePays 
            WHERE isoAlpha2=". $country ."
            GROUP BY isoAlpha2,nomPaysFR,nomPaysEN
        ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $country_info = $reponse -> fetchAll();
    $country_info = $country_info[0];
    return $country_info;
}

function get_countries($pdo,$isDuplicates=false){
    if($isDuplicates){
        $requete = "SELECT Pays.codePays,nomPaysFR,isoAlpha2,nomContinentFR, COUNT(capsule.codeCapsule) AS 'nbCapsules'
            FROM Pays
            JOIN Continent ON Pays.codeContinent = Continent.codeContinent
            JOIN Capsule ON Pays.codePays = Capsule.codePays
            JOIN labelliser ON labelliser.codeCapsule = capsule.codeCapsule
            WHERE codeEtiquette = (SELECT codeEtiquette FROM Etiquette WHERE libeleEtiquette='Doublon')
            GROUP BY Pays.codePays
            ORDER BY COUNT(codeCapsule) DESC;
        ";
    }else{
        $requete = "SELECT Pays.codePays,nomPaysFR,isoAlpha2,nomContinentFR, COUNT(codeCapsule) AS 'nbCapsules'
            FROM Pays
            JOIN Continent ON Pays.codeContinent = Continent.codeContinent
            JOIN Capsule ON Pays.codePays = Capsule.codePays
            GROUP BY Pays.codePays
            ORDER BY COUNT(codeCapsule) DESC;
        ";
    }
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $countries = $reponse -> fetchAll();
    return $countries;
}

function get_trades ($pdo){
    $requete = "
        SELECT * 
        FROM Echange 
        JOIN Partenaire ON Echange.codePartenaire = Partenaire.codePartenaire
        JOIN Pays ON Partenaire.codePays = Pays.codePays;
    ";
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $countries = $reponse -> fetchAll();
    return $countries;
}

function search_cap($pdo,$input){
    $debut = "
            SELECT Research.codeCapsule, imageCapsule, MIN(filter)
            FROM (
    ";

    $fin = "
            ) AS Research
            JOIN Image ON Image.codeCapsule = Research.codeCapsule
            JOIN Capsule ON Capsule.codeCapsule = Research.codeCapsule
            JOIN Pays ON Pays.codePays = Capsule.codePays
            WHERE Image.estPrincipal=1
            GROUP BY Research.codeCapsule, imageCapsule,isoAlpha2
            ORDER BY MIN(filter), Emplacement;
    ";

    $filtre_1 = "
            SELECT codeCapsule,1 as filter
            FROM Capsule
            WHERE texteCapsule = '". $input ."' OR texteJupe = '". $input ."'
            UNION
    ";

    $filtre_2 = "
            SELECT codeCapsule, 2 as filter
            FROM Capsule
            WHERE texteCapsule LIKE '%". $input ."%' OR texteJupe LIKE '%". $input ."%' OR motsCle LIKE '%". $input ."%'
    ";

    
    $filtre_3 = "";
    $filtre_4 = "";
    $words = explode(" ",$input);
    if(count($words) > 1){
        $filtre_2 .= " UNION ";

        $filtre_3 = "
                SELECT codeCapsule, 3 as filter
                FROM Capsule
                WHERE 
        ";
        foreach($words as $w){
            $filtre_3 .= " ( texteCapsule LIKE '%" . $w . "%' OR texteJupe LIKE '%". $w ."%' OR motsCle LIKE '%". $w ."%' ) AND " ;
        }
        $filtre_3 = substr($filtre_3,0,-4) /*. " UNION "*/;

        $filtre_4 = "
                SELECT codeCapsule, 4 as filter
                FROM Capsule
                WHERE 
        ";
        foreach($words as $w){
            $filtre_4 .= " texteCapsule LIKE '%" . $w . "%' OR texteJupe LIKE '%". $w ."%' OR motsCle LIKE '%". $w ."%' OR ";
        }
        $filtre_4 = substr($filtre_4,0,-3);
    }

    $requete = 
        $debut . " "
        . $filtre_1
        . $filtre_2
        . $filtre_3
        /*. $filtre_4*/ . " "
        . $fin;

    //echo $requete;
    $reponse = $pdo -> prepare($requete);
    $reponse -> execute();
    $capsules = $reponse -> fetchAll();
    return $capsules;
}


?>