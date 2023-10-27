<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Vue d'ensemble</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--quick view section starts-->

<section class="quick-view">


<?php
    $pid = $_GET['pid'];
    $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
    $select_products->execute([$pid]);
    if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
?>

<form action="" method="post" class="box">
    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

    <div class="main-image">
        <div class="big-image">
        <img src="uploaded_img/<?= $fetch_product["image_01"]; ?>" alt="">
        </div>
        <div class="small-image">
        <img src="uploaded_img/<?= $fetch_product["image_01"]; ?>" alt="">
        <img src="uploaded_img/<?= $fetch_product["image_02"]; ?>" alt="">
        <img src="uploaded_img/<?= $fetch_product["image_03"]; ?>" alt="">
        </div>
    </div>    
    <div class="content">
    <div class="name"><?= $fetch_product['name']; ?></div>
    <div class="price"><span><?= $fetch_product['price']; ?></span>€</div>
    <input type="number" class="qty" name="qty" id="qty" min="1" max="99"
    value="1" onkeypress="if(this.value.lenght == 2) return false ;">
    </div>
<div class="flex-btn">
    <input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
    <input type="submit" value="Ajouter au favoris" name="add_to_wishlist" class="option-btn">
</div>
    </div>

</form>


<?php
    }
}else{
        echo '<p class="empty">Aucun produit trouvé!</p>';
    }
?>


</section>






<!--quick view section endss-->


<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>