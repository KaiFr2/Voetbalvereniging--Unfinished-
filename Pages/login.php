<?php
session_start();
include_once 'Particals/connection.php';


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

<body>
    <div class="post">
        <form action="" method="POST">
            <input type="text" name="naam" placeholder="naam">
            <br>
            <input type="text" name="wachtwoord" placeholder="wachtwoord">
            <br>
            <input type="submit" name="submit">
        </form>
    </div>
</body>

</html>