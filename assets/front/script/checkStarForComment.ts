
function findInput() {
    const label: NodeListOf<HTMLLabelElement> = document.querySelectorAll('.form-check-label');
    if (label) {
        label.forEach(element => {
            element.addEventListener('click', () => {
                label.forEach(element => {
                    if (element.classList.contains('activeToo')) {
                        element.classList.remove('activeToo')
                    }
                })
                selectInput(element, label);
            })
        })
    }
}

function selectInput(element, label){
    const labelActivated: HTMLLabelElement = document.querySelector('.activated')
    if (element === labelActivated) {
        element.classList.remove('activated')
    } else if(labelActivated) {
        labelActivated.classList.remove('activated');
        if(element) {
            element.classList.add('activated');
            addActivatedToo(label);
        }
    } else {
        element.classList.add('activated');
        addActivatedToo(label);
    }
}

function addActivatedToo(label) {
    let i: number = 0;
    while (!label[i].classList.contains('activated')) {
        label[i].classList.add('activeToo');
        i++
    }
}

window.addEventListener('load', () => {
    findInput();
});