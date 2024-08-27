<?php
    $titre_page = "Régions";
    if(isset($_GET["doublon"]) && $_GET["doublon"] == 1){
        $titre_page = "Doublons par région";
    }
    $page_css = "countries.css";
    include "includes/debut-page.php";

    function isDuplicates(){
        return isset($_GET["doublon"]) && $_GET["doublon"] == 1;
    }
?>

<main>
    <section id="info">
        <h1>
        <?php
            echo (isDuplicates()) ? "Doublons par région" : "Collection par région" ;
            echo "<span>(". count(get_countries($pdo,isset($_GET["doublon"]) && $_GET["doublon"] == 1)) .")</span>" ; 
        ?>
        </h1>
    </section>
    <section id="continents">
        
    </section>
    <section id="countries">
        <table>
           <thead>
                <tr>
                    <th>Pays</th>
                    <th>Capsules</th>
                    <th>Représentation</th>
                </tr>
           </thead>
           <tbody>

           </tbody>
        </table>
        <button type="button" onclick="display_data()">Afficher plus</button>
        <input type="hidden" id="country-count" value="0">
    </section>
</main>

<script src="scripts/display_countries.js"></script>
<?php
    include  "includes/fin-page.php";
?>
