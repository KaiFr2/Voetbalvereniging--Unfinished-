<?php
$hoursAmount = 12;
$hours = $hoursAmount * 4;
$beginHours = 9;

include '../Particals/header.php';

$dutchDayNames = array('ma', 'di', 'wo', 'do', 'vr', 'za', 'zo');
$dutchMonthNames = array('januari', 'februari', 'maart', 'april', 'mei', 'juni', 'juli', 'augustus', 'september', 'oktober', 'november', 'december');

if (isset($_GET['date'])) {
    $today = $_GET['date'];
} else {
    $today = date('Y-m-d');
}

$day_of_week = date('N', strtotime($today));

$dates = array();
$formattedDays = array();
for ($i = 0; $i < 7; $i++) {
    if(($day_of_week - 1) < $i) {
        $date = date('D j M', strtotime($today . ' + ' . (($i - $day_of_week) + 1) . ' days'));
    } else {
        $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
    }
    $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
    $dayOfMonth = date('j', strtotime($date));
    $monthIndex = date('n', strtotime($date)) - 1; // Month index starting from 0
    $month = strtoupper(substr($dutchMonthNames[$monthIndex], 0, 3));
    $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
    $formattedDays[] = date('d-m-Y', strtotime($date));
}

if (isset($_GET['weekNext'])) {
    $today = date('Y-m-d', strtotime($_GET['date'] . ' + 7 days'));
    $day_of_week = date('N', strtotime($today));

    $dates = array();
    $formattedDays = array();

    for ($i = 0; $i < 7; $i++) {
        $countForward = $i;

        if(($day_of_week - 1) <= $i) {
            $date = date('D j M', strtotime($today . ' + ' . (($i - $day_of_week) + 1) . ' days'));
        } else {
            $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
        }
        $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
        $dayOfMonth = date('j', strtotime($date));
        $monthIndex = date('n', strtotime($date)) - 1; // Month index starting from 0
        $month = strtoupper(substr($dutchMonthNames[$monthIndex], 0, 3));
        $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
        $formattedDays[] = date('d-m-Y', strtotime($date));
    }
}

if (isset($_GET['weekPrevious'])) {
    $today = date('Y-m-d', strtotime($_GET['date'] . ' - 7 days'));
    $day_of_week = date('N', strtotime($today));

    $dates = array();
    $formattedDays = array();

    for ($i = 0; $i < 7; $i++) {
        if(($day_of_week - 1) <= $i) {
            $date = date('D j M', strtotime($today . ' + ' . (($i - $day_of_week) + 1) . ' days'));
        } else {
            $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
        }
        $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
        $dayOfMonth = date('j', strtotime($date));
        $monthIndex = date('n', strtotime($date)) - 1; // Month index starting from 0
        $month = strtoupper(substr($dutchMonthNames[$monthIndex], 0, 3));
        $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
        $formattedDays[] = date('d-m-Y', strtotime($date));
    }
}

$host = '127.0.0.1';
$db   = 'voetbal schoen';
$user = 'root';
$password = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$con = new PDO($dsn, $user, $password);

$datum = $formattedDays[0];

$sth = $con->prepare('SELECT * FROM tasks WHERE datum >= :datum');

$sth->bindParam('datum', $datum);

$sth->execute();
$result = $sth->fetchAll(PDO::FETCH_ASSOC);

$height = 1472;

$scale = $height / ($hoursAmount * 60);
if (Date('H') < $beginHours) {
    $minutes = 0;
} else if (Date('H' ) > 20) {
    $minutes = $hoursAmount * 60;
} else {
    $minutes = ((Date('H') * 60) + Date('i') - ($beginHours * 60));
}
$top = $scale * $minutes;
?>
<body>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHeader"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <span id="modalBodyOne"></span>
                <br></br>
                <span id="modalBodyTwo"></span>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="bg-custom-1 p-1 m-1 container-table">
        <div class="m-2 p-1">
            <div class="row mb-2">
                <div class="w-auto align-items-center p-0 m-1">
                    <form action="agenda.php" method="get">
                        <input type="hidden" name="date" value="<?php echo $today; ?>" />
                        <button type="submit" name="weekPrevious" class="p-0 btn fa fa-caret-square-o-left" aria-hidden="true"></button>
                    </form>
                </div>
                <div class="w-auto align-items-center p-0 m-1">
                    <form action="agenda.php" method="get">
                        <input type="hidden" name="date" value="<?php echo $today; ?>" />
                        <button type="submit" name="weekNext" class="p-0 btn fa fa-caret-square-o-right" aria-hidden="true"></button>
                    </form>
                </div>
                <div class="w-auto">
                    <input type="date" class="form-control" id="datePicker" onfocusout="setDate(this.value)" value="<?php if(isset($_GET['date'])) { echo $_GET['date'];} ?>">
                </div>
            </div>
            <div class="row text-muted responsive-row">
                <div class="p-0 w-auto text-center">
                    <p class="m-0 mb-2 text-light-custom">Column</p>
                    <div class="columns1" style="position: relative;">
                        <div class="time_bar border-top border-1 border-green-custom text-green-custom" style="top: <?php echo $top; ?>px; position: absolute; min-width: calc(100vw - 50px); text-align: left"><?php echo Date('H'); ?>:<?php echo Date('i'); ?></div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        if ($i % 4) {
                            echo '<div class="columns1"></div>';
                        } else {
                            echo '<div class="columns1"></div>';
                        }
                    }
                    ?>
                </div>
                <div class="p-0 w-auto text-center">
                    <p class="m-0 mb-2 text-light-custom">Column</p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        if ($i % 4) {
                            echo '<div class="columns1 border-custom-1 border-end"></div>';
                        } else {
                            echo '<div class="columns1 border-custom-1 border-end" style="display: flex; flex-direction: row; align-items: flex-end">' . (($i / 4) + $beginHours) . ':00</div>';
                        }
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">

                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[0] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom monday">' . $dates[0] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2 monday">' . $dates[0] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[0] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom monday">' . $dates[0] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2 monday">' . $dates[0] . '</p>';
                        }
                    } else {
                        if (date('d-m-Y') == $formattedDays[0]) {
                            echo '<p class="m-0 mb-2 text-green-custom monday">' . $dates[0] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2 monday">' . $dates[0] . '</p>';
                        }
                    }
                    ?>

                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 1) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);
                                    echo '<div class="agenda_field_two_hours2 agenda_field_monday rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                        <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                        <p class="m-0 agenda_field_time">' . $record['begin_uur'] . ':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                      </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>

                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>

                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[1] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom" id="tuesday">' . $dates[1] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2" id="tuesday">' . $dates[1] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[1] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom" id="tuesday">' . $dates[1] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2" id="tuesday">' . $dates[1] . '</p>';
                        }
                    } else {
                        if (date('d-m-Y') == $formattedDays[1]) {
                            echo '<p class="m-0 mb-2 text-green-custom" id="tuesday">' . $dates[1] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2" id="day1" id="tuesday">' . $dates[1] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 2) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours agenda_field_tuesday rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[2] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[2] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[2] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[2] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[2] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[2] . '</p>';
                        }
                    } else {
                        if (date('d-m-Y') == $formattedDays[2]) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[2] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2"">' . $dates[2] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 3) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours2 rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[3] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[3] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[3] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[3] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[3] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[3] . '</p>';
                        }
                    } else {
                        $realDate = date('d-m-Y', strtotime($formattedDays[3] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[3] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[3] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 4) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours2 rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . ((($beginUur - $beginHours) * 30) * 4) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[4] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[4] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[4] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[4] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[4] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[4] . '</p>';
                        }
                    } else {
                        $realDate = date('d-m-Y', strtotime($formattedDays[4] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[4] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[4] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 5) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours2 rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[5] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[5] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[5] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[5] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[5] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[5] . '</p>';
                        }
                    } else {
                        if (date('d-m-Y') == $formattedDays[5]) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[5] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[5] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 6) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours2 rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModl(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>a
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <?php
                    if (isset($_GET['weekNext'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[6] . ' + 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 bg-green-custom text-white">' . $dates[6] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[6] . '</p>';
                        }
                    } else if (isset($_GET['weekPrevious'])) {
                        $realDate = date('d-m-Y', strtotime($formattedDays[6] . ' - 0 days'));

                        if ($realDate == date('d-m-Y')) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[6] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[6] . '</p>';
                        }
                    } else {
                        if (date('d-m-Y') == $formattedDays[6]) {
                            echo '<p class="m-0 mb-2 text-green-custom">' . $dates[6] . '</p>';
                        } else {
                            echo '<p class="m-0 mb-2">' . $dates[6] . '</p>';
                        }
                    }
                    ?>
                    <div class="columns2 border-custom-1">
                        <div class="position">
                            <?php
                            foreach ($result as $record) {
                                if ($record['begin_minuut'] == "00") {
                                    $begin_minuut = "00";
                                } else if ($record['begin_minuut'] == "15") {
                                    $begin_minuut = "15";
                                } else if ($record['begin_minuut'] == "30") {
                                    $begin_minuut = "30";
                                } else {
                                    $begin_minuut = "45";
                                }

                                if ($record['eind_minuut'] == "00") {
                                    $eind_minuut = "00";
                                } else if ($record['eind_minuut'] == "15") {
                                    $eind_minuut = "15";
                                } else if ($record['eind_minuut'] == "30") {
                                    $eind_minuut = "30";
                                } else {
                                    $eind_minuut = "45";
                                }

                                if ($record['dag_nummer'] == 7) {
                                    $eindUur = $record['eind_uur'] + ($record['eind_minuut'] / 60);
                                    $beginUur = $record['begin_uur'] + ($record['begin_minuut'] / 60);

                                    echo '<div class="agenda_field_two_hours2 rounded border-custom-gold border-start border-5 curser-pointer" style="height: ' . (((($eindUur - $beginUur) * 4) * 30) - 5) . 'px; top: ' . (((($beginUur - $beginHours) * 30) * 4)) . 'px;" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="showModal(\''. $record['titel'] .'\',\''. $record['locatie'] .'\',\''. $record['beschrijving'] .'\')">
                                            <p class="m-0 text-overflow-2 text-black" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $record['titel'] . '</p>
                                        <p class="m-0 text-overflow-2" style="text-align: left; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">Locatie: ' . $record['locatie'] . '</p>
                                            <p class="m-0 agenda_field_time">' . $record['begin_uur'] .':' . $begin_minuut . ' - ' . $record['eind_uur'] . ':' . $eind_minuut . '</p>
                                        </div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>