<?php namespace CupOfTea\Chain\Exceptions;

use Exception;

class InvalidMethodException extends Exception
{
    
    public function __construct($class, $method, $code = 0, Exception $previous = null)
    {
        $message = "The method $class::$method() does not exist.";
        
        parent::__construct($message, $code, $previous);
    }
    
}
