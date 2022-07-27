
<div class="lna_product_item <?php @include 'component/productCard/displayCard.php' ?>">
    <a href="product.html">
        <div class="lna_card_img">
            <img src="<?=$products[$i]->getImage();?>" alt="image d'un produit">
        </div>
    </a>
    <div class="lna_card_body">
        <h3><?=$products[$i]->getTitle();?></h3>
        <div class="lna_comment">
            <?php
                @include 'starNote.php';  // On inclut le snippet starNote.php
            ?>
            <p><?=$products[$i]->getNbNote();?> avis</p>
        </div>
        <p><?=$products[$i]->getPrice();?></p>
        <a href="#" class="lna_btn_main lna_btn_product lna_btn_dark">Ajouter</a>
    </div>
</div>