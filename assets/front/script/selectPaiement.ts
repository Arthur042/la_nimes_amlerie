
function selectDivPaiement(): void{

    let paiementCard: NodeListOf<HTMLDivElement> =  document.querySelectorAll("[data-select-paiement]");

    if(paiementCard) {
        paiementCard.forEach(element => {
            let dataName = element.getAttribute('data-select-paiement')
            element.addEventListener('click', function(event: MouseEvent): void {
                toggleDivPaiement(dataName);
                disabledButton(paiementCard);
            })
        })
    }
}

/**
 * Fonction qui récupère la div selectionné au click ainsi que la div activé si il y en a une
 * si on clique sur une div différente de cell active, on active la div correspondant et on déasactive l'ancien
 * si on clique sur la même div, on la désactive
 * @param {string} dataName
 */
function toggleDivPaiement(dataName){
    let divToToggle: HTMLDivElement = document.querySelector("[data-select-paiement='"+dataName+"']");
    let divActivated: HTMLDivElement = document.querySelector(".paiementActive");

    if(divActivated === divToToggle) {
        divToToggle.classList.remove('paiementActive');
    } else if(divActivated) {
        divActivated.classList.remove('paiementActive');
        if(divToToggle) {
            divToToggle.classList.add('paiementActive');
        }
    } else {
        divToToggle.classList.add('paiementActive');
    }
}

/**
 * Fonction qui au click sur une div de paiement va vérifier si un moyen de paiement est sélectionné
 * si c'est le cas le boutton de commande sera actif sinon on le désactive
 */
function disabledButton(paiementCard) {
    let divToCheck: NodeListOf<HTMLDivElement> = paiementCard;
    let paiementSelect: boolean = false;
    divToCheck.forEach(element => {
        if(element.classList.contains('paiementActive')) {
            paiementSelect = true
        }
    })

    let btnToActivate: HTMLButtonElement = document.querySelector('[data-button-order]')
    if(paiementSelect) {
        btnToActivate.classList.remove('btn')
        btnToActivate.classList.remove('disabled')
    } else {
        btnToActivate.classList.add('btn')
        btnToActivate.classList.add('disabled')
    }
}


window.addEventListener('load', () => {
    selectDivPaiement();
});