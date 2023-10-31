<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
header('location:home.php');
};

if(isset($_POST['order'])){


    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $method = $_POST['method'];
    $method = filter_var($method, FILTER_SANITIZE_STRING);
    $address = $_POST['flat'].', '.$_POST['city'].','.$_POST['country'].','.$_POST['pin_code'];
    $address = filter_var($address, FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_products = filter_var($total_products, FILTER_SANITIZE_STRING);
    $total_price = $_POST['total_price'];
    $total_price = filter_var($total_price, FILTER_SANITIZE_STRING);

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0){
        $insert_order = $conn->prepare("INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, 
        total_price) VALUES (?,?,?,?,?,?,?,?) ");
        $insert_order->execute([$user_id,  $name, $number, $email, $method, $address, $total_products, 
        $total_price]);

        $message[] = 'Commande passée avec succès';

        $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?"); 
        $delete_cart->execute([$user_id]);

    }else{
        $message[] = 'Votre panier est vide';
    }

}

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
    <h1 class="heading">Vos commandes</h1>
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
    <p> <?= $fetch_cart['name']; ?> : <span><?=  $fetch_cart['price']; ?>  € x 
    <?= $fetch_cart['quantity']; ?> </span></p>
<?php
    }
}else{
    echo '<p class="empty">Votre panier est vide</p>';
}
?>
    </div>
    <p class="grand-total">Total général : <span><?= $grand_total; ?> €</span>
</p>

<form action="" method="post">

<h1 class="heading">Passer des commandes</h1>

    <input type="hidden" name="total_products" value="<?= $total_products; ?>">
    <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
<div class="flex">
    <div class="inputBox">
        <span>Nom : </span>
        <input type="text" maxlength="20" placeholder="Insérer votre nom"
        required class="box" name="name">
    </div>

    <div class="inputBox">
        <span>Numéro de téléphone : </span>
        <input type="number" min="0" max="9999999999" onkeypress="if(this.value.length ==10) return false;"
        placeholder="Insérer votre numéro de téléphone"required class="box" name="number">
    </div>

    <div class="inputBox">
        <span>Adresse e-mail : </span>
        <input type="email" maxlength="20" placeholder="Insérer votre adresse email"
        required class="box" name="email">
    </div>
    <div class="inputBox">
        <span>Mode de paiement : </span>
        <select name="method" class="box">
            <option value="À la livraison">À la livraison</option>
            <option value="Carte bancaire">Carte bancaire</option>
            <option value="Paypal">Paypal</option>
        </select>
    </div>

    <div class="inputBox">
        <span>Adresse : </span>
        <input type="text" maxlength="50" placeholder="Insérer votre adresse"
        required class="box" name="flat">
    </div>

    <div class="inputBox">
        <span>Ville : </span>
        <input type="text" maxlength="50" placeholder="e.g. Nantes"
        required class="box" name="city">
    </div>

    <div class="inputBox">
        <span>Code postal : </span>
        <input type="number" min="0" max="999999" placeholder="e.g. 44000"
        required class="box" name="pin_code" onkeypress="if(this.value.length == 6) return false;">
    </div>

    <div class="inputBox">
        <span>Pays : </span>
        <input type="text" maxlength="50" placeholder="e.g. France"
        required class="box" name="country">
    </div>
</div>
<input type="submit" value="passez commande" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" name="order">
</form>

</section>


<!--checkout section ends-->
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>