<?php

namespace Games\Model\Game;

use Games\Model\AbstractModel as AbstractModel;

/**
 * @property $id
 * @property $game_id
 * @property $api_key
 * @property $private_key
 * @property $status
 * @property $description
 * @property $created
 * @method getGame
 */
class ApiKey extends AbstractModel
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $games_id;

    /**
     * @var string
     */
    protected $api_key;

    /**
     * @var string
     */
    protected $private_key;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $created;

    public function initialize() {
        $this->belongsTo('games_id', 'Games\Model\Game', 'id', [
            'alias' => 'game',
        ]);
    }

    public function getSource() {
        return 'games_api_keys';
    }

}

