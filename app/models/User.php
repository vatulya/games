<?php

namespace Games\Model;

use Phalcon\Mvc\Model\Validator\Email as Email;

/**
 * @property $id
 * @property $role_id
 * @property $email
 * @property $login
 * @property $network
 * @property $network_id
 * @property $fullname
 * @property $password
 * @property $created
 */
class User extends AbstractModel
{

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var integer
     */
    protected $role_id;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $network;

    /**
     * @var string
     */
    protected $network_id;

    /**
     * @var string
     */
    protected $full_name;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var string
     */
    protected $created;

    /**
     * Validations and business logic
     */
    public function validation() {

        $this->validate(new Email([
            'field' => 'email',
            'required' => true,
        ]));

        if (!$this->validationHasFailed()) {
            return true;
        }

        return false;
    }

    public function getSource() {
        return 'users';
    }

}
