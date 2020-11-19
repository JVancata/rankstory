<?php
include 'db.php';


function calculateRank($elo)
{
  return floor($elo / 500) + 5;
}

function getPlayerCard($playerData, $position)
{
  //$playerName = $playerData["charName"];
  $playerName = $playerData["charName"];
  $playerGuild = $playerData["guildName"];
  $playerKills = $playerData["kills"];
  //$playerKills = 23;
  $playerDeaths = $playerData["deaths"];
  //$playerDeaths = 5;
  $playerElo = $playerData["elo"];
  //$playerElo = -2500;
  $rank = calculateRank($playerElo);
  $playerNameNumber = base_convert($playerName, 32, 10);
  $playerIconX = $playerNameNumber % 56;
  $playerIconY = $playerNameNumber % 6;
  echo '
      <div class="col-12 row no-gutters bg-story-color py-3 my-2">
          <div class="col-2">
              <span class="position pt-2">' . $position . '.</span>
          </div>
          <div class="col-2">
              <span
              style="background-position: ' . ($playerIconX * 72) . 'px ' . ($playerIconY * 72) . 'px"
              class="d-block head-icon">
              </span>
          </div>
          <div class="col-3">
              <span class="player-name">' . $playerName . '</span>
              <span class="player-guild">' . $playerGuild . '</span>
          </div>
          <div class="col-2">
              <span class="player-kills pt-2">' . $playerKills . '/' . $playerDeaths . '</span>
          </div>
          <div class="col-3 text-right">
              <img 
                src="img/' . $rank . '.png" class="rank mr-5"
              />
          </div>
      </div>
    ';
}

function getArenaCard($playerData, $position)
{
  //$playerName = $playerData["charName"];
  $captainName = $playerData["captainName"];
  $teamMembers = $playerData["teamMembersString"];
  $totalWinCount = $playerData["totalWinCount"];
  $playerNameNumber = base_convert($captainName, 32, 10);
  $playerIconX = $playerNameNumber % 56;
  $playerIconY = $playerNameNumber % 6;
  echo '
      <div class="col-12 row no-gutters bg-story-color py-3 my-2">
          <div class="col-3">
              <span class="position pt-2">' . $position . '.</span>
          </div>
          <div class="col-4">
            <div class="col-12 row no-gutters p-0">
              <div class="col-2 d-none d-md-block">
                <span
                  style="background-position: ' . ($playerIconX * 36) . 'px ' . ($playerIconY * 36) . 'px"
                  class="d-inline-block head-icon">
                </span>
              </div>
              <div class="col-10">
                <span class="player-name">' . $captainName . '</span>
              </div>
            </div>
            <span class="player-guild">' . $teamMembers . '</span>
          </div>
          <div class="col-5">
              <span class="player-kills pt-2">' . $totalWinCount . ' výher</span>
          </div>
      </div>
    ';
}

function getDropCard($player)
{
  //$playerName = $playerData["charName"];
  $playerName = $player["playerName"];
  $stackCount = $player["stackCount"];
  $playerNameNumber = base_convert($playerName, 32, 10);
  $playerIconX = $playerNameNumber % 56;
  $playerIconY = $playerNameNumber % 6;

  $position = "";

  if ($stackCount >= 9600) {
    $position = "3. odměna";
  } elseif ($stackCount >= 4800) {
    $position = "2. odměna";
  } else if ($stackCount >= 2400) {
    $position = "1. odměna";
  }

  echo '
      <div class="col-12 row no-gutters bg-story-color py-3 my-2">
          <div class="col-4 pl-4">
            <div class="col-12 row no-gutters p-0">
              <div class="col-2 d-none d-md-block pt-2">
                <span
                  style="background-position: ' . ($playerIconX * 36) . 'px ' . ($playerIconY * 36) . 'px"
                  class="d-inline-block head-icon">
                </span>
              </div>
              <div class="col-10 pl-2">
                <span class="player-name-drop">' . $playerName . '</span>
              </div>
            </div>
          </div>
          <div class="col-5">
              <span class="player-kills">' . ($stackCount * 200) . ' bylin</span>
          </div>
          <div class="col-3">
              <span class="player-kills">' . $position . '</span>
          </div>
      </div>
    ';
}

function getTotalDropCard($player)
{
  //$playerName = $playerData["charName"];
  $playerName = $player["playerName"];
  $stackCount = $player["stackCount"];
  $playerNameNumber = base_convert($playerName, 32, 10);
  $playerIconX = $playerNameNumber % 56;
  $playerIconY = $playerNameNumber % 6;

  $type = "";

  switch ($player["type"]) {
    case 1:
      $type = "Zelených";
      break;
    case 2:
      $type = "Modrých";
      break;
    case 3:
      $type = "Červených";
      break;
  }

  echo '
      <div class="col-12 row no-gutters bg-story-color py-3 my-2">
          <div class="col-12 pl-2">
            <div class="col-12 row no-gutters p-0">
              <div class="col-2 d-none d-md-block pt-2">
                <span
                  style="background-position: ' . ($playerIconX * 36) . 'px ' . ($playerIconY * 36) . 'px"
                  class="d-inline-block head-icon">
                </span>
              </div>
              <div class="col-10 pl-3">
                <span class="player-name-drop">' . $playerName . '</span>
              </div>
            </div>
          </div>
          <div class="col-12">
              <span class="player-kills">' . ($stackCount * 200) . ' bylin</span>
          </div>
      </div>
    ';
}

function getDropColumns($playersGreen, $playersBlue, $playersRed)
{
  getDropColumnContent($playersGreen, "Zelené");
  getDropColumnContent($playersBlue, "Modré");
  getDropColumnContent($playersRed, "Červené");
}

function getDropColumnContent($column, $name)
{
  echo '<div class="col-md-4">';
  echo '<h2 class="text-white">' . $name . "</h2>";
  for ($i = 0; $i < count($column); $i++) {
    getTotalDropCard($column[$i]);
  }
  echo '</div>';
}
