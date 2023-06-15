<?php
include '../Particals/header.php';
require '../Particals/connection.php';
?>
<body class="bg-white">
<div class="container-fluid pt-3">
    <p class="m-1">Hier kan je beschikbare taken vinden, als je een hebt gevonden die je graag wil doen kan je op inschrijven klikken en wachten totdat de taak door een van de administratoren is goedgekeurd. Wanneer hij is goedgekeurd zal die bij de agenda komen te staan.</p>
    <div style='justify-content: space-between' class='d-flex mt-3 mb-3 m-1 p-1 border-bottom border-custom-gold border-1'>
        <h3>Beschikbare taken</h3>
        <?php
        if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo '<a href="taak-aanmaken.php" class="btn btn-primary">Taak aanmaken</a>';
        }

        if (isset($_POST['inschrijven'])) {
            $userid = $_SESSION['user_id'];
            $taakid = $_POST['inschrijven_id'];
            $stmt = $conn->prepare("INSERT INTO users_tasks(user_id, task_id, goedgekeurd) VALUES (?, ?, ?)");
            $goed = "0";
            $stmt->bind_param("iii", $userid, $taakid, $goed);
            $stmt->execute();
            if ($stmt->error) {
                echo "Error: " . $stmt->error;
            } else {
                echo "Data inserted successfully!";
            }
        }
        ?>
    </div>
    <div class="bg-custom-1 row m-1 p-1 pt-2 pb-2">
        <?php
        $today = date('d-m-Y');
        $sql = "SELECT * FROM tasks WHERE STR_TO_DATE(datum, '%d-%m-%Y') > STR_TO_DATE(?, '%d-%m-%Y')";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                foreach ($result as $row) {
                    echo '<div class="col-lg-3 p-0">';
                    echo '    <div class="m-1 row bg-white border-start border-2 border-custom-gold rounded mb-2">';
                    echo '        <h6 class="m-1 p-0">' . $row['titel'] . '</h6>';
                    echo '        <p class="m-1 mt-2 p-0">' . $row['locatie'] . '</p>';
                    echo '        <p class="m-1 mt-2 p-0">Datum: ' . $row['datum'] . '</p>';
                    echo '        <div class="d-flex p-0" style="justify-content: space-between !important;">';
                    echo '            <p class="m-1">Tijd: ' . $row['begin_uur'] .":" . $row['begin_minuut'] . ' - ' . $row['eind_uur'] .":" . $row['eind_minuut'] . '</p>';
                    echo '            <p class="m-1">0/6</p>';
                    echo '        </div>';
                    echo '        <div class="col-lg-12">';
                    echo '        <div class="row">';
                    echo '            <div class="col-lg-6 p-1"><form method="POST" class="w-100"> <input type="hidden" value="' . $row['id'] .'" name="inschrijven_id"><input type="submit" name="inschrijven" class="btn btn-success w-100" value="Inschrijven"></div></form>';
                    if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
                        echo '            <div class="col-lg-6 p-1"><a href="wijzig-taak.php?id=' . $row['id'] .'" class="w-100 btn btn-success">Wijzig taak</a></div>';
                    }
                    
                    echo '        </div>';
                    echo '    </div>';
                    echo '    </div>';
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</div>
</body>
