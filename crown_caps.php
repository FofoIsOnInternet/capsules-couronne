<?php
    $titre_page = "Capsules";
    if(isset($_GET["doublon"]) && $_GET["doublon"] == 1){
        $titre_page = "Doublons";
    }
    $page_css = "crown_caps.css";
    include "includes/debut-page.php";

    // fonctions
    function isCountry(){
        return isset($_GET["country"]);
    }
    function isResearch(){
        return isset($_GET["search"]);
    }
    function isDuplicates(){
        return isset($_GET["doublon"]) && $_GET["doublon"] == 1;
    }

    // Paramètre pour fonctions js
    $param = "";
    if(isCountry()){
        $param .= ",'" . $_GET["country"] . "'";
        $country_info = get_country_info($pdo,$_GET["country"]); // also get country info
    }else{
        $param .= ",''";
    }
    if(isResearch()){
        $param .= ",'" . $_GET["search"] . "'";
    }

    // Compte des capsules affichable sur cette page
    if(isResearch()){ // Recherche -> résultat recherche
        $nbCapsules = count(search_cap($pdo,$_GET["search"]));
    }elseif(isCountry()){ // Pays -> nbCapsules du pays
        if(isDuplicates()){
            $nbCapsules = count(get_duplicates($pdo, "AND isoAlpha2='".$country_info['isoAlpha2'] . "'"));
        }else{
            $nbCapsules = $country_info['nbCapsules'];
        }
    }elseif(isDuplicates()){
        $nbCapsules = total_duplicates($pdo);
    }else{ // Sinon -> total capsules
        $nbCapsules = total_crown_caps($pdo);
    }
    
?>

<main>
    <?php
        // Grande barre de recherche
        if(isResearch()){
            echo "<div class='searchBar'>";
            echo '<input id="search" placeholder="Rechercher une capsule (texte, mots clé)" name="query" value="'. $_GET["search"] .'">';
            echo '<button type="button"><img src="./images/icones/search.png" alt="search button icon"></button></div>';
        }
    ?>
    <section id="country">
    <?php
        // Si affichage d'un pays
        if(isCountry()){
            // Flag
            echo "<img src='images/drapeaux/" . $country_info['isoAlpha2']  . ".png'>";
            // Title
            echo "<h1>" . $country_info["nomPaysFR"];
            if(isResearch()){
                echo " - Rechercher une capsule ";
            }elseif(isDuplicates()){
                echo " - Doublons ";
            }
            echo "</h1>";
            // caps count
            echo "<span>(".$nbCapsules.")</span>"; // caps count for country or research result
            // Back button
            if(isResearch()){ // back to caps of country 
                echo "<a href='./crown_caps.php?country=" . $_GET["country"] . "'><img src='images/icones/close.png'></a>";
            }elseif(isDuplicates()){
                echo "<a href='./countries.php?doublon=1'><img src='images/icones/close.png'></a>";
            }else{ // back to country list
                echo "<a href='./countries.php'><img src='images/icones/close.png'></a>";
            }
            
        }else{ // Sinon affichage classique
            // No flag
            // Title
            if(isResearch()){
                echo "<h1>Rechercher une capsule</h1>";
            }elseif(isDuplicates()){
                echo "<h1>Doublons</h1>";
            }else{
                echo "<h1>Capsules du monde</h1>";
            }
            // caps count
            echo "<span>(".$nbCapsules.")</span>"; // total caps count
            // Back button
            if(isResearch()){ // back to full caps list
                echo "<a href='./crown_caps.php'><img src='images/icones/close.png'></a>";
            }
        }
    ?>
    </section>
    <section id="crown-caps">
        <!-- Navigation de page -->
        <div>
            <button type="button" onclick="display_data(-1<?php echo $param; ?>)">-</button>
            <select id="page-count">
                <?php
                echo "<option>1</option>";
                for($i=25;$i<$nbCapsules;$i+=25){
                    echo "<option>" . (($i+25)/25) . "</option>";
                }
                ?>
            </select>
            <button type="button" onclick="display_data(1<?php echo $param; ?>)">+</button>
            <?php echo "<span> / " . $nbCapsules . "</span>"; ?>
        </div>
        <!-- Conteneur des capsules -->
        <div>
        </div>
    </section>
</main>
<!-- script de mise à jour du titre de la page -->
<script><?php
    if(isResearch()){
        echo "document.title = 'Rechercher une capsule';";
    }
    if(isCountry()){
        echo (isDuplicates()) ? "document.title = '" . $country_info["nomPaysFR"] . " - Doublons';" : "document.title = '" . $country_info["nomPaysFR"] . " - Capsules';";
    }
?></script>
<script src="scripts/display_crown_caps.js"></script>
<?php
    include  "includes/fin-page.php";
?>
