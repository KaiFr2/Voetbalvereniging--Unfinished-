<?php
$hours = 12 * 4;
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

for ($i = 0; $i < 7; $i++) {
    if(($day_of_week - 1) < $i) {
        $date = date('D j M', strtotime($today . ' + ' . ($i - ($day_of_week - 1)) . ' days'));
    } else {
        $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
    }
    $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
    $dayOfMonth = date('j', strtotime($date));
    $month = strtoupper(substr(strftime('%B', strtotime($date)), 0, 3));
    $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
}

foreach ($dates as $index => $date) {
    $dayNumber = $index + 1;
    echo 'Day ' . $dayNumber . ': ' . $date . "\n";
}

if (isset($_GET['weekNext'])) {
    $today = date('Y-m-d', strtotime($_GET['date'] . ' + 7 days'));
    $day_of_week = date('N', strtotime($today));

    $dates = array();
    for ($i = 0; $i < 7; $i++) {
        $countForward = $i;

        if(($day_of_week - 1) <= $i) {
            $date = date('D j M', strtotime($today . ' + ' . ($i - 2) . ' days'));
        } else {
            $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
        }
        $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
        $dayOfMonth = date('j', strtotime($date));
        $month = strtoupper(substr(strftime('%B', strtotime($date)), 0, 3));
        $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
    }
}

if (isset($_GET['weekPrevious'])) {
    $today = date('Y-m-d', strtotime($_GET['date'] . ' - 7 days'));
    $day_of_week = date('N', strtotime($today));

    $dates = array();
    for ($i = 0; $i < 7; $i++) {
        if(($day_of_week - 1) <= $i) {
            $date = date('D j M', strtotime($today . ' + ' . ($i - 2) . ' days'));
        } else {
            $date = date('D j M', strtotime($today . ' - ' . (($day_of_week - $i) - 1) . ' days'));
        }
        $dayName = strtoupper(substr($dutchDayNames[$i], 0, 2));
        $dayOfMonth = date('j', strtotime($date));
        $month = strtoupper(substr(strftime('%B', strtotime($date)), 0, 3));
        $dates[] = $dayName . ' ' . $dayOfMonth . ' ' . $month;
    }
}
?>
<body>
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
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        if ($i % 4) {
                            echo '<div class="columns2 border-custom-1 border-end"></div>';
                        } else {
                            echo '<div class="columns2 border-custom-1 border-end" style="display: flex; flex-direction: row; align-items: flex-end">' . (($i / 4) + $beginHours) . ':00</div>';
                        }
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[0]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[1]; ?></p>
                    <div class="columns2 border-custom-1 border-end">
                        <div class="position">
                            <div class="agenda_field_two_hours2 rounded border-custom-1 border-start border-5 curser-pointer">
                                <p class="m-0 text-overflow text-black">safffffffffsafffffffffsafffffffffsafffffffffsafffffffffsafffffffffsafffffffff</p>
                                <p class="m-0 text-overflow-2">safffffffffsafffffffffsafffffffffsafffffffffsafffffffffsafffffffffsafffffffff</p>
                                <p class="m-0 agenda_field_time">11:00 - 12:00</p>
                            </div>
                        </div>
                    </div>
                    <?php
                    for ($i = 0; $i < ($hours - 1); $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[2]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[3]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[4]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[5]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1 border-end"></div>';
                    }
                    ?>
                </div>
                <div class="p-0 col text-center">
                    <p class="m-0 mb-2" id="day1"><?php echo $dates[6]; ?></p>
                    <?php
                    for ($i = 0; $i < $hours; $i++) {
                        echo '<div class="columns2 border-custom-1"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>