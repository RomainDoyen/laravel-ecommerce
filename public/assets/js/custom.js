// Code to show and hide password
const eyeIcon = document.getElementById('eyeIcon');
const eyeSlashIcon = document.getElementById('eyeSlashIcon');
const passwordField = document.getElementById('passwordField');

function showPassword() {
    eyeIcon.style.display = 'none';
    eyeSlashIcon.style.display = 'inline';
    passwordField.type = 'text';
}

function hidePassword() {
    eyeSlashIcon.style.display = 'none';
    eyeIcon.style.display = 'inline';
    passwordField.type = 'password';
}

eyeIcon?.addEventListener('click', showPassword);

eyeSlashIcon?.addEventListener('click', hidePassword);

// owl carousel
$(document).ready(function(){
    $(".owl-carousel").owlCarousel({
        items: 3, // Nombre d'éléments visibles
        loop: true, // Activer le défilement en boucle
        margin: 10, // Espacement entre les éléments
        nav: true, // Activer les flèches de navigation
        navText: ["❮", "❯"], // Personnalisation des flèches
        responsive: {
            0: {
                items: 1 // Sur mobile : 1 élément visible
            },
            768: {
                items: 2 // Sur tablette : 2 éléments visibles
            },
            1024: {
                items: 3 // Sur ordinateur : 3 éléments visibles
            }
        }
    });
});

// to get current year
function getYear() {
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    // @ts-ignore
    document.querySelector("#displayYear").innerHTML = currentYear;
}

getYear();

// owl carousel 

// @ts-ignore
$('.owl-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    autoplay: true,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1
        },
        600: {
            items: 3
        },
        1000: {
            items: 6
        }
    }
})
