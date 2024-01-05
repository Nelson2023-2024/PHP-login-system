<?php
session_start();
if (isset($_SESSION['user'])) {
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

    <title>Registration form</title>
</head>

<body>
    <div class="container rounded">
        <?php
        error_reporting(E_ALL | E_STRICT);
        if (isset($_POST['submit'])) {


            //array to strore errors
            $errors = array();

            //storing the submited info in variables
            $fullname = $_POST['fullname'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_repeate = $_POST['repeate_password'];

            //hashing password
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // var_dump($password_hash);

            //checking if any of the form fields are empty
            if (empty($fullname) or empty($email) or empty($password) or empty($password_repeate)) {
                array_push($errors, "All fields must be filled");
            }

            //validating appriate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                array_push($errors, "Email is not valid");
            }

            if (strlen($password) < 8) {
                array_push($errors, "Password be at least 8 characters long ");
            }
            if ($password !== $password_repeate) {
                array_push($errors, "Your two passwords did not match");
            }

            //database connection
            require('database.php');

            //Checking for duplicate emails
            $check_query = "SELECT * FROM users WHERE email = ?";
            $check_statement = mysqli_stmt_init($dbcon);
            if (mysqli_stmt_prepare($check_statement, $check_query)) {
                mysqli_stmt_bind_param($check_statement, 's', $email);
                mysqli_stmt_execute($check_statement);
                mysqli_stmt_store_result($check_statement); //stored in PHP memory

                //check number of rows returned by prepared satatement
                if (mysqli_stmt_num_rows($check_statement) > 0) {
                    array_push($errors, "Email already exists use another email address");
                }

                mysqli_stmt_close($check_statement);
            }

            //if everything is not ok
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<div class='alert alert-danger'>$error</div>";
                }
            }
            //if everything is ok
            else {
                //insert data to database
                //SQL query
                $insert_query = "INSERT INTO users(full_name, email, password) VALUES (?,?,?)";

                //intialization
                $insert_statement =  mysqli_stmt_init($dbcon);
                mysqli_stmt_prepare($insert_statement, $insert_query);
                mysqli_stmt_bind_param($insert_statement, 'sss', $fullname, $email, $password_hash);
                mysqli_stmt_execute($insert_statement);



                //if one row is affected in the db
                if (mysqli_stmt_affected_rows($insert_statement) == 1) {
                    echo "<div class='alert alert-success '>Registered Successful</div>";
                    //close db connection
                    mysqli_stmt_close($insert_statement);
                } else {
                    echo "<div class='alert alert-danger'>The system is busy please try again later</div>";
                }
            }
        }




        ?>
        <form action="registration.php" method="post">
            <h1 class="text-center mb-4">Sign Up</h1>
            <div class="form-group">
                <input type="text" class="form-control" name='fullname' placeholder="full name" value="<?php if (!empty($fullname))  echo $fullname ?>">
            </div>

            <div class="form-group">
                <input type="email" class="form-control" name='email' placeholder="email" value="<?php if (!empty($email)) echo $email ?>">
            </div>

            <div class="form-group">
                <input type="password" class="form-control" name='password' placeholder="password" value="<?php if (!empty($password)) echo $password ?>">
            </div>

            <div class="form-group">
                <input type="text" class="form-control" name='repeate_password' placeholder="Repeat password" value="<?php if (!empty($password_repeate)) echo $password_repeate ?>">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary " value="Register" name="submit">
            </div>

            <p><a class="link-offset-1" href="./login.php">Already have an accout Sign In!</a></p>

        </form>
    </div>
</body>

</html>