<?php namespace CupOfTea\Chain;

use CupOfTea\Chain\Contracts\ResultAccess;

class Results implements ResultAccess
{
    /**
     * Wether or not Results can be added to the Results object.
     *
     * @protected bool
     */
    protected $open = true;
    
    /**
     * The Results contained in the Results object.
     *
     * @protected Array
     */
    protected $results = [];
    
    /**
     * Add a result to the Results object.
     *
     * @param string $result Name of the result
     * @param mixed $value Value of the result
     */
    public function addResult($result, $value)
    {
        if (! $this->open) {
            return;
        }
        
        if ($value !== null) {
            $this->results[$result] = $value;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function getResult($result)
    {
        return isset($this->results[$result]) ? $this->results[$result] : null;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getResults()
    {
        return $this->results;
    }
    
    /**
     * Close result set, preventing additional results to be added.
     *
     * @return CupOfTea\Chain\Results Results object
     */
    public function done()
    {
        $this->open = false;
        
        return $this;
    }
    
    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->getResults();
    }
    
    /**
     * Return the result with the specified name.
     *
     * @param  string $result Name of the result
     * @return mixed value of the result
     */
    public function __get($result)
    {
        return $this->getResult($result);
    }
    
    /**
     * Wether or not a result for the name exists.
     *
     * @param  string $result Name of the result
     * @return bool Wether or not a result for the name exists
     */
    public function __isset($result)
    {
        return isset($this->results[$result]);
    }
}
