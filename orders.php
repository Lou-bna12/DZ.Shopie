<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Commandes</title>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" defer></script>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">



</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--orders section starts-->

<section class="show-orders">

    <h1 class="heading">Commandes passées</h1>

    <div class="box-container">

<?php
    if($user_id == ''){
        echo '<p class="empty">Veuillez vous connecter pour voir vos commandes</p>';
    }else{
        $show_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ?");
        $show_orders->execute([$user_id]);
        if($show_orders->rowCount() > 0){
            while($fetch_orders = $show_orders->fetch(PDO::FETCH_ASSOC)){
?>
    <div class="box">
    <p>Commandée à la date suivante : <span><?= $fetch_orders['placed_on']; ?></span></p>
    <p>Nom : <span><?= $fetch_orders['name']; ?></span></p>
    <p>Adresse e-mail : <span><?= $fetch_orders['email']; ?></span></p>
    <p>Numéro de téléphone : <span><?= $fetch_orders['number']; ?></span></p>
    <p>Adresse : <span><?= $fetch_orders['address']; ?></span></p>
    <p> Mode de paiement : <span><?= $fetch_orders['method']; ?></span></p>
    <p> Vos commandes : <span><?= $fetch_orders['total_products']; ?></span></p>
    <p>Prix total : <span><?= $fetch_orders['total_price']; ?> €</span></p>
    <p>Statut du paiement : <span style="color:<?php if($fetch_orders['payment_status'] == 'En attente')
    { echo 'red'; }else{ echo 'green'; }; ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
</div>
<?php
    }
    }else{
        echo '<p class="empty">Aucune commande n\'a encore été passée !</p>';
    }
    }
?>

</div>

</section>

<!--orders section ends-->

<!-- Ajout la div pour afficher la carte -->
<div id="map" style="height: 400px;"></div>

<script>
function initMap() {
    // Coordonnées de la position initiale (par exemple, Algérie)
    var myLatLng = [28.0339, 1.6596];

    // Créer une carte centrée sur la position initiale
    var map = L.map('map').setView(myLatLng, 5);

    // Ajouter une couche OpenStreetMap à la carte
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // Ajouter un marqueur à la position initiale
    L.marker(myLatLng).addTo(map)
    .bindPopup('Exemple de position').openPopup();
}

  // Initialiser la carte lors du chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    initMap();
});
</script>

<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>