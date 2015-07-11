<?php namespace CupOfTea\Chain;

use CupOfTea\Package\Package;
use CupOfTea\Chain\Contracts\ResultAccess;
use CupOfTea\Chain\Exceptions\WrongClassException;
use CupOfTea\Chain\Exceptions\InvalidMethodException;

class Chain implements ResultAccess
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
    const VERSION = '1.2.1';
    
    protected $container;
    
    protected $requires;
    
    protected $instance;
    
    protected $forgiving = false;
    
    protected $parameters = [];
    
    public function __construct($container = null)
    {
        $this->container = $container;
    }
    
    public function requires($class)
    {
        $this->requires = $class;
        
        return $this;
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
    
    public function forgiving()
    {
        $this->forgiving = true;
    }
    
    public function with($parameters)
    {
        $this->parameters = func_get_args();
        
        return $this;
    }
    
    public function run()
    {
        if ($this->requires !== null && !$this->instance instanceof $this->requires) {
            throw new WrongClassException(get_class($this->instance), $this->requires);
        }
        
        return array_reduce($this->methods, function($results, $method) {
            if (!method_exists($this->instance, $method) && !$this->forgiving) {
                throw new InvalidMethodException(get_class($this->instance), $method);
            }
            
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
    
    public function getResult($result)
    {
        return $this->run()->getResult($result);
    }
    
    public function getResults()
    {
        return $this->run()->getResults();
    }
    
    public function toArray()
    {
        return $this->run()->toArray();
    }
    
}
