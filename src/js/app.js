document.addEventListener('DOMContentLoaded', () => {

    eventListener();
    darkMode();
    dropMenu();
   

})


function dropMenu() {
    let dropMenu = document.querySelector('.nav-login-boton')
    dropMenu.addEventListener('mouseenter', menuLogin)

}


function darkMode() {

    let preferencia = window.matchMedia('prefers-color-scheme: dark')

    //console.log(preferencia.matches)

    if (preferencia.matches) {
        document.body.classList.add('dark-mode')
    } else {
        document.body.classList.remove('dark-mode')

    }

    preferencia.addEventListener('change', () => {

        if (preferencia.matches) {
            document.body.classList.add('dark-mode')
        } else {
            document.body.classList.remove('dark-mode')

        }
    })

    let btndark = document.querySelector('.dark-mode-boton')

    btndark.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode')

    })
}


function eventListener() {
    let mobileMenu = document.querySelector('.mobile-menu')

    mobileMenu.addEventListener('click', navResponsive)

    //Muestrea campos condicionales
    const metodoCOntacto = document.querySelectorAll('input[name="contacto[contacto]"]');

    metodoCOntacto.forEach(input => input.addEventListener('click', mostrarMetodoContacto));



}



function navResponsive() {
    let nav = document.querySelector('.navegacion')
    nav.classList.toggle('mostrar') // Muestra o elimina contenido
}


function menuLogin() {

    let optionsMenu = document.querySelector('.nav-enlace-login')

    optionsMenu.classList.toggle('mostrarLogin')

    setTimeout(() => {
        optionsMenu.classList.remove('mostrarLogin')
    }, 8000);

}


function mostrarMetodoContacto(e) {
    const contactoDiv = document.querySelector('#contacto');  

  

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
         <br>   
        <label for="tel">Telefono:</label>
        <input type="tel" placeholder="Tu Telefono" id="tel" name="contacto[tel]" required>

        <p>Elija la fecha y la hora para la llamada</p>

        <label for="date">Fecha:</label>
        <input type="date" id="date" name="contacto[fecha]">

        <label for="time">Hora:</label>
        <input type="time" id="time" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
        <br>
        <label for="email">E-mail:</label>
            <input type="email" placeholder="Tu E-mail" id="email" name="contacto[email]" required>
        `;

    }
}


