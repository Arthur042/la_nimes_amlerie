let togglePassword: Element = document.querySelector("#togglePassword");
let password: Element = document.querySelector("#password");

if (password && togglePassword) {
    togglePassword.addEventListener("click", function (): void {
        // change le type de l'input pour afficher le mdp en clair ou caché
        let type: string = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);
        
        // change la classe du boutton pour changer l'icone
            if (this.classList.contains('hide')) {
                this.classList.remove('hide');
                this.classList.toggle('see');
            } else{
                this.classList.remove('see');
                this.classList.toggle('hide');
            }
    });
}