<?php
include '../Particals/header.php';
require '../Particals/connection.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 0) {
    header('Location: index.php');
}

if (isset($_POST['rolechange'])) {
  $userid = $_POST['rolechange'];
  $sql = "UPDATE users SET admin='1' WHERE id=$userid";
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
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($result as $row) {
                echo '<tr><th scope="row">' . $row["id"] . '</th><td>' . $row["username"] . '</td> <td>' . $row["email"] . '</td> <td>' . $row["telefoon"] . '</td> <td><form method="POST"><button name="rolechange" type="submit" value="' . $row["id"] . '" class="btn btn-primary btn-sm">Maak admin</form></td></tr>';

            }
        }
        }
    ?>
   </tbody> 