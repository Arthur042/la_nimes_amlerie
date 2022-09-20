
function selectFilterInput() {
    const inputLeft : HTMLInputElement = document.querySelector('#front_product_filter_priceHt_left_number')
    const inputRight : HTMLInputElement = document.querySelector('#front_product_filter_priceHt_right_number')

    if (inputLeft && inputRight) {
        inputLeft.setAttribute('placeholder', '0')
        inputRight.setAttribute('placeholder', '1000')
    }
}

window.addEventListener('load', () => {
    selectFilterInput();
});