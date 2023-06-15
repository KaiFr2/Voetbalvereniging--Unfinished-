<?php

include '../Particals/header.php';
require '../Particals/connection.php';
$id = $_GET['id'];

$sql = "SELECT * FROM tasks WHERE id=$id";
$result = $conn->query($sql);

$taakTitel = null;
$taakLocatie = null;
$taakBeginUur = null;
$taakEindUur = null;
$taakBeginMinuut = null;
$taakEindMinuut = null;
$taakDatum = null;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Access individual columns of the row
        $taakTitel = $row['titel'];
        $taakLocatie = $row['locatie'];
        $taakBeginUur = $row['begin_uur'];
        $taakEindUur = $row['eind_uur'];
        $taakBeginMinuut = $row['begin_minuut'];
        $taakEindMinuut = $row['eind_minuut'];
        $taakDatum = $row['datum'];
        // ... access other columns as needed
    }
} else {
    echo "No rows found.";
}
$convertedDate = date('Y-m-d', strtotime($taakDatum));

if (isset($_POST['wijzig-taken'])) {
    $titel = $_POST['titel'];
    $location = $_POST['locatie'];
    $start_hour = $_POST['beginuur'];
    $end_hour = $_POST['end-hour'];
    $start_minutes = $_POST['start-minutes'];
    $end_minutes = $_POST['end-minutes'];
    $date = $_POST['date'];
    $formattedDate = date('d-m-Y', strtotime($date));
    function getWeekday($date) {
        return date('w', strtotime($date));
    }
    $dagnummer = getWeekday($date);
    $sql = "UPDATE `tasks` SET `titel`=?, `beschrijving`='', `locatie`=?, `dag_nummer`=?, `begin_uur`=?, `eind_uur`=?, `begin_minuut`=?, `eind_minuut`=?, `datum`=? WHERE id=?";

// Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters to the statement
    $stmt->bind_param("ssiiiiiss", $titel, $location, $dagnummer, $start_hour, $end_hour, $start_minutes, $end_minutes, $formattedDate, $id);

    // Execute the statement
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        header('Location: taken.php');
    } else {
        // Update failed
    }
}
?>

<form name="submit-taken" method="POST" class="m-3">
  <div class="form-group">
  <label for="exampleFormControlInput1">Titel van taak</label>
    <input type="text" class="form-control" value="<?php echo $taakTitel; ?>" name="titel" id="titel">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Locatie van taak</label>
    <input type="text" class="form-control" value="<?php echo $taakLocatie; ?>" name="locatie">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Begin uur</label>
    <select name="beginuur" class="form-control" required>
  <?php
    for ($i = 8; $i <= 18; $i++) {
      $selected = ($i == $taakBeginUur) ? "selected" : "";
      echo "<option value='$i' $selected>$i</option>";
    }
  ?>
</select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Begin minuut</label>
    <select class="form-control" name="start-minutes">
    <?php
    $options = array("00", "15", "30", "45"); // Options to display
    foreach ($options as $option) {
      $selected = ($option == $taakBeginMinuut) ? "selected" : "";
      echo "<option value='$option' $selected>$option</option>";
    }
  ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Eind uur</label>
    <select class="form-control" name="end-hour">
    <?php
    for ($i = 8; $i <= 18; $i++) {
      $selected = ($i == $taakEindUur) ? "selected" : "";
      echo "<option value='$i' $selected>$i</option>";
    }
  ?>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Eind minuut</label>
    <select class="form-control" name="end-minutes">
    <?php
    $options = array("00", "15", "30", "45"); // Options to display
    foreach ($options as $option) {
      $selected = ($option == $taakEindMinuut) ? "selected" : "";
      echo "<option value='$option' $selected>$option</option>";
    }
  ?>
    </select>
  </div>
  <div class="form-group">
    <label for="startDate">Datum</label>
    <input name="date" class="form-control" pattern="\d{2}-\d{2}-\d{4}" type="date" value="<?php echo $convertedDate; ?>" required />
  </div>
  <div class="d-flex" style="justify-content: center">
  <button type="submit" name='wijzig-taken' class="btn btn-primary w-25 p-2 mt-2">Wijzig taak</button>
</div>
</form>