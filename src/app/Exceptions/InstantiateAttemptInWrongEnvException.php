<?php

namespace App\Exceptions;

use Exception;

class InstantiateAttemptInWrongEnvException extends Exception
{
    protected $message = 'Factory instantiate function called to instantiate with test data while not in test env';
}
