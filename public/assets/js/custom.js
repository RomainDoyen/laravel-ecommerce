(function () {
  'use strict';

  const searchInput = document.getElementById('searchInput');
  const resultsContainer = document.querySelector('.search-results-container');

  if (searchInput && resultsContainer) {
    searchInput.addEventListener('input', function (e) {
      const query = e.target.value;
      if (query.trim() === '') {
        resultsContainer.innerHTML = '';
        return;
      }

      fetch('/search?query=' + encodeURIComponent(query))
        .then(function (response) {
          return response.text();
        })
        .then(function (data) {
          resultsContainer.innerHTML = data;
        })
        .catch(function (error) {
          console.error('Erreur lors de la recherche:', error);
        });
    });
  }

  const searchIcon = document.getElementById('searchIcon');
  const checkbox = document.querySelector('.checkbox');
  const searchContainer = document.getElementById('searchContainer');

  function showSearchInput(e) {
    e.stopPropagation();
    if (checkbox) checkbox.checked = true;
    if (searchInput) searchInput.focus();
  }

  function hideSearchInput(e) {
    if (!searchIcon || !checkbox) return;
    if (searchIcon.contains(e.target)) return;
    checkbox.checked = false;
  }

  if (searchIcon) {
    searchIcon.addEventListener('click', showSearchInput);
  }
  if (searchInput) {
    searchInput.addEventListener('blur', hideSearchInput);
  }
  if (searchContainer) {
    searchContainer.addEventListener('click', function (e) {
      e.stopPropagation();
    });
  }
})();

function toggleForm(reviewId) {
  const form = document.getElementById('edit-form-' + reviewId);
  const closeButton = document.getElementById('close-form-' + reviewId);
  if (!form || !closeButton) return;

  if (form.style.display === 'none' || form.style.display === '') {
    form.style.display = 'block';
    closeButton.style.display = 'inline-block';
  } else {
    form.style.display = 'none';
    closeButton.style.display = 'none';
  }
}

(function () {
  const eyeIcon = document.getElementById('eyeIcon');
  const eyeSlashIcon = document.getElementById('eyeSlashIcon');
  const passwordField = document.getElementById('passwordField');
  if (!eyeIcon || !eyeSlashIcon || !passwordField) return;

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

  eyeIcon.addEventListener('click', showPassword);
  eyeSlashIcon.addEventListener('click', hidePassword);
})();

function getYear() {
  var el = document.querySelector('#displayYear');
  if (!el) return;
  el.textContent = new Date().getFullYear();
}
getYear();

if (typeof jQuery !== 'undefined' && jQuery.fn.owlCarousel) {
  jQuery(document).ready(function ($) {
    var $carousels = $('.owl-carousel');
    if ($carousels.length) {
      $carousels.owlCarousel({
        loop: true,
        margin: 10,
        nav: true,
        autoplay: true,
        autoplayHoverPause: true,
        navText: ['❮', '❯'],
        responsive: {
          0: { items: 1 },
          600: { items: 2 },
          1000: { items: 3 },
        },
      });
    }
  });
}
