
interface ItemQty {
    productId: string;
    qty: number;
}

interface ResponseCart {
    qtyTotale: string;
}

function setUpClickEventAddItem(): void {
    const buttons: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-product-id]');
    if (buttons) {
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const productId: string = btn.getAttribute('data-product-id');
                const select: HTMLSelectElement = document.querySelector("[data-input-add-product='"+productId+"']");
                let inputQty: string = select.value;
                let datasToSend: ItemQty = {
                    productId,
                    qty: Number(inputQty)
                };
                fetch('/ajax/addItemToCart/' + JSON.stringify(datasToSend))
                    .catch((e) => {
                        console.log('error' + e);
                    })
                    .then((response: Response) => {
                        const link: string = btn.getAttribute('data-page-link');
                        window.location.replace(link);
                    });
            });
        });
    }
}

window.addEventListener('load', () => {
    setUpClickEventAddItem();
});