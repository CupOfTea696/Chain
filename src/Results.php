<?php namespace CupOfTea\Chain;

use CupOfTea\Chain\Contracts\ResultAccess;

class Results implements ResultAccess
{
    
    protected $open = true;
    
    protected $results = [];
    
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
        return isset($this->results[$result]) ? $this->results[$result] : null;
    }
    
    public function getResults()
    {
        return $this->results;
    }
    
    public function done()
    {
        $this->open = false;
        
        return $this;
    }
    
    public function toArray()
    {
        return $this->getResults();
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
