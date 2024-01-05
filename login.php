<?php
session_start();
if(isset($_SESSION['user'])){
    header('Location: home.php');


}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS BOOTSTRAP -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link rel="stylesheet" href="./styles.css">
    <title>Login Form</title>
</head>

<body>
    <div class="container">
        <?php

        if (isset($_POST['login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            require_once("./database.php");

            $sql = "SELECT * FROM users WHERE email = ?";
            $retrieve_stmt = mysqli_stmt_init($dbcon);
            mysqli_stmt_prepare($retrieve_stmt, $sql);
            mysqli_stmt_bind_param($retrieve_stmt, 's', $email);
            $result =  mysqli_stmt_execute($retrieve_stmt);


            $result = mysqli_stmt_get_result($retrieve_stmt);
            var_dump($result);



            if ($user = mysqli_fetch_assoc($result)) {

                if (password_verify($password, $user['password'])) {
                    session_start();
                    $_SESSION['user'] = 'yes';
                    header('Location: home.php');
                    die();
                } else {
                    echo "<div class='alert alert-danger'>Password does not Match</div>";
                }
            } else {
                echo "<div class='alert alert-danger'>Email does not Exist</div>";
            }
        }


        ?>
        <form action="./login.php" method="post">
            <h1 class="text-center">Sign In</h1>
            <div class="form-group">
                <input type="email" placeholder="Enter Email" name="email" value="<?php if (!empty($email)) echo $email ?>" class="form-control">
            </div>

            <div class="form-group">
                <input type="password" placeholder="Enter Password" value="<?php if (!empty($password)) echo $password ?>" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
            <p><a class="link-offset-1" href="./registration.php">Dont have an account Sign Up!</a></p>
        </form>
    </div>

</body>

</html>