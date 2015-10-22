<?php namespace CupOfTea\Chain\Exceptions;

use Exception;

class WrongClassException extends Exception
{
    public function __construct($class, $instance, $code = 0, Exception $previous = null)
    {
        $message = "The class $class is not an instance of $instance as required by " . Chain::class . '::requires().';
        
        parent::__construct($message, $code, $previous);
    }
}
