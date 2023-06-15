<?php
include '../Particals/header.php';
require '../Particals/connection.php';

if (isset($_POST["submit"])) {
    $username = htmlspecialchars($_POST["username"]);
    $name = htmlspecialchars($_POST['first']);
    $last = htmlspecialchars($_POST["last"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $geslacht = $_POST['geslacht'];
    $telefoon = $_POST["telefoon"];

    $ControleNaam = "SELECT username, email FROM `users` WHERE username = ? || email = ? ";
    $stmt2 = $conn->prepare($ControleNaam);
    $stmt2->bind_param("ss", $username, $email);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if ($row = $result2->fetch_array() == true) {
        echo "<script>alert('Name or Email already exists');</script>";
    } else {
        $sql = "INSERT INTO users(`username`,`name`, `last`, `email`,`password`,`geslacht`,`telefoon`) VALUES (?,?, ?, ?, ?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssi", $username, $name, $last, $email, $password,$geslacht,$telefoon);
        $result = $stmt->execute();
        header("Refresh:0.1; url=login.php", true, 303);
    }   
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/registerpage.css">
    <title>Login Page</title>
</head>

<body>
    <form action="" method="POST">
        <input type="text" name="username" placeholder="Username">
        <br>
        <input type="text" name="first" placeholder="Naam">
        <br>
        <input type="text" name="last" placeholder="Achternaam">
        <br>
        <input type="text" name="email" placeholder="E-Mail">
        <br>
        <input type="password" name="password" placeholder="Password">
        <br>
        <input type="tel" name="telefoon" placeholder="Telefoon Number">
        <br>
        geslacht?
        <select name="geslacht">
            <option value="">Select...</option>
            <option value="M">Man</option>
            <option value="V">Vrouw</option>
        </select>
        <br>
        <button type="submit" name="submit"> Sign Up!</button>
    </form>

</body>

</html>