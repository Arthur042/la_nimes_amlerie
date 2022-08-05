let closeOffcanvas: Element = document.querySelector('.offcanvasCloseBtn');
let windowOffcanva: Element = document.querySelector('#offcanvasRight');

if(closeOffcanvas && windowOffcanva) {
    // Create class SecondeOffCanvas with constructor
        class SecondeOffCanvas {
            constructor(public id: string, public name: Element) {
                this.id = id;
                this.name = name;
            }
        }

    // je récupère les boutton qui toggle les sous catégories dans un objet relié au nom de la class du ogffcanvas de la sous catégorie
    let secondOffcanvas: Array<SecondeOffCanvas> = [{
            id: '.offcanvasDog',
            name: document.querySelector('#toggleDog')
        },
        {
            id: '.offcanvasCat',
            name: document.querySelector('#toggleCat')
        },
        {
            id: '.offcanvasRabbit',
            name: document.querySelector('#toggleRabbit')
        },
        {
            id: '.offcanvasFish',
            name: document.querySelector('#toggleFish')
        },
        {
            id: '.offcanvasTurtle',
            name: document.querySelector('#toggleTurtle')
        },
        {
            id: '.offcanvasBird',
            name: document.querySelector('#toggleBird')
        }
    ];

    /**
     * Fonction qui ouvre les offcanvas contenant les sous catégories
     * si on clique sur le boutton d'une autre sous catégorie, on ouvre le offcanvas correspondant et on ferme l'ancien
     * si on clique sur le même boutton, on ferme le offcanvas
     * @param {string} canvas 
     */
    function toggleCanvas(canvas: string): void {
        let canvastoToggle:Element = document.querySelector(canvas); // je récupère le offcanvas à ouvrir grace à sa class
        let offcanvasActivated: Element = document.querySelector('.isActivated'); // je récupère le offcanvas actif

        if (offcanvasActivated === canvastoToggle) { // si le offcanvas à ouvrir est le même que celui actif, on ferme le offcanvas
            canvastoToggle.setAttribute("style", "right: -400px;");
            canvastoToggle.classList.remove('isActivated');
        } else if (offcanvasActivated) { // si un offcanvas est actif, on ferme le offcanvas actif
            offcanvasActivated.classList.remove('isActivated');
            offcanvasActivated.setAttribute("style", "right: -400px;");
            if (canvastoToggle) { // si on a fermé un offcanva et qu'on a cliqué sur un autre, on ouvre le nouveau
                canvastoToggle.setAttribute("style", "right: 0px;");
                canvastoToggle.classList.add('isActivated');
            }
        } else { // si aucun offcanvas n'est actif, on ouvre le offcanvas à ouvrir
            canvastoToggle.setAttribute("style", "right: 0px;");
            canvastoToggle.classList.add('isActivated');
        }
    }



    /**
     * Fontion qui ferme le offcanva ouvert lorsqu'on clique en dehors du offcanva
     */
    function closeMobileSecondOffcanvas(): void {
        let offcanvaToClose: Element = document.querySelector('.isActivated');
        if (offcanvaToClose) {
            offcanvaToClose.classList.remove('isActivated');
            offcanvaToClose.setAttribute("style", "right: -400px;");
        }
    }


    // je fais une boucle pour ajouter un évènement click sur chaque boutton de la sous catégorie
    secondOffcanvas.forEach(element => {
        element.name.addEventListener('click', function (): void {
            toggleCanvas(element.id);
        })
    })


    // Fonction qui ferme les offcanvas contenant les sous catégories lorsque l'on clique sur le boutton close
    closeOffcanvas.addEventListener('click', function (): void {
        let offcanvasActivated = document.querySelector('.isActivated');
        if (offcanvasActivated) {
            offcanvasActivated.classList.remove('isActivated');
            offcanvasActivated.setAttribute("style", "right: -400px;");
        }
    });

    // On ajoute un évènement click sur le document pour fermer le offcanva
    windowOffcanva.addEventListener('click', function (event: any): void {
            // Si on clique en dehors du offcanva on lance la fonction closeMobileSecondOffcanvas
            if (!event.target.closest('.toClosejsOffcanvas') && !event.target.closest('.secondCanvas')) {
                closeMobileSecondOffcanvas();
            }
        },
        false
    )
}