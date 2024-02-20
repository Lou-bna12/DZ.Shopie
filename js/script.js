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
  // Récupérer l'élément avec l'ID 'cookie-notification'
  var notification = document.getElementById('cookie-notification');

  // Vérifier si l'élément existe avant d'essayer d'accéder à sa propriété 'style'
  if (notification) {
    // Définir la propriété 'display' sur 'flex'
    notification.style.display = 'flex';
  }
}

// Fonction pour définir le cookie 'cookiesAccepted' lors de l'acceptation
function acceptCookies() {
  // Définir une durée de validité du cookie
  var expiration = new Date();
  expiration.setTime(expiration.getTime() + 1 * 60 * 60 * 1000);

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

  // Masquer la notification
  document.getElementById('cookie-notification').style.display = 'none';

  // Définir un cookie pour enregistrer le refus des cookies
  document.cookie =
    'cookiesRejected=true; expires=' + getExpirationTime(1) + '; path=/';
}

// Fonction pour obtenir le temps d'expiration du cookie
function getExpirationTime(hours) {
  var expiration = new Date();
  expiration.setTime(expiration.getTime() + hours * 60 * 60 * 1000);
  return expiration.toUTCString();
}

// Fonction pour obtenir la valeur d'un cookie par son nom
function getCookie(cookieName) {
  var name = cookieName + '='; // Crée une chaîne 'name' qui sera utilisée pour rechercher le cookie dans la liste des cookies.
  var cookies = document.cookie.split(';'); //Divise la chaîne complète de tous les cookies en parties individuelles en utilisant le point-virgule comme délimiteur. Cela crée un tableau (cookies) contenant chaque cookie comme élément.
  for (var i = 0; i < cookies.length; i++) {
    //une boucle à travers chaque partie des cookies.
    var cookie = cookies[i].trim(); //Pour chaque partie, supprime les espaces en début et fin avec la méthode trim().
    if (cookie.indexOf(name) === 0) {
      //Vérifie si la partie commence par la chaîne 'name' (le nom du cookie recherché)
      return cookie.substring(name.length, cookie.length); //Si le cookie est trouvé, retourne la valeur du cookie (substring après le nom).
    }
  }
  return null; //Si la boucle se termine sans trouver le cookie, retourne null.
}
