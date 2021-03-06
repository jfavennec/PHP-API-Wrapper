<?php

namespace Brightcove\API;

use Brightcove\Object\Player\PlayerList;
use Brightcove\Object\Player\CreateResult;
use Brightcove\Object\Player\PublishComment;
use Brightcove\Object\Player\Player;
use Brightcove\Object\Player\Branch\Configuration\Configuration;

class PM extends API {

  protected function pmRequest($method, $endpoint, $result, $is_array = FALSE, $post = NULL) {
    return $this->client->request($method, 'players', $this->account, $endpoint, $result, $is_array, $post);
  }

  /**
   * @return PlayerList|null
   */
  public function listPlayers() {
    return $this->pmRequest('GET', '/players', '\Brightcove\Object\Player\PlayerList', FALSE);
  }

  /**
   * @param Player $player
   * @return CreateResult|null
   */
  public function createPlayer(Player $player) {
    return $this->pmRequest('POST', '/players', '\Brightcove\Object\Player\CreateResult', FALSE, $player);
  }

  /**
   * @param string $player_id
   * @return Player|null
   */
  public function getPlayer($player_id) {
    return $this->pmRequest('GET', "/players/{$player_id}", '\Brightcove\Object\Player\Branch\Configuration\Player');
  }

  /**
   * @param Player $player
   * @return CreateResult|null
   */
  public function updatePlayer(Player $player) {
    return $this->pmRequest('PATCH', "/players/{$player->getId()}", '\Brightcove\Object\Player\CreateResult', FALSE, $player);
  }

  public function deletePlayer($player_id) {
    return $this->pmRequest('DELETE', "/players/{$player_id}", NULL);
  }

  /**
   * @param string $player_id
   * @param string $branch_name
   *   Must be "master" or "preview"
   * @return Configuration|null
   */
  public function getPlayerConfigurationBranch($player_id, $branch_name) {
    return $this->pmRequest('GET', "/players/{$player_id}/configuration/{$branch_name}", '\Brightcove\Object\Player\Branch\Configuration\Configuration');
  }

  /**
   * @param $player_id
   * @param Configuration $config
   * @return CreateResult|null
   */
  public function updatePlayerConfigurationBranch($player_id, Configuration $config) {
    return $this->pmRequest('PATCH', "/players/{$player_id}/configuration", '\Brightcove\Object\Player\CreateResult', FALSE, $config);
  }

  /**
   * @param string $player_id
   * @param string $comment
   * @return CreateResult|null
   */
  public function publishPlayer($player_id, $comment = '') {
    return $this->pmRequest('POST', "/players/{$player_id}/publish", '\Brightcove\Object\Player\CreateResult', FALSE, (new PublishComment())->setComment($comment));
  }

}
