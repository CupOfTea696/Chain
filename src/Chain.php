<?php namespace CupOfTea\Chain;

use CupOfTea\Chain\Results;
use CupOfTea\Package\Package;

class Chain
{
    
    use Package;
    
    /**
     * Package Name
     *
     * @const string
     */
    const PACKAGE = 'CupOfTea/Chain';
    
    /**
     * Package Version
     *
     * @const string
     */
    const VERSION = '0.0.0';
    
    protected $container;
    
    protected $instance;
    
    protected $parameters = [];
    
    public function __construct($container = null)
    {
        $this->container = $container;
    }
    
    public function on($class)
    {
        $this->instance = is_string($class) ? $this->container !== null ? $this->container->make($class) : new $class : $class;
        
        return $this;
    }
    
    public function call($methods)
    {
        $this->methods = is_array($methods) ? $methods : func_get_args();
        
        return $this;
    }
    
    public function with($parameters)
    {
        $this->parameters = func_get_args();
        
        return $this;
    }
    
    public function run()
    {
        return array_reduce($this->methods, function($results, $method) {
            $results->addResult($method, call_user_func_array([$this->instance, $method], $this->parameters));
            
            return $results;
        }, new Results)->done();
    }
    
    /**
     * Run the chain with a final destination callback.
     *
     * @param  callable  $destination
     * @return mixed
     */
    public function then(callable $destination)
    {
        return $destination($this->run());
    }
}
