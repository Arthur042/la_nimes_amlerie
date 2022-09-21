
function querySearchBar() {
    // HTMLInputElement peut changer en fonction du type d'élément HTML que vous souhaitez récupérer
    const input: HTMLInputElement = document.querySelector('#search');
    // On vérifit s'il existe, afin de ne pas avoir d'erreur JS sur la page
    if (input) {
        input.addEventListener('keyup', (event) => {
            // On récupère la valeur de l'input
            let value: string = input.value;
            fetch('/ajax/search/' + JSON.stringify(value))
                .then((response: Response) => {
                    return response.json() as Promise<any>;
                })
                .then(data => {
                    let results = document.getElementById('returnSearchData');
                    results.innerHTML = data.html;
                    // On change le style display none en display block
                    if (value !== '') {
                        results.style.display = 'block';
                    } else {
                        results.style.display = 'none';
                    }
                })
                .catch((e) => {
                });
        });
    }
}

window.addEventListener('load', () => {
    querySearchBar();
});