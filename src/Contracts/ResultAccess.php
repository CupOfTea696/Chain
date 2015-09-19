<?php namespace CupOfTea\Chain\Contracts;

interface ResultAccess
{
    
    /**
     * Return the result with the specified name.
     *
     * @param  string $result Name of the result
     * @return mixed value of the result
     */
    public function getResult($result);
    
    /**
     * Return all results as an associative array where the keys are the name of the result.
     *
     * @return Array The results
     */
    public function getResults();
    
    /**
     * Alias for getResults.
     *
     * @see CupOfTea\Chain\Contracts\ResultAccess::getResults()
     */
    public function toArray();
    
}