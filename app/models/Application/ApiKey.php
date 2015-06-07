<?php

namespace Games\Model\Application;

use Games\Model\AbstractModel as AbstractModel;

/**
 * @property $id
 * @property $game_id
 * @property $api_key
 * @property $private_key
 * @property $status
 * @property $description
 * @property $created
 * @method getApplication
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
    protected $applications_id;

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
        $this->belongsTo('applications_id', 'Games\Model\Application', 'id', [
            'alias' => 'application',
        ]);
    }

    public function getSource() {
        return 'applications_api_keys';
    }

}

