<?php

use Phalcon\Di as Di;

Di::getDefault()->set('test2 environment', function () { return 'test2 environment'; });