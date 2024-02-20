<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
};

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = sha1($_POST['cpass']);
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if($select_user->rowCount() > 0){
        $message[] = 'L\'utilisateur existe déjà!';
    }else{
        if($pass != $cpass){
            $message[] = 'Confirmer le mot de passe ne correspond pas';
        }else{
            $insert_user = $conn->prepare("INSERT INTO `users`(name, email, password) VALUES (?,?,?);");
            $insert_user->execute([$name, $email, $cpass]);
            $message[] = 'Inscrit avec succès, connectez-vous maintenant!';
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
<title>Inscription</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">


</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--user register section starts-->

<section class="form-container">

<form action="" method="POST">

    <h3>S'inscrire maintenant</h3>

    <input type="text" required maxlength="20" name="name"
    placeholder="Insérer votre nom" class="box" 
    oninput="this.value = this.value.replace(/\s/g,'')">

    <input type="email" name="email" required placeholder="Insérer votre adresse e-mail"
    maxlength="50"  class="box"
    oninput="this.value = this.value.replace(/\s/g, '')">

    <input type="password" required maxlength="20" name="pass"
    placeholder="Insérer votre mot de passe" class="box" id="password"
    oninput="this.value = this.value.replace(/\s/g,'')">
    <i class="far fa-eye" id="togglePassword" style=" cursor: pointer;"> </i>

    <input type="password" required maxlength="20" name="cpass"
    placeholder="Confirmer votre mot de passe" class="box"
    oninput="this.value = this.value.replace(/\s/g,'')">


    <input type="submit" value="S'inscrire maintenant" class="btn" name="submit">
    <p>Vous avez déjà un compte ?</p>
    <a href="user_login.php" class="option-btn">Se connecter</a>


</form>
</section>


<!--user register section ends-->



<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>


<script>
    const togglePassword = document.querySelector('#togglePassword');
    const passwordInput = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
    const type =
    passwordInput.getAttribute('type') === 'password'  ? 'text' : 'password';
    passwordInput.setAttribute('type', type);
  // Basculer l'icône entre l'œil ouvert et l'œil barré
    this.classList.toggle('fa-eye-slash');
});



    


</script>
</body>
</html>