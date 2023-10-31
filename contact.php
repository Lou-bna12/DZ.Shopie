<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
$user_id = $_SESSION['user_id'];
}else{
$user_id = '';
};

if(isset($_POST['send'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);

    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ?
    AND email = ? AND number = ? AND message = ?");
    $select_message->execute([$name, $email, $number, $msg]);

    if($select_message->rowCount() > 0){
        $message[] = 'Message déjà envoyé!';
    }else{
        $send_message = $conn->prepare("INSERT INTO `messages` (name, email,
        number, message) VALUES (?,?,?,?)");
        $send_message->execute([$name, $email, $number, $msg]);
        $message[] = 'Message envoyé avec succés!';

    }


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contacte</title>

<link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
<!-- font awesome cdn link  -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="css/style.css">

</head>
<body>   
    
<?php include 'components/user_header.php'; ?>

<!--contact section starts-->

<section class="form-container">

<h1 class="heading">Contactez-nous</h1>

<form action="" method="post" class="box">
    <h3>Veuillez nous faire parvenir un message ?</h3>

    <input type="text" name="name" required placeholder="Insérer votre nom"
    maxlength="20" class="box">
    <input type="number" name="number" required placeholder="Insérer votre numéro de téléphone"
    max="9999999999" min="0" class="box" onkeypress="if(this.value.lenght == 10) return false;">
    <input type="email" name="email" required placeholder="Insérer votre adresse e-mail"
    maxlength="50" class="box">
    <textarea name="msg" placeholder="Insérer votre message" required
    class="box" cols="30" rows="10"></textarea>

    <input type="submit" value="Envoyer" class="btn" name="send">
</form>

</section>



<!--contact section starts-->
<?php include 'components/footer.php'; ?>
<script src="js/script.js"></script>
</body>
</html>