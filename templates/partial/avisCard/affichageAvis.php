<?php
    @include_once 'class/Avis.php';

    $nbAvis = count($avis);

    for($i = 0; $i < $nbAvis; $i++) {
        @include 'component/avisCard/avisCard.php';
    }

?>