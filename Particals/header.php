<?php
session_start();
?>
<!doctype html>
<html lang="nl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Voetbal Vereniging</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../Styles/styles.css">
  <link rel="icon" href="../Images/3068540.png">
  <link rel="icon" href="https://example.com/Images/3068540.png">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../CSS/index.css">
  <script src="../Javascript/index.js"></script>
  
  <header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom border-custom-gold">
  <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
    <img src="../Images/3068527.png" alt="Logo" width="40" height="32" class="me-2">
    <span class="text-white fs-4">Voetbal Vereniging</span>
  </a>

  <ul class="nav nav-pills">
  <li class="nav-item me-2"><a href="index.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Home</a></li>
  <?php
  if (isset($_SESSION['session_id'])) {
    echo '<li class="nav-item me-2"><a href="agenda.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Agenda</a></li>';
    echo '<li class="nav-item me-2"><a href="taken.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Taken</a></li>';
  }
  else {
    echo '<li class="nav-item me-2"><a href="login.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Login</a></li>';
    echo '<li class="nav-item me-2"><a href="register.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Registeren</a></li>';
  }
  if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
    echo '<li class="nav-item me-2"><a href="admin.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Vrijwilligers</a></li>';
    echo '<li class="nav-item me-2"><a href="goedkeuren-taken.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Taken Goedkeuren</a></li>';
  }

  ?>
    <li class="nav-item me-2"><a href="overons.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Over ons</a></li>
    <?php
    if (isset($_SESSION['session_id'])) {
      echo '<li class="nav-item me-2"><a href="uitlog.php" class="nav-link active" aria-current="page" style="background-color: #D4AF37;">Uitlog</a></li>';
    }
    ?>
</ul>

</header>
