<?php
require 'functions.php';
$db = new Db();

// $players = $db->getAllPlayers();
// $players = $db->getArenaPlayers();
$day = date("N") + 1 % 7;

if (!empty($_GET["day"]) && is_numeric($_GET["day"])) {
    $day = $_GET["day"];
}

$dayOfWeek = "";
switch ($day % 8) {
    case 1:
        $dayOfWeek = "Neděle";
        break;
    case 2:
        $dayOfWeek = "Pondělí";
        break;
    case 3:
        $dayOfWeek = "Úterý";
        break;
    case 4:
        $dayOfWeek = "Středa";
        break;
    case 5:
        $dayOfWeek = "Čtvrtek";
        break;
    case 6:
        $dayOfWeek = "Pátek";
        break;
    case 7:
        $dayOfWeek = "Sobota";
        break;
}

$players;
$playersGreen;
$playersBlue;
$playersRed;
if (!empty($_GET["total"])) {
    $playersGreen = $db->selectDropLogs(1);
    $playersBlue = $db->selectDropLogs(2);
    $playersRed = $db->selectDropLogs(3);
    $dayOfWeek = "Celkem";
} else {
    $players = $db->selectAllDropLogsForSpecificDay($day);
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Story ranking!</title>
    <link rel="icon" href="favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="icon" href="favicon.ico">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style.css">
    <meta charset="utf-8">
</head>

<body class="bgimg container">
    <div class="row no-gutters" style="padding-top:250px;">
        <h1 class="text-center text-white w-100 mb-4"><?php echo $dayOfWeek; ?></h1>
        <div class="button-div pb-4">
            <a class="btn button" href="index.php?day=2">Pondělí</a>
            <a class="btn button" href="index.php?day=3">Úterý</a>
            <a class="btn button" href="index.php?day=4">Středa</a>
            <a class="btn button" href="index.php?day=5">Čtvrtek</a>
            <a class="btn button" href="index.php?day=6">Pátek</a>
            <a class="btn button" href="index.php?day=7">Sobota</a>
            <a class="btn button" href="index.php?day=1">Neděle</a>
            <a class="btn button-gold" href="index.php?total=true">Celkem</a>
        </div>
        <div class="col-12">
            <div class="container-tight m-0-auto row">
                <?php
                //getPlayerCard($players[$i], $i+1);
                if (!empty($_GET["total"])) {
                    getDropColumns($playersGreen, $playersBlue, $playersRed);
                } else {
                    for ($i = 0; $i < count($players); $i++) {
                        getDropCard($players[$i]);
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>