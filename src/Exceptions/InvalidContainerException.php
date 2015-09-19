<?php namespace CupOfTea\Chain\Exceptions;

use Exception;

class InvalidContainerException extends Exception
{
    
    public function __construct($container, $code = 0, Exception $previous = null)
    {
        $message = 'The provided Container <strong>' . get_class($container) . '</strong> does not have the method <strong>make</strong>';
        
        parent::__construct($message, $code, $previous);
    }
    
}
