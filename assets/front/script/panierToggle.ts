
function togglePanier() {
    let panierToggle: Element = document.querySelector(".lna_shop");
    let panier: Element = document.querySelector(".myModal");

    if (panierToggle && panier) {
        panierToggle.addEventListener("click", (e: Event) => {

            if (panier.classList.contains("d-none")){
                panier.classList.remove("d-none");
                panier.classList.add("is-activated");
            }else {
                panier.classList.add("d-none");
                panier.classList.remove("is-activated");
            }
            e.stopImmediatePropagation();
        });

        // On ajoute un évènement click sur le document pour fermer le offcanva
        document.addEventListener('click', function(event: any): void {
                // Si on clique en dehors du offcanva on lance la fonction closeModal
                if (!event.target.closest('.is-activated')) {
                    let panierToggle: Element = document.querySelector(".is-activated");
                    if (panierToggle){
                        panierToggle.classList.add('d-none');
                    }
                }
            },
            false
        )
    }
}


window.addEventListener('load', () => {
    togglePanier();
});