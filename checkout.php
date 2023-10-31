<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
header('location:home.php');
};



?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Checkout</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--checkout section starts-->

<section class="checkout">
    <div class="display-orders">
    <?php
        $grand_total = 0;
        $cart_items[] =  '';
        $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
        $select_cart->execute([$user_id]);
        if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
                $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                $cart_items[] = $fetch_cart['name'].'('.$fetch_cart['quantity'].')
                -';
                $total_products = implode($cart_items);
?>
    <p> <?= $fetch_cart['name']; ?><span><?= $fetch_cart['price']; ?> € x 
    <?= $fetch_cart['quantity']; ?></span></p>
<?php
    }
}else{
    echo '<p class="empty">Votre panier est vide</p>';
}
?>
    </div>
</section>


<!--checkout section ends-->
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>