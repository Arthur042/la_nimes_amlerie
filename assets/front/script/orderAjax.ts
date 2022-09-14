interface Paiement {
    paiement: string;
}

function setUpClickEventValidateCart() {
    const buttons: HTMLLinkElement = document.querySelector('[data-button-order]');
    if (buttons) {
        buttons.addEventListener('click', function(e:MouseEvent) {
            e.preventDefault();
            const div: HTMLDivElement = document.querySelector('.paiementActive');
            const paiement: string = div.getAttribute('data-select-paiement');
            let datasToSend: Paiement = {
                paiement: paiement
            };
            window.location.replace('/checkout/validateCart/' + JSON.stringify(datasToSend));
        });
    }
}

window.addEventListener('load', () => {
    setUpClickEventValidateCart();
});