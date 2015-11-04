<!-- header start -->
[![Latest Stable Version](https://poser.pugx.org/cupoftea/chain/version.svg)](https://packagist.org/packages/cupoftea/chain) [![Total Downloads](https://poser.pugx.org/cupoftea/chain/d/total.svg)](https://packagist.org/packages/cupoftea/chain)
[![Latest Unstable Version](https://poser.pugx.org/cupoftea/chain/v/unstable.svg)](https://packagist.org/packages/cupoftea/chain)
[![StyleCI](https://styleci.io/repos/38836274/shield)](https://styleci.io/repos/38836274) [![License](https://poser.pugx.org/cupoftea/chain/license.svg)](https://packagist.org/packages/cupoftea/chain)

# Chain
## Call a chain of methods on an object.
<!-- header end -->

Chain provides an easy way to chain a set of methods on an object.

Chain provides a set of methods to suit your chaining needs. From requiring you class to be an instance of an earlier specified class to getting back the results from each called method, Chain's got it all. For more info, check the Documentation or browse through the full API.

 - [Documentation](http://chain.cupoftea.io/docs/)
 - [API Reference](http://chain.cupoftea.io/docs/api/)

## Quickstart

```bash
$ composer require cupoftea/chain ^1.2
```

```php
$chain = new Chain();
$chain->requires(MyInterface::class)
    ->on(MyClass::class))
    ->call('method1', 'method2')
    ->with($parameter1, $parameter2)
    ->run();

$method1_result = $chain->getResult('method1');
```
