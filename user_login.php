<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

if(isset($_POST['submit'])){
    
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass =  sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? ");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount()  >  0){
        $_SESSION['user_id'] = $row['id'];

         // Ajouter le code pour définir le cookie
         setcookie('user_id', $row['id'], time() + 1 * 60 * 60, '/');
    
        header('location:home.php');
    
    }else{
        $message[] = 'E-mail ou mot de passe incorrect';
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

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--user login section starts-->

<section class="form-container">

<form action="" method="POST">
    <h3>Se connecter maintenant</h3>
    <input type="email" required maxlength="50" name="email"
    placeholder="Insérer votre adresse mail" class="box" 
    oninput="this.value = this.value.replace(/\s/g,'')">

    <input type="password" required maxlength="20" name="pass"
    placeholder="Insérer votre mot de passe" class="box" id="password"
    oninput="this.value = this.value.replace(/\s/g,'')">
    <i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"> </i>
    
    <input type="submit" value="Se connecter" class="btn" name="submit">
    <p>Vous n'avez pas de compte ?</p>
    <a href="user_register.php" class="option-btn">S'inscrire maintenant</a>


</form>
<!-- Code pour afficher les messages -->
<?php
if (!empty($message)) {
    foreach ($message as $msg) {
        echo '<div>' . htmlspecialchars($msg) . '</div>';
    }
}
?>
</section>


<!--user login section ends-->

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


<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>