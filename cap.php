<?php
    $titre_page = "Capsule";
    $page_css = "cap.css";
    include "includes/debut-page.php";

    // Récupère les infos de la capsule
    $cap_info = get_crown_cap_info($pdo,$_GET["id"]);
    // Ses images
    $images = get_crown_cap_images($pdo,$_GET["id"]);
    // Ses étiquette
    $labels = get_crown_cap_labels($pdo,$_GET["id"]);
    // Les infos du pays 
    $country_info = get_country_info($pdo,$cap_info["isoAlpha2"]);
?>

<main>
    <h1>Capsule n° <?php echo $_GET["id"]; ?></h1>
    <div>
        <section id="main-info">
            <?php
            // Pays et date
            echo "<a href='./crown_caps.php?country=" . $country_info["isoAlpha2"] . "'>";
                if(isset($cap_info['isoAlpha2'])){
                    echo "<img src='images/drapeaux/" . $country_info['isoAlpha2']  . ".png'>";
                    echo "<span>" . $country_info["nomPaysFR"];
                    if(isset($cap_info['anneeParution'])){
                        echo " - ";
                    }else{
                        echo "</span>";
                    }
                }
                if(isset($cap_info['anneeParution'])){
                    echo $cap_info['anneeParution'] . "</span>";
                }
            echo "</a>";
            // étiquettes ici labels
            echo "<div>";
                foreach($labels as $l){
                    echo "<span class='label' title='" . $l["libeleEtiquette"] ."'><img class='label' src='images/icones/" . $l["imageEtiquette"] . "' alt='" . $l["libeleEtiquette"] ."'></span>"  ;
                }
            echo "</div>";
            ?>
            <table><tbody>
                <?php
                    // Texte, texte jupe et marque de fabrique
                    if(isset($cap_info['texteCapsule']) && strlen($cap_info['texteCapsule']) > 0){
                        echo "<tr><th>Texte: </th><td>" . $cap_info["texteCapsule"] . "</td></tr>";
                    }
                    if(isset($cap_info['texteJupe']) && strlen($cap_info['texteJupe']) > 0){
                        echo "<tr><th>Texte couronne: </th><td>" . $cap_info["texteJupe"] . "</td></tr>";
                    }
                    if(isset($cap_info['codeFabriquant']) && strlen($cap_info['codeFabriquant']) > 0){
                        echo "<tr><th>Marque de fabrique: </th><td><img class='fs' src='images/fabriquants/" . $cap_info["imageSymbole"] . "'></td></tr>";
                    }
                ?>
            </tbody></table>
        </section>
        <section id="images">
            <?php
                // les images
                foreach($images as $img){
                    if($img["estPrincipal"]){
                        $class = "primary-cap";
                    }else{
                        $class = "cap";
                    }
                    echo "<img class='".$class."' src='" . to_valid_img_url($img["ImageCapsule"],"Capsule") . "'>";
                }
            ?>
        </section>
    </div>
    <section id="secondary-info">
        <?php
            // Commentaire
            if(isset($cap_info['commentaire']) && strlen($cap_info['commentaire']) > 0){
                echo "<div><span>Commentaire: </span><span>" . $cap_info["commentaire"] . "</span></div>";
            }
        ?>
    </section>
</main>
<script>
    document.title = "Capsule n° <?php echo $_GET["id"]; ?>";
</script>
<?php
    include  "includes/fin-page.php";
?>