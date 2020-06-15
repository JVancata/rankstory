<?php
    require 'functions.php';
    $db = new Db();

    // $players = $db->getAllPlayers();
    $players = $db->getArenaPlayers();
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
    <div class="row no-gutters">
        <?php
            for($i=0; $i<count($players); $i++) {
                //getPlayerCard($players[$i], $i+1);
                getArenaCard($players[$i], $i+1);
            }
        ?>
    </div>
</body>

</html>