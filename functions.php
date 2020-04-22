<?php
  include 'db.php';
  

  function calculateRank($elo) {
    return floor( $elo / 500 )+5;
  }

  function getPlayerCard($playerData, $position)  {
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
    $playerIconX = $playerNameNumber%56;
    $playerIconY = $playerNameNumber%6;
    echo '
      <div class="col-12 row no-gutters bg-story-color py-3 my-2">
          <div class="col-2">
              <span class="position pt-2">'.$position.'.</span>
          </div>
          <div class="col-2">
              <span
              style="background-position: '.($playerIconX*72).'px '.($playerIconY*72).'px"
              class="d-block head-icon">
              </span>
          </div>
          <div class="col-3">
              <span class="player-name">'.$playerName.'</span>
              <span class="player-guild">'.$playerGuild.'</span>
          </div>
          <div class="col-2">
              <span class="player-kills pt-2">'.$playerKills.'/'.$playerDeaths.'</span>
          </div>
          <div class="col-3 text-right">
              <img 
                src="img/'.$rank.'.png" class="rank mr-5"
              />
          </div>
      </div>
    ';
  }
?>