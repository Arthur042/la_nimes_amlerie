<?php
    $marks = [
        "royal.png",
        "aquatlantis.png",
        "bebesaurus.png",
        "japhy.png",
        "pedigree.png",
        "proplan.png",
    ];
    $nbmark = count($marks);

    for($i = 0; $i < $nbmark; $i++) {
        ?>
        <div class="lna_card <?php @include 'component/markCard/markDisplay.php' ?>">
            <img src="img/mark/<?=$marks[$i]?>" alt="logo de marques">
        </div>
        <?php
    }
?>
