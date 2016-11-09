<?php namespace CupOfTea\Chain;

use CupOfTea\Package\Package;
use CupOfTea\Chain\Contracts\ResultAccess;
use CupOfTea\Chain\Exceptions\WrongClassException;
use CupOfTea\Chain\Exceptions\InvalidMethodException;
use CupOfTea\Chain\Exceptions\InvalidContainerException;

class Chain implements ResultAccess
{
    use Package;
    
    /**
     * Package Name.
     *
     * @const string
     */
    const PACKAGE = 'CupOfTea/Chain';
    
    /**
     * Package Version.
     *
     * @const string
     */
    const VERSION = '1.2.1';
    
    /**
     * Container Instance.
     *
     * @protected Object
     */
    protected $container;
    
    /**
     * Required Class.
     *
     * @protected string
     */
    protected $requires;
    
    /**
     * Instance of the Class.
     *
     * @protected Object
     */
    protected $instance;
    
    /**
     * Forgiving mode.
     *
     * @protected bool
     */
    protected $forgiving = false;
    
    /**
     * Method parameters.
     *
     * @protected Array
     */
    protected $parameters = [];
    
    /**
     * Create a new Chain Instance.
     *
     * @param  object $container Container instance used to build the class. Must contain make method to build the class. Suggested container: Illuminate\Container.
     * @throws InvalidContainerException if the provided container does not contain a make method.
     */
    public function __construct($container = null)
    {
        $this->container = $container;
        
        if (! method_exists($container, 'make')) {
            throw new InvalidContainerException($container);
        }
    }
    
    /**
     * Require the Class to be an instance of $class.
     *
     * @param  string   $class
     * @return CupOfTea\Chain\Chain The Chain object.
     */
    public function requires($class)
    {
        $this->requires = $class;
        
        return $this;
    }
    
    /**
     * Specify Class or Class Instance to chain methods on.
     *
     * @param  string|object $class Class or Class Instance to chain methods on.
     * @return CupOfTea\Chain\Chain The Chain object.
     */
    public function on($class)
    {
        $this->instance = is_string($class) ? $this->container !== null ? $this->container->make($class) : new $class : $class;
        
        return $this;
    }
    
    /**
     * Specify the methods to be chained on the Class.
     *
     * @param  mixed $methods String or array of strings, listing the methods to be chained on the Class.
     * @param  string ... Methods to be chained on the Class. If extra parameters are used, first parameter must be a string.
     * @return CupOfTea\Chain\Chain The Chain object.
     */
    public function call($methods)
    {
        $this->methods = is_array($methods) ? $methods : func_get_args();
        
        return $this;
    }
    
    /**
     * Enable forgiving mode. Chain will no longer throw an InvalidMethodException if a method does not exist on the Class.
     *
     * @return CupOfTea\Chain\Chain The Chain object.
     */
    public function forgiving()
    {
        $this->forgiving = true;
        
        return $this;
    }
    
    /**
     * Specify parameters for the Chained methods.
     *
     * @param  mixed $parameters String or array of strings, listing the parameters to be used with the chained methods.
     * @param  string ... Parameters to be used with the chained methods. If extra parameters are used, first parameter must be a string.
     * @return CupOfTea\Chain\Chain The Chain object.
     */
    public function with($parameters)
    {
        $this->parameters = func_get_args();
        
        return $this;
    }
    
    /**
     * Run the Chain of methods on the Class.
     *
     * @return CupOfTea\Chain\Results Object containing the results from each method.
     */
    public function run()
    {
        if ($this->requires !== null && ! $this->instance instanceof $this->requires) {
            throw new WrongClassException(get_class($this->instance), $this->requires);
        }
        
        return array_reduce($this->methods, function ($results, $method) {
            if (! method_exists($this->instance, $method) && ! $this->forgiving) {
                throw new InvalidMethodException(get_class($this->instance), $method);
            }
            
            $results->addResult($method, call_user_func_array([$this->instance, $method], $this->parameters));
            
            return $results;
        }, new Results())->done();
    }
    
    /**
     * Run the Chain with a final destination Callback.
     *
     * @param  callable  $destination Final destination Callback. Will receive the Results object as a parameter.
     * @return mixed The result of the final destination Callback.
     */
    public function then(callable $destination)
    {
        return $destination($this->run());
    }
    
    /**
     * Run the Chain and immediately return the result of the specified method.
     *
     * @param  string $result Method name to return the result of.
     * @return mixed Result of the specified method.
     */
    public function getResult($result)
    {
        return $this->run()->getResult($result);
    }
    
    /**
     * Run the Chain and return the results as an Array.
     *
     * @return array Results of the Chained methods.
     */
    public function getResults()
    {
        return $this->run()->getResults();
    }
    
    /**
     * Alias for getResults.
     *
     * @see CupOfTea\Chain\Chain::getResults()
     */
    public function toArray()
    {
        return $this->run()->toArray();
    }
}
