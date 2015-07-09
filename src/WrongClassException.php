<?php namespace CupOfTea\Chain;

use Exception;

class WrongClassException extends Exception
{
    
    public function __construct($class, $isnt, $code = 0, Exception $previous = null)
    {
        $message = "The class $class is not an instance of $isnt as required by " . Chain::class . "::requires().";
        
        parent::__construct($message, $code, $previous);
    }
    
}
