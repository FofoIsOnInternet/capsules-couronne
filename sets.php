<?php
    $titre_page = "Echanger";
    $page_css = "sets.css";
    include "includes/debut-page.php";
?>

<main>
    <section id="info">
        <h1>
            Séries de capsules
            <span>(0)</span>
        </h1>
    </section>
    <section id="options">
        <h2>Options</h2>
        <div>
            <div id="search">
                <input id="SetSearch" placeholder="Rechercher une série de capsules" name="sets">
                <button type='button' title='Effacer'><img src='images/icones/close.png'></button>
            </div>
            <div>
                <?php
                    foreach(range('a','z') as $letter){
                        echo "<a href='./sets.php#title-".$letter."' title='aller à la lettre ".$letter."' >".$letter."</a>";
                    }
                ?>
            </div>
        </div>

    </section>
    <section id="sets">
        <h2>Liste des séries</h2>
        <div>

        </div>
    </section>
</main>
<script src="scripts/display_sets.js"></script>
<?php
    include  "includes/fin-page.php";
?>
