<?php
include_once 'Particals/connection.php';

if(isset($_POST["submit"]))
{
    $username = htmlspecialchars($_POST["username"]);
    $name = htmlspecialchars($_POST['first']);
    $last = htmlspecialchars($_POST["last"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(`username`,`name`, `last`, `email`,`password`, `admin`,`gebanned`) VALUES (?,?, ?, ?, ?, 'gebruiker','0')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss",$username, $name,$last, $email, $password);
        $result = $stmt->execute();
        header("Refresh:0.1; url=login.php", true, 303);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="first" placeholder="Username">
        <br>
        <input type="text" name="first" placeholder="Naam">
        <br>
        <input type="text" name="last" placeholder="Achternaam">
        <br>
        <input type="text" name="email" placeholder="E-Mail">
        <br>
        <input type="password" name="password" placeholder="Password">
        <br>
        <button type="submit" name="submit"> Sign Up!</button>
    </form>
    
</body>
</html>