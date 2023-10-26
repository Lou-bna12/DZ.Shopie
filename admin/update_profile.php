<?php
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
    header('location:admin_login.php');
}

if(isset($_POST['submit'])){
  $name = $_POST['name'];
  $name = filter_var($name, FILTER_SANITIZE_STRING);

  $update_name = $conn->prepare("UPDATE `admins` SET name = ? WHERE id = ?");
  $update_name->execute([$name, $admin_id]);

  $empty_pass = '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2';
  $select_old_pass = $conn->prepare("SELECT password FROM `admins` WHERE id = ?");
  $select_old_pass->execute([$admin_id]);
  $fetch_prev_pass = $select_old_pass->fetch(PDO::FETCH_ASSOC);
  $prev_pass = $fetch_prev_pass['password'];
  $old_pass = sha1($_POST['old_pass']); 
  $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
  $new_pass = sha1($_POST['new_pass']); 
  $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
  $confirm_pass = sha1($_POST['confirm_pass']); 
  $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);

  if($old_pass === $empty_pass){
    $message[] = 'Veuillez saisir l\'ancien mot de passe!';
  }elseif($old_pass != $prev_pass){
    $message[] = 'L\'ancien mot de passe ne correspond pas!';
  }elseif($new_pass != $confirm_pass){
    $message[] = 'Le mot de passe ne semble pas correspondre';
  }else{
    if($new_pass != $empty_pass){
        $update_pass = $conn->prepare("UPDATE `admins` SET password = ? WHERE id = ?");
        $update_pass->execute([$confirm_pass, $admin_id]);
        $message[] = 'Mise à jour du mot de passe réussie!';
    }else{
      $message[] = 'Veuillez saisir le nouveau mot de passe!';
    }
  }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mettre à jour le profil</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

  <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>
<?php include '../components/admin_header.php'; ?>  
 <!--admin profile update section start-->
<section class="form-container">
<form action="" method="post">
    <h3>Mettre à jour</h3>
    <input type="text" name="name" required placeholder="Entrer votre nom" maxlength="20"
    class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile['name'];?>">
    <input type="password" name="old_pass"  placeholder="Insérer votre ancien mot de passe" maxlength="20"
    class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="new_pass"  placeholder="Insérer votre nouveau mot de passe" maxlength="20"
    class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="confirm_pass"  placeholder="Confirmez votre nouveau mot de passe" maxlength="20"
    class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="Mettre à jour" class="btn" name="submit">
</form>

</section>

<!--admin profile update section ends-->
<script src="../js/admin_script.js"></script>
</body>
</html>