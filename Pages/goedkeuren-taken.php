<?php
include '../Particals/header.php';
require '../Particals/connection.php';

if (isset($_POST['keurgoed'])) {
    $id_tasks_id = $_POST['keurgoed'];
    $sql = "UPDATE users_tasks SET goedgekeurd=1 WHERE id=$id_tasks_id";
    if ($conn->query($sql) === TRUE) {
        echo 'Succesvol taak toegekent';
      } else {
        echo "Error executing SQL statement: " . $connection->error;
      }
}

?>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">@Username</th>
      <th scope="col">Taak</th>
      <th scope="col">Datum</th>
      <th scope="col">Rol</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT *, users_tasks.id AS 'users_tasks_id' FROM `users_tasks` LEFT JOIN users ON users_tasks.user_id = users.id LEFT JOIN tasks ON users_tasks.task_id = tasks.id WHERE users_tasks.goedgekeurd=0";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            foreach ($result as $row) {
                echo '<tr><th scope="row">' . $row["id"] . '</th><td>' . $row["username"] . '</td> <td>' . $row["titel"] . '</td> <td>' . $row["datum"] . '</td> <td><form method="POST"><button name="keurgoed" type="submit" value="' . $row["users_tasks_id"] . '" class="btn btn-primary btn-sm">Keur taak goed</form></td></tr>';

            }
        }
        }
    ?>
   </tbody> 