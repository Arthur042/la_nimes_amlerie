
function toggleModal(){
    const gestionCompte: HTMLDivElement = document.querySelector('.connected');
    const modal: HTMLDivElement = document.querySelector('.gestionDeCompteModal');

    if(gestionCompte && modal){
        gestionCompte.addEventListener("click", (e: Event) => {
            e.preventDefault();
            if (modal.classList.contains("d-none")){
                modal.classList.remove("d-none");
                modal.classList.add("is-compte-activated");
            }else {
                modal.classList.add("d-none");
                modal.classList.remove("is-compte-activated");
            }
            e.stopImmediatePropagation();
        });

        // On ajoute un évènement click sur le document pour fermer la modal
        document.addEventListener('click', function(event: any): void {
                // Si on clique en dehors du offcanva on lance la fonction closeModal
                if (!event.target.closest('.is-compte-activated')) {
                    let gestionCompte: Element = document.querySelector(".is-compte-activated");
                    if (gestionCompte){
                        gestionCompte.classList.add('d-none');
                    }
                }
            },
            false
        )
    }
}


window.addEventListener('load', () => {
    toggleModal();
});