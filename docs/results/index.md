---
layout: default
---

# Chained Method Results
<!-- [[TOC]] -->

Chain provides a number of ways to access the return values from the Chained methods. By default, the `run` method returns a Result Object, but there are some shortcuts to access any return values provided on the Chain Object as well.

## Getting Result Of A Specific Method

To get the result of a specific method, you can call the `getResult` method once you have run the Chain. This allows you to get several results while disregarding other results. Use the method name you want the return value for as a parameter. You can also access the return values of a method as a property of the Results object.

```php
$chain = new Chain()
$results = $chain->call('method1', 'method2', 'method3')
    ->on($object)
    ->run();

$method1_result = $results->getResult('method1');
$method3_result = $results->method3;
```

If you only need the return value of a single method, instead of calling the `run` method on the Chain, you can instantly call `getResult` on the Chain instead. Please note that when doing this, you lose all access to any other return values unless you run the same chain again.

```php
$chain = new Chain()
$method1_result = $chain->call('method1', 'method2', 'method3')
    ->on($object)
    ->getResult('method1');

// Calling getResult again would result in the entire Chain being executed a second time. Avoid doing this.
$method2_result = $chain->getResult('method2');
```

## Getting All Results

To get all results as an Array, you can call `getResults` on the Results Object, or on the Chain itself. If you call `getResults` on the Chain, you lose the possibility to access any of the other methods on the Results object. Alternatively, you can call the `toArray` method, which is simply an alias for the `getResults` method on both the Results and the Chain object.

```php
$results = $chain->run();
$results_array = $results->toArray();
$results_array = $results->getResults();
$method1_result = $results->getResult('method1'); // $results_array['method1'] == $method1_result

$results_array = $chain->toArray();
$results_array = $chain->getResults();
```

## Executing A Callback On The Results

Lastly, you can execute a final Callback after running the Chain using the `then` method. This Callback will receive the Results object as a parameter, so you can manipulate the results before returning them. Don't forget to return the Results Object or any other return value you still want to use.

```php
$results = $chain->then(function($results){
    // Modify a result before returning it
    $results->method1 = strtoupper($results->method1);
    $method2_result = $results->getResult('method2');
    $results->modResult('method2', strtoupper($method2_result));
    
    return $results;
});

$results = $chain->then(function($results){
    return strtoupper($method1) . ' - ' . $method2;
});
```
