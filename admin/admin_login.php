<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admins` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   $row = $select_admin->fetch(PDO::FETCH_ASSOC);

   if($select_admin->rowCount() > 0){
      $_SESSION['admin_id'] = $row['id'];
      header('location:dashboard.php');
   }else{
      $message[] = 'Nom d\'utilisateur ou mot de passe incorrect !';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Connexion</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

   <form action="" method="post">
      <h3>Se connecter maintenant</h3>
      <!--<p>Nom par défaut = <span>Admin</span> & le mot de passe = <span>111</span></p>-->
      <input type="text" name="name" required placeholder="Entrer votre nom"
      maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="Entrer votre mot de passe" id="password"
      maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <i class="far fa-eye" id="togglePassword" style="margin-left: -450px ;cursor: pointer;"></i>
      <input type="submit" value="Connexion" class="btn" name="submit">
   </form>

</section>
   
<script>
   const togglePassword = document.querySelector('#togglePassword');
   const passwordInput = document.querySelector('#password');

   togglePassword.addEventListener('click', function () {
   const type =
   passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
   passwordInput.setAttribute('type', type);
  // Basculer l'icône entre l'œil ouvert et l'œil barré
   this.classList.toggle('fa-eye-slash');
});

</script>

</body>
</html>