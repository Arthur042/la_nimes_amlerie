<footer>
    <div class="container">
        <div class="paiement_delivery">
            <div>
                <p class="lna_footer_safe">Paiement sécurisé</p>
                <div class="payment"><span class="d-none">moyen de paiement</span></div>
            </div>
            <div>
                <p class="lna_footer_delivery">Expédition en 48h</p>
                <div class="chrono"><span class="d-none">livraison chronoposte</span></div>
                <div class="poste"><span class="d-none">livraison la poste</span></div>
            </div>
        </div>
        <div class="newsletter">
            <p>Abonnez-vous à notre <b>newletter</b> pour ne rien rater !</p>
            <form action="" method="get">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="emailNewsLetter" id="emailNewsLetter" name="emailNewsLetter" class="form-control"
                            placeholder="exemple@email.com" maxlength="70" />
                        <label class="form-label d-none" for="emailNewsLetter">barre de recherche</label>
                    </div>
                    <button type="button" class="btn lna_btn_fade">
                        <img src="img/icon/footer/send.svg" alt="">
                    </button>
                </div>
            </form>
        </div>
        <div class="row">
            <div class="footer_link d-sm-flex">
                <div class="col-sm-4">
                    <p><b>Nos services</b></p>
                    <hr>
                    <a href="#">Aide et FAQ</a>
                    <a href="#">L'espace service</a>
                    <a href="#">Mon compte</a>
                    <a href="#">Mes commandes</a>
                    <a href="#">Newsletter</a>
                </div>
                <div class="col-sm-4">
                    <p><b>Vos avantages</b></p>
                    <hr>
                    <a href="#">Service client</a>
                    <a href="#">Paiement sécurisé</a>
                    <a href="#">Régimes VET</a>
                </div>
                <div class="col-sm-4">
                    <p><b>À propos</b></p>
                    <hr>
                    <a href="#">La Nîmes'alerie France</a>
                    <a href="#">Recrutement</a>
                </div>
            </div>
            <div class="social_link">
                <a href="#" class="social_img in"></a>
                <a href="#" class="social_img ln"></a>
                <a href="#" class="social_img fb"></a>
            </div>
        </div>
    </div>
    <div class="banner"></div>

</footer>
<?php
// Import de script js ----------------------------------------------------------------------------------------------------
        @include 'component/footer/scriptJs.php';
?>