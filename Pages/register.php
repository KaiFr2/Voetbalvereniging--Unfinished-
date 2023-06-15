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
<style>
    body {
        background-image: url("../Images/background-site.jpg");
        background-size: cover;
    }
</style>
<body>
<form action="" method="POST" class="m-3 bg-custom-1 p-3 row">
    <form action="" method="POST">
        <h3>Formulier:</h3>
        <div class="form-group mt-3 col-lg-4">
            <label for="exampleFormControlInput1">?</label>
            <input type="text" name="username" class="form-control">
        </div>
        <div class="form-group mt-3 col-lg-4">
            <label for="exampleFormControlInput1">first</label>
            <input type="text" name="first" class="form-control">
        </div>
        <div class="form-group mt-3 col-lg-4">
            <label for="exampleFormControlInput1">last</label>
            <input type="text" name="last" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="exampleFormControlInput1">email</label>
            <input type="text" name="email" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="exampleFormControlInput1">password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group mt-3 mb-3">
            <label for="exampleFormControlInput1">telefoon</label>
            <input type="text" name="telefoon" class="form-control">
        </div>
        geslacht?
        <select class="form-control" name="geslacht">
            <option value="">Kies geslacht...</option>
            <option value="M">Man</option>
            <option value="V">Vrouw</option>
        </select>
        <button type="submit" name="submit" class="btn btn-primary w-100 mt-3">Account maken</button>
    </form>

</body>

</html>