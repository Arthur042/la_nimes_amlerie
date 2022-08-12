
function slideLeft(carrousel){
    let width: number = carrousel.getAttribute('data-position-carrousel');
    console.log(width);
    if (width >= 172){
        width = width - 172;
        console.log(width);

        carrousel.style.transform = 'translateX(-'+ width +'px)';

        carrousel.setAttribute('data-position-carrousel', width.toString());
    }
}

function slideRight(carrousel){
    let width: number = carrousel.getAttribute('data-position-carrousel');

    if(width <= 1204){
        width = Number(width) + 172;
        console.log(width);
        carrousel.style.transform = 'translateX(-'+ width +'px)';

        carrousel.setAttribute('data-position-carrousel', width.toString());
    }
}

function slideCaroussel(classList){
    if (classList.contains('lna_arrow_first_left') || classList.contains('lna_arrow_first_right')) {
        let carrousel: HTMLDivElement = document.querySelector('#ProductCarrousel');

        if(classList.contains('lna_arrow_first_left')){
            slideLeft(carrousel);
        } else if(classList.contains('lna_arrow_first_right')){
            slideRight(carrousel);
        }
    }

    if (classList.contains('lna_arrow_second_left') || classList.contains('lna_arrow_second_right')) {
        let carrousel: HTMLDivElement = document.querySelector('#ProductSecondCarrousel');

        if(classList.contains('lna_arrow_second_left')){
            slideLeft(carrousel);
        } else if(classList.contains('lna_arrow_second_right')){
            console.log(carrousel.classList);
            slideRight(carrousel);
        }
    }
}


function carrousel() {

    const arrayOfDivs: HTMLDivElement[] = [
        document.querySelector('.lna_arrow_first_left'),
        document.querySelector('.lna_arrow_first_right'),
        document.querySelector('.lna_arrow_second_left'),
        document.querySelector('.lna_arrow_second_right')
    ];

    if (arrayOfDivs) {
        arrayOfDivs.forEach(element => {
            element.addEventListener('click', (e: Event) => {
                slideCaroussel(element.classList);
            })
        })
    };
}


window.addEventListener('load', () => {
    carrousel();
});