<?php

class Games extends \Phalcon\Mvc\Model
{

    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $code;

    /**
     * Independent Column Mapping.
     */
    public function columnMap() {
        return [
            'id' => 'id',
            'code' => 'code'
        ];
    }

}
