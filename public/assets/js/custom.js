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
