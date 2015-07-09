<?php namespace CupOfTea\Chain;

class Results
{
    
    protected $open = true;
    
    protected $results;
    
    public function addResult($result, $value)
    {
        if (!$this->open) {
            return;
        }
        
        if ($value !== null) {
            $this->results[$result] = $value;
        }
    }
    
    public function getResult($result)
    {
        return $this->results[$result];
    }
    
    public function done()
    {
        $this->open = false;
    }
    
    public function __get($result)
    {
        return $this->getResult($result);
    }
    
    public function __isset($result)
    {
        return isset($this->results[$result]);
    }
    
}
