<?php
    $titre_page = "Régions";
    if(isset($_GET["doublon"]) && $_GET["doublon"] == 1){
        $titre_page = "Doublons par région";
    }
    $page_css = "countries.css";
    include "includes/debut-page.php";

    // Check if on duplicates page
    function isDuplicates(){
        return isset($_GET["doublon"]) && $_GET["doublon"] == 1;
    }
?>

<main>
    <!-- Title and country count -->
    <section id="info">
        <h1>
        <?php
            echo (isDuplicates()) ? "Doublons par région" : "Collection par région" ;
            echo "<span>(". count(get_countries($pdo,isset($_GET["doublon"]) && $_GET["doublon"] == 1)) .")</span>" ; 
        ?>
        </h1>
    </section>
    <!-- Change country order and continent selection -->
    <section id="options">
        <h2>Options</h2>
        <div>
            <div>
                <label for="order">Ordre: </label>
                <select id="order">
                    <option>Capsules</option>
                    <option>Alphabétique</option>
                </select>
            </div>
            <div>
                <label for="continent">Continent: </label>
                <select id="continent">
                    <option>Tous</option>
                    <option value="Afrique">Afrique</option>
                    <option value="Amérique">Amérique</option>
                    <option value="Asie">Asie</option>
                    <option value="Europe">Europe</option>
                    <option value="Océanie">Océanie</option>
                </select>
            </div>
        </div>
    </section>
    <!-- List of countries -->
    <section id="countries">
        <h2>Liste des pays</h2>
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
