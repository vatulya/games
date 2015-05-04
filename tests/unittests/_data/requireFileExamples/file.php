<?php

use Phalcon\Di as Di;

Di::getDefault()->set('test1', function () { return 'test1'; });