<?php

namespace Games\Library;

/**
 * Class Datetime
 *
 * This class is helper with methods to work with Date and Time
 */
class Datetime
{

    /**
     * @return string
     */
    static public function getMicrotime()
    {
        list ($micro) = explode(' ', microtime());
        $micro = str_replace('0.', '', $micro);
        return $micro;
    }

}