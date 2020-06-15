<?php
    require('keys.php');
    
    if(empty($_POST["token"]) || $_POST["token"] !== INSERTTOKEN) {
        exit();
    }

    if(empty($_POST["playerName"]) || empty($_POST["day"]) || empty($_POST["winCount"])) {
        exit();
    }
    
    require('db.php');

    $db = new Db();
    $db->insertArenaLog($_POST["playerName"], $_POST["day"], $_POST["winCount"]);