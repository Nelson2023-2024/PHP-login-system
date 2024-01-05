<?php 

DEFINE('DB_HOST', 'localhost');
DEFINE('DB_USER', 'root');
DEFINE('DB_PASS', '');
DEFINE('DB_NAME', 'login_register');

try{

$dbcon = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if($dbcon -> connect_error){
        echo "<div class='alert alert-danger'>Connection Failed</div>";
    }
    else{
    echo "<div class='alert alert-success'>Connection Successful</div>";
    }
}
catch(Exception $e){
    //echo $e->getMessage();
    echo
    "<div class='alert alert-danger'>The system is busy try again later</div>";
} 

?>