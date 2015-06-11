<?php

namespace Games\Collection\Api;

use Games\Collection\AbstractCollection as AbstractCollection;

/**
 * @property $id
 * @property $api_key
 * @property $token
 * @property $status
 * @property $created
 */
class Token extends AbstractCollection
{

    const STATUS_ACTIVE = 'active';
    const STATUS_USED = 'used';
    const STATUS_EXPIRED = 'expired';
    const STATUS_BLOCKED = 'blocked';

    const TOKEN_LIFETIME = 300; // 5 minutes in seconds

    const GARBAGE_COLLECTOR_CHANCE = 20; // 1/20

    /**
     * @param string|null $token
     */
    public function setToken($token = null)
    {
        if ($token === null) {
            $token = $this->generateToken();
        }
        $this->token = $token;
    }

    public function getSource()
    {
        return "tokens";
    }

    public function save()
    {
        if (!$this->id) {

            static::garbageCollector();

            $this->setToken();
            $this->status = static::STATUS_ACTIVE;
            $this->created = time();
        }
        parent::save();
    }

    /**
     * @return string
     *
     * @throws \RuntimeException
     */
    protected function generateToken()
    {
        $attempts = 5;
        do {
            $token = md5(uniqid() . microtime());
            if ($this->checkTokenDuplicate($token)) {
                $token = '';
            }
            $attempts--;
        } while ($attempts > 0 && !$token);

        if (!$token) {
            throw new \RuntimeException('API Token generator error');
        }
        return $token;
    }

    /**
     * @param string $token
     * @return bool
     */
    protected function checkTokenDuplicate($token)
    {
        $check = static::findFirst([
            [
                'token' => $token,
            ],
        ]);
        return (bool)($check);
    }

    /**
     * Garbage Collector runs before each create new token
     * You can use const GARBAGE_COLLECTOR_CHANCE set chance of skipping
     * GC find all Active tokens to Expired based on Created field
     *
     * @return bool
     */
    static protected function garbageCollector()
    {
        if (rand(0, static::GARBAGE_COLLECTOR_CHANCE)) return true; // 1/20 chance

        /** @var self[] $tokens */
        $tokens = static::find([
            'status' => static::STATUS_ACTIVE,
            'created' < time() - static::TOKEN_LIFETIME,
        ]);
        foreach ($tokens as $token) {
            $token->status = static::STATUS_EXPIRED;
            $token->save();
        }
        return true;
    }

}


