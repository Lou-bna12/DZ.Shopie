if (typeof navbar === 'undefined') {
  var navbar = document.querySelector('.header .flex .navbar');
}

if (typeof profile === 'undefined') {
  var profile = document.querySelector('.header .flex .profile');
}

document.querySelector('#menu-btn').onclick = () => {
  navbar.classList.toggle('active');
  profile.classList.remove('active');
};

document.querySelector('#user-btn').onclick = () => {
  profile.classList.toggle('active');
  navbar.classList.remove('active');
};

window.onscroll = () => {
  navbar.classList.remove('active');
  profile.classList.remove('active');
};

if (typeof subImages === 'undefined') {
  var subImages = document.querySelectorAll(
    '.quick-view .box .image-container .small-images img'
  );
}

if (typeof mainImage === 'undefined') {
  var mainImage = document.querySelector(
    '.quick-view .box .image-container .big-image img'
  );
}

subImages.forEach((images) => {
  images.onclick = () => {
    src = images.getAttribute('src');
    mainImage.src = src;
  };
});

document.addEventListener('DOMContentLoaded', function () {
  // Vérifier si le cookie 'cookiesAccepted' est présent
  if (!getCookie('cookiesAccepted')) {
    // Le cookie n'est pas présent, afficher la notification
    showCookiesNotification();
  }
});

// Fonction pour afficher la notification des cookies
function showCookiesNotification() {
  var notification = document.getElementById('cookie-notification');
  notification.style.display = 'flex'; // j'ai Utilisé 'flex' pour une meilleure disposition
}

// Fonction pour définir le cookie 'cookiesAccepted' lors de l'acceptation
function acceptCookies() {
  // Définir une durée de validité du cookie (par exemple, 30 jours)
  var expiration = new Date();
  expiration.setTime(expiration.getTime() + 6 * 60 * 60 * 1000);

  // Créer un cookie avec le nom 'cookiesAccepted' et la valeur 'true'
  document.cookie =
    'cookiesAccepted=true; expires=' + expiration.toUTCString() + '; path=/';

  // Masquer la notification une fois les cookies acceptés
  document.getElementById('cookie-notification').style.display = 'none';
}

// Fonction pour rejeter les cookies (vous pouvez ajuster cela selon vos besoins)
function rejectCookies() {
  // Ajoutez le code pour gérer le rejet des cookies ici
  alert("Vous avez refusé l'utilisation des cookies.");
  document.getElementById('cookie-notification').style.display = 'none';
}

// Fonction pour obtenir la valeur d'un cookie par son nom
function getCookie(cookieName) {
  var name = cookieName + '=';
  var cookies = document.cookie.split(';');
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i].trim();
    if (cookie.indexOf(name) === 0) {
      return cookie.substring(name.length, cookie.length);
    }
  }
  return null;
}
