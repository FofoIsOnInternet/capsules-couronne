<?php
    $titre_page = "Acceuil";
    $page_css = "acceuil.css";
    include "includes/debut-page.php";
?>

<main>
    <div>
        <?php
        // Random set of caps
            $capsules = get_random_crown_caps($pdo);
            foreach($capsules as $cap){
                echo "<a class='crown' href='./cap.php?id=". $cap["codeCapsule"] ."' target='_blank'>";
                    echo "<img src='" . to_valid_img_url(get_crown_cap_images($pdo,$cap["codeCapsule"])[0][0],"Capsule") . "'>";
                echo "</a>";
            }
        ?>
    </div>
    <div>
        <!-- main content -->
        <div>
            <div>
                <!-- welcome message -->
                <h1>Bienvenue !</h1>
                <p>Cette collection compte à ce jour <b><?php echo total_crown_caps($pdo); ?></b> capsules !</p>
                <p>Merci à toutes les personnes qui ont participé de près ou de loin à cette collection ! :)</p>
            </div>
            <div>
                <!-- Quick navigation links -->
                <h1>Naviguer</h1>
                <div>
                    <a href="./crown_caps.php">Parcourrir la collection</a>
                    <a href="./countries.php">Les régions</a>
                    <a href="">Les séries</a>
                </div>
                <div>
                    <a href="./crown_caps.php?doublon=1">Consulter mes doublons</a>
                    <a href="./echange.php">Echanger avec moi</a>
                </div>
                <!-- Search bar -->
                <div>
                    <input id="search" placeholder="Rechercher une capsule dans la collection (texte, mots clé)" name="query">
                    <button type="button"><img src="./images/icones/search.png" alt="search button icon"></button>
                </div>
            </div>
        </div>
        <div>
            <!-- series of bubbles on the right-->
            <div>
                <h1>Stats</h1>
                <table>
                    <tbody>
                        <tr><th><?php echo total_crown_caps($pdo); ?></th><td>Capsules</td></tr>
                        <tr><th><?php echo count(get_countries($pdo)); ?></th><td>Pays</td></tr>
                        <tr>
                            <th><?php echo get_countries($pdo)[0]["nbCapsules"]; ?></th>
                            <td>
                                <?php echo "<img src='images/drapeaux/" . get_countries($pdo)[0]['isoAlpha2']  . ".png'>"; 
                                      echo get_countries($pdo)[0]["nomPaysFR"];  ?>
                            </td>
                        </tr>
                        <tr><th><?php echo total_duplicates($pdo); ?></th><td>Doublons</td></tr>
                        <tr><th><?php echo count(get_trades($pdo)); ?></th><td>Echanges</td></tr>
                    </tbody>
                </table>
            </div>
            <div>
            <h1>Aléatoire</h1>
            <?php
            // Random set of caps
            $capsules = get_random_crown_caps($pdo,3);
            foreach($capsules as $cap){
                echo "<a class='crown' href='./cap.php?id=". $cap["codeCapsule"] ."' target='_blank'>";
                    echo "<img src='" . to_valid_img_url(get_crown_cap_images($pdo,$cap["codeCapsule"])[0][0],"Capsule") . "'>";
                echo "</a>";
            }
        ?>
            </div>
        </div>
    </div>
</main>
<script src="scripts/acceuil.js"></script>
<?php
    include  "includes/fin-page.php";
?>
