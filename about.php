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
<title>À propos</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--about section starts-->

<section class="about">
    <div class="row">
        <div class="image">
            <img src="images/about-img.svg" alt="">
        </div>
    <div class="content">
        <h3>Pourquoi nous choisir ?</h3>
        <p>
        Boutique officielle en ligne SHOPI.DZ. Disponible dans différents styles.
        Nouveau style et qualité supérieure.<br>
        Une sélection de magasins et de chaînes de marque connus de tous afin de vous servir au mieux. <br>
        Découvrez toutes les catégories disponibles près de chez vous.
        </p>
        <a href="contact.php" class="btn">Contacter nous</a>
    </div>
    </div>
</section>
<!--about section ends-->

<!--reviews section starts-->

<section class="reviews">

<h1 class="heading">Avis des clients</h1>
<div class="swiper reviews-slider">
    <div class="swiper-wrapper">

    <div class="swiper-slide slide">
        <img src="images/pic-1.jpg" alt="">
        <p>Très bonne qualité</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Mia</h3>
    </div>
        <div class="swiper-slide slide">
        <img src="images/pic-2.jpg" alt="">
        <p>Je recommande vivement</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Maya</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-3.jpg" alt="">
        <p>je suis trés satisfaite </p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Joelle </h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-4.jpg" alt="">
        <p>Livraison rapide</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <h3>Ella</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-5.jpg" alt="">
        <p>Je suis satisfait</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
        </div>
        <h3>Kamil</h3>
    </div>

    <div class="swiper-slide slide">
        <img src="images/pic-6.jpg" alt="">
        <p>Très bonne qualité</p>
        <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
        </div>
        <h3>Benjamin</h3>
    </div>
    </div>
    <div class="swiper-pagination"></div>

    </div>
</section>

<!--reviews section ends-->








<?php include 'components/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
    loop:true,
    spaceBetween: 20,
    pagination: {
    el: ".swiper-pagination",
    clickable:true,
},
    breakpoints: {
    550: {
        slidesPerView: 2,
    }, 
        
    768: {
        slidesPerView: 2,
    },
    1024: {
        slidesPerView: 5,
    },
},
});

</script>
</body>
</html>