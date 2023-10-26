<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
};
if(isset($_POST['add_product'])){
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);
  $price = $_POST['price'];
  $price = filter_var($price, FILTER_SANITIZE_STRING);
  $details = $_POST['details'];
  $details = filter_var($details, FILTER_SANITIZE_STRING);

  $image_01 = $_FILES['image_01']['name'];
  $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING );
  $image_01_size = $_FILES['image_01']['size'];
  $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
  $image_01_folder = '../uploaded_img/' .$image_01;

  $image_02 = $_FILES['image_02']['name'];
  $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING );
  $image_02_size = $_FILES['image_02']['size'];
  $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
  $image_02_folder = '../uploaded_img/' .$image_02;

  $image_03 = $_FILES['image_03']['name'];
  $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING );
  $image_03_size = $_FILES['image_03']['size'];
  $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
  $image_03_folder = '../uploaded_img/' .$image_03;

  $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
  $select_products->execute([$name]);

  if($select_products->rowCount() > 0){
    $message[] = 'Nom du produit déjà existant!';
  }else{
    if($image_01_size > 2000000 OR $image_02_size > 2000000 OR $image_03_size > 2000000 ){
    $message[] = 'La taille de l\'image est trop grande';
  }else{

    move_uploaded_file($image_01_tmp_name, $image_01_folder);
    move_uploaded_file($image_02_tmp_name, $image_02_folder);
    move_uploaded_file($image_03_tmp_name, $image_03_folder);

    $insert_product = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03)
    VALUES (?,?,?,?,?,?)");
    $insert_product->execute([$name, $details, $price, $image_01, $image_02, $image_03]);

    $message[] = 'Nouveau produit ajouté';
    }
  }

};

if(isset($_GET['delete'])){

  $delete_id = $_GET['delete'];
  $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
  $delete_product_image->execute([$delete_id]);
  $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
  unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
  unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
  unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
  $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
  $delete_product->execute([$delete_id]);
  $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
  $delete_cart->execute([$delete_id]);
  $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
  $delete_wishlist->execute([$delete_id]);
  header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Produits</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/admin_header.php'; ?>  

<!--Add products section starts-->

<section class="add-products">
  <h1 class="heading">Ajouter un produit</h1>
  <form action="" method="POST" enctype="multipart/form-data">
  <div class="flex">
    <div class="inputBox">
      <span>Nom du produit (obligatoire)</span>
      <input type="text" required placeholder="Entrer le nom du produit" name="name" maxlength="100" class="box">
    </div>

    <div class="inputBox">
      <span>prix du produit (obligatoire)</span>
      <input type="number" min="0" class="box" required max="9999999999" placeholder="Entrer le prix du produit" onkeypress="if(this.value.length == 10) return false;" name="price">
    </div>
      <div class="inputBox">
        <span>Image 01 (obligatoire)</span>
        <input type="file" name="image_01" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      </div>
      <div class="inputBox">
        <span>Image 02 (obligatoire)</span>
        <input type="file" name="image_02" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      </div>
      <div class="inputBox">
        <span>Image 03 (obligatoire)</span>
        <input type="file" name="image_03" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
      </div>
      <div class="inputBox">
        <span>Détails du produit </span>
        <textarea name="details" class="box" placeholder="Entrer les détails du produit" required
        maxlength="500" cols="30" rows="10"></textarea>
      </div>
      <input type="submit" value="Ajouter" name="add_product" class="btn">
  </div>    
</form>
</section>

<!--Add products section ends-->

<!--Show products section starts-->
<section class="show-products">

<h1 class="heading">produits ajoutés</h1>

<div class="box-container">

<?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
?>
<div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price"><span><?= $fetch_products['price']; ?> €</span></div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      <div class="flex-btn">
      <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
      <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn"
      onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
      </div>
</div>
<?php
      }
      }else{
      echo '<p class="empty">Aucun produit n\'a encore été ajouté !</p>';
      }
?>
</div>

</section>

<!--Show products section ends-->

<script src="../js/admin_script.js"></script>
</body>
</html>