<?php

include '../Particals/header.php';
require '../Particals/connection.php';

if (!isset($_SESSION["admin"])) {
    header('index.php');
}

if (isset($_POST['submit-taken'])) {
    // Retrieve form data
    $titel = $_POST['titel'];
    $location = $_POST['locatie'];
    $start_hour = $_POST['start-hour'];
    $end_hour = $_POST['end-hour'];
    $start_minutes = $_POST['start-minutes'];
    $end_minutes = $_POST['end-minutes'];
    $date = $_POST['date'];
    $formattedDate = date('d-m-Y', strtotime($date));
    
    // Function to get weekday
    function getWeekday($date) {
        return date('w', strtotime($date));
    }

    
    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO tasks (titel, locatie, begin_uur, begin_minuut, eind_uur, eind_minuut, datum, dag_nummer) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisissi", $titel, $location, $start_hour, $start_minutes, $end_hour, $end_minutes, $formattedDate, getWeekday($date));
    
    // Execute the statement
    $stmt->execute();
    
    // Check for errors
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        header('Location: taken.php');
    }
    
    // Close the statement
    $stmt->close();
}

?>

<form name="submit-taken" action="taak-aanmaken.php" method="POST">
  <div class="form-group">
    <label for="exampleFormControlInput1">Titel van taak</label>
    <input type="text" class="form-control" name="titel" id="titel">
  </div>
  <div class="form-group">
    <label for="exampleFormControlInput1">Locatie van taak</label>
    <input type="text" class="form-control" name="locatie">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Begin uur</label>
    <select class="form-control" name="start-hour">
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Begin minuut</label>
    <select class="form-control" name="start-minutes">
    <option value="00">00</option>
    <option value="15">15</option>
    <option value="30">30</option>
    <option value="45">45</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Eind uur</label>
    <select class="form-control" name="end-hour">
    <option value="8">8</option>
    <option value="9">9</option>
    <option value="10">10</option>
    <option value="11">11</option>
    <option value="12">12</option>
    <option value="13">13</option>
    <option value="14">14</option>
    <option value="15">15</option>
    <option value="16">16</option>
    <option value="17">17</option>
    <option value="18">18</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Eind minuut</label>
    <select class="form-control" name="end-minutes">
    <option value="00">00</option>
    <option value="15">15</option>
    <option value="30">30</option>
    <option value="45">45</option>
    </select>
  </div>
  <div class="form-group">
    <label for="startDate">Datum</label>
    <input name="date" class="form-control" type="date" pattern="\d{2}-\d{2}-\d{4}" placeholder="dd-mm-yyyy" required />
  </div>
  <div class="d-flex" style="justify-content: center">
  <button type="submit" name='submit-taken' class="btn btn-primary w-25 p-2 mt-2">Voeg taak toe</button>
</div>
</form>