<?php
    require('keys.php');
    
    if(empty($_POST["token"]) || $_POST["token"] !== INSERTTOKEN) {
        exit();
    }

    if(empty($_POST["playerName"]) || empty($_POST["dateInserted"]) || empty($_POST["type"])) {
        exit();
    }
    
    require('db.php');

    $db = new Db();
    $db->insertDropLog($_POST["playerName"], $_POST["dateInserted"], $_POST["type"]);