<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS boot strap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
    <?php
        require('./database.php');
        $userfetch_query = "SELECT id, full_name, email from users ORDER BY id ASC";
        $result = mysqli_query($dbcon, $userfetch_query);

        if($result){
            echo "<table class='table table-striped'> 
            <tr> <th>id</th> <th>full name</th> <th>email</th> </tr>";
        }
        

        while($row = mysqli_fetch_assoc($result)){

        echo '<tr> <td>'.$row['id'].'</td> <td>'.$row['full_name'].' </td> <td>'.$row['email'].'</td> </tr>';

        }

        echo "</table>"
    
    ?>
</body>

</html>