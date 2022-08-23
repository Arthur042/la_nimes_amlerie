
function toggleModal(){
    const gestionCompte: HTMLDivElement = document.querySelector('.connected');

    if(gestionCompte){
        const modal: HTMLDivElement = document.querySelector('.gestionDeCompteModal');

        gestionCompte.addEventListener('click', function(e: MouseEvent): void {
            e.preventDefault();
            if(modal.classList.contains('d-none')){
                modal.classList.remove('d-none')
            } else {
                modal.classList.add('d-none')
            }
        })
    }
}


window.addEventListener('load', () => {
    toggleModal();
});