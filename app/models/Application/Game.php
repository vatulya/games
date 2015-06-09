<?php

namespace Games\Model\Application;

use Games\Model\AbstractModel as AbstractModel;
use Games\Model\Application as Application;

/**
 * @property $id
 * @property $application_id
 * @property $created
 * @method Application getApplication
 */
class Game extends AbstractModel
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
    protected $hash;

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
        return 'applications_games';
    }

    /**
     * @param array|null $data
     * @param array|null $whiteList
     * @return bool
     */
    public function save($data = null, $whiteList = null) {
        if (!$this->id) {
            // insert
            $this->setHash();
            $this->created = time();
        } else {
            unset($data['hash'], $data['created']);
        }
        return parent::save($data, $whiteList);
    }

    /**
     * @param string $hash
     */
    public function setHash($hash = '') {
        if (empty($hash)) {
            $hash = $this->generateHash();
        }
        $this->hash = $hash;
    }

    public function toArray($columns = null) {
        $array = parent::toArray($columns);
        unset($array['applications_id']);
        $array['application_code'] = $this->getApplication()->code;
        return $array;
    }

    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function generateHash()
    {
        $attempts = 5;
        do {
            $hash = md5(uniqid() . microtime());
            if ($this->checkHashDuplicate($hash)) {
                $hash = '';
            }
            $attempts--;
        } while ($attempts > 0 && !$hash);

        if (!$hash) {
            throw new \RuntimeException('Game hash generator error');
        }
        return $hash;
    }

    /**
     * @param string $hash
     *
     * @return bool
     */
    protected function checkHashDuplicate($hash)
    {
        $check = static::count([
            'hash = :hash:',
            'bind' => [
                'hash' => $hash,
            ],
        ]);
        return ($check > 0);
    }

}

