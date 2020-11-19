<?php

require_once 'keys.php';
class Db
{
    private $dbserver = DATABASESERVER;
    private $dbname = DATABASENAME;
    private $dbuser = DATABASEUSER;
    private $dbpass = DATABASEPASSWORD;
    private $db;

    public function __construct()
    {
        try {
            $this->db = new PDO(
                "mysql:host=" . $this->dbserver . ";dbname=" . $this->dbname. ";ssl-mode=REQUIRED", $this->dbuser, $this->dbpass,
                array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8",
                    //PDO::MYSQL_ATTR_SSL_CA => "ca-certificate.crt",
                    //PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => true
                )
            );
        }
        catch (Exception $e) {
            echo "Db connection error";
            exit();
        }
    }


    public function getAllPlayers()
    {
        $query = 'SELECT 
        (kills*10 - deaths*10) - 4*475 AS elo, 
        charName, kills, deaths, gameName, guildName FROM gameUsers ORDER BY elo desc';
        $prepared = $this->db->prepare($query);
        $prepared->execute();
        $values = $prepared->fetchAll(PDO::FETCH_ASSOC);
        
        return $values;
    }

    // Arena Tournament
    public function getArenaPlayers()
    {
        $query = 'SELECT SUM(arenaLog.winCount) as totalWinCount, arenaUsers.captainName, arenaUsers.teamMembersString FROM arenaUsers
        INNER JOIN arenaLog ON arenaUsers.captainName = arenaLog.playerName
        GROUP BY(arenaUsers.captainName)
        ORDER BY totalWinCount DESC';
        $prepared = $this->db->prepare($query);
        $prepared->execute();
        $values = $prepared->fetchAll(PDO::FETCH_ASSOC);
        
        return $values;
    }

    // Arena Tournament
    public function insertArenaLog($playerName, $day, $winCount)
    {
        $query = 'INSERT INTO arenaLog (playerName, day, winCount)
        VALUES (:playerName, :day, :winCount)
        ON duplicate KEY UPDATE winCount = :winCount;';
        $prepared = $this->db->prepare($query);
        $status = $prepared->execute(array(
            ':playerName' => $playerName,
            ':day' => $day,
            ':winCount' => $winCount,
        ));
        return $status;
    }

    // Drop event
    public function insertDropLog($playerName, $dateInserted, $type)
    {
        $query = 'INSERT INTO drops (playerName, dateInserted, type)
        VALUES (:playerName, :dateInserted, :type)';
        $prepared = $this->db->prepare($query);
        $status = $prepared->execute(array(
            ':playerName' => $playerName,
            ':dateInserted' => $dateInserted,
            ':type' => $type,
        ));
        return $status;
    }

    // Drop event
    public function selectAllDropLogsForSpecificDay($day)
    {
        //$query = 'SELECT COUNT(playerName) AS stackCount, playerName, type FROM drops WHERE DAYOFWEEK(dateInserted) = :day ORDER BY COUNT(playerName) GROUP BY playerName, type;';
        $query = 'SELECT COUNT(playerName) AS stackCount, playerName FROM drops WHERE DAYOFWEEK(dateInserted) = :day GROUP BY playerName ORDER BY(stackCount) DESC;';
        $prepared = $this->db->prepare($query);
        $status = $prepared->execute(array(
            ':day' => $day
        ));
        $values = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $values;
    }

    // Drop event
    public function selectDropLogs($type)
    {
        $query = 'SELECT COUNT(playerName) AS stackCount, playerName, type FROM drops WHERE type = :type GROUP BY playerName, type ORDER BY stackCount, playerName asc;';
        $prepared = $this->db->prepare($query);
        $status = $prepared->execute(array(
            ":type" => $type
        ));
        $values = $prepared->fetchAll(PDO::FETCH_ASSOC);
        return $values;
    }


}
?>