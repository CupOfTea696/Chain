<?php namespace CupOfTea\Chain;

interface ResultAccess
{
    
    public function getResult($result);
    
    public function getResults();
    
    public function toArray();
    
}