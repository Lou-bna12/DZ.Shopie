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
<title>Page de recherche</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>


<!--search form section starts -->

<section class="search-form">

<form action="" method="post">

<input type="text" class="box" maxlenght="100" placeholder="Recherchez ici..."
required name="search_box">
<button type="submit" class="fas fa-search" name="search_btn"></button>

</form>

</section>

<!--search form section ends -->

<section class="products" style="padding-top: 0; min-height:100vh;">


    <div class="box-container">

<?php

if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
    $search_box = $_POST['search_box'];
    $select_products = $conn->prepare("SELECT * FROM `products`  WHERE name
    LIKE '%{$search_box}%' ");
    $select_products->execute();
    if($select_products->rowCount() > 0){
        while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
?>

<form action="" method="post" class="box">
    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

    <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
    
    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
    <img src="uploaded_img/<?= $fetch_product["image_01"]; ?>"
    class="image" alt="">
    <div class="name"><?= $fetch_product['name']; ?></div>
    <div class="flex">
        <div class="price"><span><?= $fetch_product['price']; ?></span> €</div> 
        <input type="number" class="qty" name="qty" id="qty" min="1" max="99"
        value="1" onkeypress="if(this.value.lenght == 2) return false ;">
    </div>
<input type="submit" value="Ajouter au panier" name="add_to_cart" class="btn">
</form>

<?php
        }
    }else{
        echo '<p class="empty">Aucun produit trouvé!</p>';
    }
}  


?>

</div>

</section>











<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>