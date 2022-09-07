
interface ItemQty {
    gameId: string;
    qty: number;
}

interface ResponseCart {
    qtyTotale: string;
}

function setUpClickEventAddItem(): void {
    const buttons: NodeListOf<HTMLButtonElement> = document.querySelectorAll('[data-game-id]');
    if (buttons) {
        buttons.forEach((btn) => {
            btn.addEventListener('click', () => {
                const gameId: string = btn.getAttribute('data-game-id');
                const select: HTMLSelectElement = document.querySelector("[data-input-add-game='"+gameId+"']");
                let inputQty: string = select.value;
                let datasToSend: ItemQty = {
                    gameId,
                    qty: Number(inputQty)
                };
                fetch('/ajax/addItemToCart/' + JSON.stringify(datasToSend))
                    .catch((e) => {
                        console.log('error' + e);
                    })
                    .then((response: Response) => {
                        return response.json() as Promise<ResponseCart>;
                    })
                    .then((data) => {
                        const qtyCart: HTMLParagraphElement = document.querySelector('[data-cart-item]');
                        qtyCart.innerText = data.qtyTotale;
                    });
            });
        });
    }
}

window.addEventListener('load', () => {
    setUpClickEventAddItem();
});