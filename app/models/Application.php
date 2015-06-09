<?php

namespace Games\Model;

use Phalcon\Mvc\Model\ResultsetInterface as ResultsetInterface;
use Games\Model\Application\ApiKey as ApiKey;
use Games\Model\Application\Game as Game;

/**
 * @property $id
 * @property $title
 * @property $code
 * @property $status
 * @property $description
 * @property $url
 * @method ApiKey getApiKey
 * @method Game[]|ResultsetInterface getGames
 */
class Application extends AbstractModel
{

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $code;

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
    protected $url;

    public function initialize() {
        $this->hasOne('id', 'Games\Model\Application\ApiKey', 'applications_id', [
            'alias' => 'apiKey',
        ]);
        $this->hasMany('id', 'Games\Model\Application\Game', 'applications_id', [
            'alias' => 'games',
        ]);
    }

    public function getPermissionsCompiled() {
        // TODO: get all permissions, compile permissions groups and return simple array
        return [
            ['my'],
            ['games'],
        ];
    }

    /**
     * @param $code
     *
     * @return Application
     */
    static public function findByCode($code) {
        return static::findFirst(['code' => $code]);
    }

    public function getSource() {
        return 'applications';
    }

}
