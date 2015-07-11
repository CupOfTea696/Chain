<?php namespace CupOfTea\Chain\Contracts;

interface ResultAccess
{
    
    public function getResult($result);
    
    public function getResults();
    
    public function toArray();
    
}