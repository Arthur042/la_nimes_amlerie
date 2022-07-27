<?php
    @include_once 'class/Product.php';

    $nbProduct = count($products);

    for($i = 0; $i < $nbProduct; $i++) {
        @include 'component/productCard/productCard.php';
    }

?>