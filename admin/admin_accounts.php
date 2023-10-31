<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
};

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  $delete_admin = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
  $delete_admin->execute([$delete_id]);
  header('location:admin_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compte administrateurs</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/admin_header.php'; ?>  

<!--admins accounts section starts -->

<section class="accounts">

<h1 class="heading">Comptes admins</h1>

<div class="div box-container">

  <div class="box">
    <p>S'inscrire un nouveau admin</p>
    <a href="register_admin.php" class="option-btn">S'inscrire</a>
  </div>

<?php
  $select_account = $conn->prepare("SELECT * FROM `admins`");
  $select_account->execute();
  if($select_account->rowCount() > 0){
    while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
  <p>Identifiant de l'admin : <span><?= $fetch_accounts['id']; ?></span> </p>
  <p>Nom de l'admin : <span><?= $fetch_accounts['name']; ?> </span></p>
  <div class="flex-btn">
  <a href="admin_accounts.php?delete=<?= $fetch_accounts['id']; ?>" class="delete-btn"
  onclick="return confirm('Supprimer ce compte ?');">Supprimer</a>
  
  <?php

    if($fetch_accounts['id'] === $admin_id){
      echo '<a href="update_profile.php" class="option-btn">Mettre à jour</a>';
    
    }
  ?>

  </div>
</div>

  <?php

}
  }else{
  echo '<p class="empty">Aucun compte n\'est disponible</p>';
}


?>

</div>
</section>




<!--admins accounts section endSs -->

<script src="../js/admin_script.js"></script>
</body>
</html>