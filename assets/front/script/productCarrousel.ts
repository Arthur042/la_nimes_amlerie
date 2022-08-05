
function slideLeft(carrousel){
    // if classList.contains('zero')
    if(carrousel.classList.contains('thirty')){
        carrousel.classList.remove('thirty');
        carrousel.classList.add('zero');
    }else if (carrousel.classList.contains('sixty')){
        carrousel.classList.remove('sixty');
        carrousel.classList.add('thirty');
    }
}

function slideRight(carrousel){
    if(carrousel.classList.contains('zero')){
        carrousel.classList.remove('zero');
        carrousel.classList.add('thirty');
    }else if (carrousel.classList.contains('thirty')){
        carrousel.classList.remove('thirty');
        carrousel.classList.add('sixty');
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