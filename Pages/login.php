<?php
include '../Particals/header.php';
include_once '../Particals/connection.php';


if (isset($_POST["submit"])) {

    $naam = htmlspecialchars($_POST["naam"]);
    $wachtwoord = htmlspecialchars($_POST["wachtwoord"]);

    $sql = "SELECT id, password, admin FROM `users` WHERE name = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $naam);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_array()) {
        $wachtwoordgoed = password_verify($wachtwoord, $row["password"]);

        if ($wachtwoordgoed) {
            $_SESSION["admin"] = $row["admin"];
            $_SESSION["naam"] = $naam;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION["session_id"] = session_id();
            header("Refresh:0.1; url=index.php", true, 303);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>
<style>
    body {
        background-image: url("../Images/background-site.jpg");
        background-size: cover;
    }
</style>
<body>
    <form action="" method="POST" class="m-3 bg-custom-1 p-3">
        <h3>Inlog formulier</h3>
        <div class="form-group">
            <label for="exampleFormControlInput1">Naam</label>
            <input type="text" name="naam" class="form-control">
        </div>
        <div class="form-group mt-3">
            <label for="exampleFormControlInput1">Wachtwoord</label>
            <input type="password" name="wachtwoord" class="form-control">
        </div>
        <div style="justify-content: center; display: flex">
            <input type="submit" name="submit" class="btn btn-primary mt-3 w-100">
        </div>
    </form>
</body>

</html>