// Función que filtra los propietarios por nombre
function filtrarPropietarios() {
    let input = document.getElementById('filtro').value.toLowerCase();
    let cards = document.getElementById('propietarios').getElementsByClassName('col');

    for (let i = 0; i < cards.length; i++) {
        let title = cards[i].getElementsByClassName('card-title')[0].textContent.toLowerCase();

        if (title.includes(input)) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}

// Agregar el evento de búsqueda cuando el usuario escribe en el campo de filtro
document.getElementById('filtro').addEventListener('keyup', filtrarPropietarios);
