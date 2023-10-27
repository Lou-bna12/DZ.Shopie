<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
    header('location:home.php');

};

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);

    $update_profile = $conn->prepare("UPDATE `users` SET name = ?, email = ? WHERE id = ?");
    $update_profile->execute([$name, $email, $user_id]);

    $empty_pass = '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2';
    $select_prev_pass = $conn->prepare("SELECT password FROM `users` WHERE id = ?");
    $select_prev_pass->execute([$user_id]);
    $fetch_prev_pass = $select_prev_pass->fetch(PDO::FETCH_ASSOC);
    $prev_pass = $fetch_prev_pass['password'];
    $old_pass = sha1($_POST['old_pass']);
    $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
    $new_pass = sha1($_POST['new_pass']);
    $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
    $confirm_pass = sha1($_POST['confirm_pass']);
    $confirm_pass = filter_var($confirm_pass, FILTER_SANITIZE_STRING);
    

    if($old_pass == $empty_pass){
        $message[] = 'Insérer votre ancien mot de passe!';
    }elseif($old_pass != $prev_pass){
        $message[] = 'Ancien mot de passe ne correspond pas!';
    }elseif($new_pass != $confirm_pass){
        $message[] = 'Confirmation du mot de passe non conforme';
    }else{
        if($new_pass != $empty_pass){
        $update_pass = $conn->prepare("UPDATE `users` SET password = ? WHERE id = ?");
        $update_pass->execute([$confirm_pass, $user_id]);
        $message[] = 'Le mot de passe a été mis à jour avec succès';
        }else{
            $message[] = 'Insérer votre nouveau mot de passe!';
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
    <title>S'inscrire</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    
<?php include 'components/user_header.php'; ?>

<section class="form-container">

    <form action="" method="post">
    <h3>Mettre à jour le profil</h3>
        <input type="hidden" name="prev_pass" value="<?= $fetch_profile["password"]; ?>">

        <input type="text" name="name" required placeholder="Insérer votre nom" maxlength="20"
        class="box" value="<?= $fetch_profile["name"]; ?>">
        
        <input type="email" name="email" required placeholder="Insérer votre adresse e-mail" maxlength="50"
        class="box" oninput="this.value = this.value.replace(/\s/g, '')" value="<?= $fetch_profile["email"]; ?>">

        <input type="password" name="old_pass" placeholder="Insérer votre ancien mot de passe" maxlength="20"
        class="box" oninput="this.value = this.value.replace(/\s/g, '')">

        <input type="password" name="new_pass" placeholder="Insérer votre nouveau mot de passe" maxlength="20"
        class="box" oninput="this.value = this.value.replace(/\s/g, '')">

        <input type="password" name="confirm_pass" placeholder="Confirmer votre nouveau mot de passe" maxlength="20"
        class="box" oninput="this.value = this.value.replace(/\s/g, '')">

        <input type="submit" value="Mettre à jour maintenant" class="btn" name="submit">
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>>