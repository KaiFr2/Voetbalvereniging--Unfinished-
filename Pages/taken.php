<?php
include '../Particals/header.php';
require '../Particals/connection.php';
?>
<body class="bg-white">
<div class="container-fluid pt-3">
    <p class="m-1">Uitleg</p>
    <div style='justify-content: space-between' class='d-flex mt-3 mb-3 m-1 p-1 border-bottom border-custom-gold border-1'>
        <h3>Beschikbare taken</h3>
        <?php
        if (isset($_SESSION['admin'])) {
            echo '<a href="index.php" class="btn btn-primary">Taak aanmaken</a>';
        }
        ?>
    </div>
    <div class="bg-custom-1 row m-1 p-1 pt-2 pb-2">
        <?php
        $sql = "SELECT * FROM tasks";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                foreach ($result as $row) {
                    echo '<div class="col-lg-3">';
                    echo '    <div class="bg-white border-start border-2 border-custom-gold rounded">';
                    echo '        <h6 class="m-1">' . $row['titel'] . '</h6>';
                    echo '        <p class="m-1 mt-2">' . $row['locatie'] . '</p>';
                    echo '        <p class="m-1 mt-2">Datum: ' . $row['datum'] . '</p>';
                    echo '        <div class="d-flex" style="justify-content: space-between !important;">';
                    echo '            <p class="m-1">Tijd: ' . $row['begin_uur'] .":" . $row['begin_minuut'] . ' - ' . $row['eind_uur'] .":" . $row['eind_minuut'] . '</p>';
                    echo '            <p class="m-1">0/6</p>';
                    echo '        </div>';
                    echo '        <div style="display: flex !important; justify-content: center !important;">';
                    echo '            <div class="w-100 m-1 mt-2 btn btn-success">Inschrijven</div>';
                    if (isset($_SESSION['admin'])) {
                        echo '            <div class="w-100 m-1 mt-2 btn btn-success">Inschrijven</div>';
                    }
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</div>
</body>
