document.getElementById('searchInput').addEventListener('input', function (e) {
    const query = e.target.value;
    const resultsContainer = document.querySelector('.search-results-container');

    if (query.trim() === '') {
        resultsContainer.innerHTML = '';
        return;
    }

    fetch(`/search?query=${encodeURIComponent(query)}`)
        .then(response => response.text())
        .then(data => {
            resultsContainer.innerHTML = data;
        })
        .catch(error => {
            console.error('Erreur lors de la recherche:', error);
        });
});

const searchIcon = document.getElementById('searchIcon');
const searchInput = document.getElementById('searchInput');
const checkbox = document.querySelector('.checkbox');
const searchContainer = document.getElementById('searchContainer');

function showSearchInput() {
    checkbox.checked = true;
    searchInput.focus();
}

function hideSearchInput() {
    checkbox.checked = false;
}

searchIcon?.addEventListener('click', showSearchInput);

searchInput?.addEventListener('blur', hideSearchInput);

document.addEventListener('click', function (e) {
    if (!searchContainer.contains(e.target)) {
        hideSearchInput();
    }
});

// Code to show and hide password
function toggleForm(reviewId) {
    const form = document.getElementById(`edit-form-${reviewId}`);
    const closeButton = document.getElementById(`close-form-${reviewId}`);

    if (form.style.display === 'none') {
        form.style.display = 'block';
        closeButton.style.display = 'inline-block';
    } else {
        form.style.display = 'none';
        closeButton.style.display = 'none';
    }
}

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
