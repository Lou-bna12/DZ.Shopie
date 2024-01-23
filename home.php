<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
}





include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Accueil</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>


<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   

<?php include 'components/user_header.php'; ?>


<div class="home-bg">
    <section class="swiper home-slider">
        <div class="swiper-wrapper">

<div class="swiper-slide slide">
    <div class="image">
        <img src="images/home-img-1.png" alt="">
    </div>
    <div class="content">
        <span>Jusqu'à 50% de réduction</span>
        <h3>Smartphone</h3>
        <a href="shop.php" class="btn" >Achetez maintenant</a>
    </div>
</div>

<div class="swiper-slide slide">
    <div class="image">
        <img src="images/home-img-2.png" alt="">
    </div>
    <div class="content">
        <span>Jusqu'à 50% de réduction</span>
        <h3>Montres</h3>
        <a href="shop.php" class="btn" >Achetez maintenant</a>
    </div>
</div>

<div class="swiper-slide slide">
    <div class="image">
        <img src="images/home-img-3.png" alt="">
    </div>
    <div class="content">
        <span>Jusqu'à 50% de réduction</span>
        <h3>Casques</h3>
        <a href="shop.php" class="btn" >Achetez maintenant</a>
    </div>
</div>



    </div>

    <div class="swiper-pagination"></div>

</section>
</div>

<!-- home category section starts -->


<section class="home-category">
    <h1 class="heading">Acheter par catégorie</h1>
    <div class="swiper category-slider">
        <div class="swiper-wrapper">

        <a href="category.php?category=Ordinateur portable" class="swiper-slide slide">
            <img src="images/icon-1.png" alt="">
            <h3> Pc portable </h3>
        </a>

        <a href="category.php?category=Télévision" class="swiper-slide slide">
            <img src="images/icon-2.png" alt="">
            <h3> Télévision </h3>
        </a>

        <a href="category.php?category=Appareil Photo" class="swiper-slide slide">
            <img src="images/icon-3.png" alt="">
            <h3> Appareil Photo </h3>
        </a>

        <a href="category.php?category=Souris avec fil" class="swiper-slide slide">
            <img src="images/icon-4.png" alt="">
            <h3> Souris avec fil </h3>
        </a>
        <a href="category.php?category=Réfrigérateur" class="swiper-slide slide">
            <img src="images/icon-5.png" alt="">
            <h3> Réfrigérateur </h3>
        </a>

        <a href="category.php?category=Lave linge" class="swiper-slide slide">
            <img src="images/icon-6.png" alt="">
            <h3> Lave linge </h3>
        </a>

        <a href="category.php?category=Smartphone" class="swiper-slide slide">
            <img src="images/icon-7.png" alt="">
            <h3> Smartphone </h3>
        </a>

        <a href="category.php?category=Montres" class="swiper-slide slide">
            <img src="images/icon-8.png" alt="">
            <h3> Montres </h3>
        </a>
        </div>

        <div class="swiper-pagination">
    </div>

    </div>
</section>
<!-- home category section ends -->

<!-- home products section starts -->

<section class=" home-products">

    <h1 class="heading">Derniers produits</h1>

    <div class="swiper products-slider">

        <div class="swiper-wrapper">
<?php
    $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 6");
    $select_products->execute();
    if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
?>
<form action="" method="post" class="slide swiper-slide">
    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

    <button type="submit" name="add_to_wishlist"  class="fas fa-heart">
    </button>
    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
    
    <img src="uploaded_img/<?= $fetch_product["image_01"]; ?>"
    class="image" alt="">
    <div class="name"><?= $fetch_product['name']; ?></div>
    <div class="flex">
        <div class="price"><span><?= $fetch_product['price']; ?></span>€</div>
        <input type="number" class="qty" name="qty" min="1" max="99"
        value="1" onkeypress="if(this.value.length == 2) return false ;">
    </div>
<input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
</form>
<?php

}
}else{
    echo '<p class="empty">Aucun produit n\'a encore été ajouté !</p>';
}
    ?>
</div>
<div class="swiper-pagination"></div>
</div>
</section>






<!-- home products section ends -->



<?php include 'components/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

    var swiper = new Swiper(".home-slider", {
    loop:true,
    grapCursor:true,
    pagination: {
        el: ".swiper-pagination",
    },
});
    
var swiper = new Swiper(".category-slider", {
    loop:true,
    spaceBetween: 20,
    pagination: {
    el: ".swiper-pagination",
    clickable:true,
},
    breakpoints: {
    0: {
        slidesPerView: 2,
    }, 
        
    640: {
        slidesPerView: 2,
    },
    768: {
        slidesPerView: 3,
    },
    1024: {
        slidesPerView: 5,
    },
},
});
var swiper = new Swiper(".products-slider", {
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

<div id="cookie-notification" class="cookies-notification">
        <p>Nous utilisons des cookies pour améliorer votre expérience. Acceptez-vous l'utilisation de cookies ?</p>
        <button  onclick="acceptCookies()">Accepter</button>
        <button  onclick="rejectCookies()">Refuser</button>
    </div>

</body>
</html>