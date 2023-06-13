<?php
include '../Particals/header.php';
require '../Particals/connection.php';

if (isset($_SESSION["admin"]) == false) {
    header('index.php');
}

if (isset($_POST['rolechange'])) {
  $userid = $_POST['rolechange'];
  $sql = "UPDATE gebruiker SET Rol='admin' WHERE gebruikerID=$userid";
  if ($conn->query($sql) === TRUE) {
    echo "SQL statement executed successfully.";
  } else {
    echo "Error executing SQL statement: " . $connection->error;
  }
}


?>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">First</th>
      <th scope="col">Email</th>
      <th scope="col">Telefoonnummer</th>
      <th scope="col">Rol</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM gebruiker";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($result as $row) {
                echo '<tr><th scope="row">' . $row["gebruikerID"] . '</th><td>' . $row["Naam"] . '</td> <td>' . $row["Email"] . '</td> <td>' . $row["Telefoonnummer"] . '</td> <td><form method="POST"><button name="rolechange" type="submit" value="' . $row["gebruikerID"] . '" class="btn btn-primary btn-sm">Maak admin</form></td></tr>';

            }
        }
        }
    ?>
   </tbody> 