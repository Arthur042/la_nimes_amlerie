function displaySearchBar() {
    // HTMLInputElement peut changer en fonction du type d'élément HTML que vous souhaitez récupérer
    const div: HTMLDivElement = document.querySelector('#returnSearchData');
    // On vérifit s'il existe, afin de ne pas avoir d'erreur JS sur la page
    if (div) {
        // On ajoute un évènement click sur le document pour fermer la modal
        document.addEventListener('click', function(event: any): void {
                // Si on clique en dehors du offcanva on lance la fonction closeModal
                if (!event.target.closest('#returnSearchData')) {
                    div.style.display = 'none';
                }
            },
            false
        )
    }
}

window.addEventListener('load', () => {
    displaySearchBar();
});