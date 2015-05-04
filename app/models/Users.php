<?php

use Phalcon\Mvc\Model\Validator\Email as Email;

class Users extends \Phalcon\Mvc\Model
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var integer
     */
    public $role_id;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $login;

    /**
     * @var string
     */
    public $network;

    /**
     * @var string
     */
    public $network_id;

    /**
     * @var string
     */
    public $full_name;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $created;

    /**
     * Validations and business logic
     */
    public function validation() {

        $this->validate(new Email([
            'field' => 'email',
            'required' => true,
        ]));
        if ($this->validationHasFailed()) {
            return false;
        }
    }

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return [
            'id' => 'id',
            'role_id' => 'role_id',
            'email' => 'email',
            'login' => 'login',
            'network' => 'network',
            'network_id' => 'network_id',
            'full_name' => 'full_name',
            'password' => 'password',
            'created' => 'created'
        ];
    }

}
