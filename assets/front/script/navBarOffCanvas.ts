// Tableau contenant les liens de la navbar
    let buttonsCanvas : Array<Element> = [document.querySelector('#buttonToggleDog'), 
                        document.querySelector('#buttonToggleCat'), 
                        document.querySelector('#buttonToggleRabbit'),
                        document.querySelector('#buttonToggleFish'), 
                        document.querySelector('#buttonToggleBird'), 
                        document.querySelector('#buttonToggleTurtle')
                    ];

// Tableau contenant les offcanvas
    let offcanvas  : Array<Element> = [document.querySelector('.dogOffcanvaBg'),
                    document.querySelector('.catOffcanvaBg'),
                    document.querySelector('.rabbitOffcanvaBg'),
                    document.querySelector('.fishOffcanvaBg'),
                    document.querySelector('.birdOffcanvaBg'),
                    document.querySelector('.turtleOffcanvaBg')
                ];

if(buttonsCanvas && offcanvas){
    /**
     * fonction qui ouvre le offcanva sur le quel on a cliqué
     * Si on a cliqué sur un autre lien, on ferme le offcanva précédent et on ouvre le nouveau
     * Si on reclique sur le même lien, on ferme le offcanva
     * @param {string} offcanva le nom de la classe du offcanva à ouvrir
     */
    function toggleOffCanva(offcanva : Element): void {

        let isOffcanvaOpen : Element = document.querySelector('.offcanvaIsActived');
        
        if (offcanva.classList.contains('offcanvaIsActived')) {
            offcanva.classList.remove('offcanvaIsActived');
            offcanva.setAttribute("style", "top: -700px;");
        }else if (isOffcanvaOpen) {
            isOffcanvaOpen.classList.remove('offcanvaIsActived');
            isOffcanvaOpen.setAttribute("style", "top: -700px;");
            if (!offcanva.classList.contains('offcanvaIsActived')) {
                offcanva.classList.add('offcanvaIsActived');
                offcanva.setAttribute("style", "top: -57px;");
            }
        }else {
            offcanva.classList.add('offcanvaIsActived');
            offcanva.setAttribute("style", "top: -57px;");
        }
    }


    /**
     * Fontion qui ferme le offcanva ouvert lorsqu'on clique en dehors du offcanva
     */
    function closeModal(): void {
        let offcanvaToClose: Element = document.querySelector('.offcanvaIsActived');
        if (offcanvaToClose) {
            offcanvaToClose.classList.remove('offcanvaIsActived');
            offcanvaToClose.setAttribute("style", "top: -700px;");
        }
    }


    // On ajoute un évènement click sur chaque bouton de la navbar
        for (let i = 0; i < buttonsCanvas.length; i++) {
            buttonsCanvas[i].addEventListener('click', (e: Event) => {
                toggleOffCanva(offcanvas[i]);   // on lançe la fonction toggleOffCanva avec le nom de la classe du offcanva correspondant
                e.stopImmediatePropagation();   // on empêche le comportement par défaut du lien
            })
        }

    // On ajoute un évènement click sur le document pour fermer le offcanva
        document.addEventListener('click', function(e: any): void {
            // Si on clique en dehors du offcanva on lance la fonction closeModal
                if ( !e.target.closest('.offcanvas-body')) {
                    closeModal()
                }
                },
                false   
        )
}
  