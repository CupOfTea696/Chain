---
layout: default
---

# Usage
<!-- [[TOC]] -->

_**Note:** The following Documentation assumes you have a `use` statement for the `CupOfTea\Chain\Chain` object and abbreviates the full object name to `Chain` for readability._

## Creating The Chain Object

When constructing the Chain Object, you can provide an Application Container to build Classes with. We suggest using [Illuminate\Container](https://github.com/illuminate/container) for this, although any similar containers will do the job just fine as long as the Container has a make method. Of course, the use of a Container is completely optional, and you can just Construct a new Chain instance without any parameters.

```php
$chain = new Chain($container);

$chain = new Chain();
```

## Basic Usage

The minimum methods you need to call on the Chain object are `on`, `call` and `run`. These are respectively used to specify a Class to run the Chain on, the Chain of methods to be called, and execute the chain. The order of any methods called on the Chain Object before `run` is not important.

The `on` methods both excepts a Class Name (string) or a Class Instance (object). If a Class Name is provided, Chain will create a new Instance of this Class. If you specified a Container in the Constructor, Chain will use the Container to build it.

The `call` method accepts both an Array of methods, or you can just pass each method as a new string parameter.

```php
$chain->on(MyClass::class)
    ->call('method1', 'method2')
    ->run();

$chain->call(['method1', 'method2'])
    ->on($myClass)
    ->run();
```

## Chained Method Parameters

Chain allows you to call the Chained methods with a set of parameters you provide. You can do this by using the `with` method. It takes either an Array of parameters or a set of parameters as arguments. It will call each method with those parameters.

```php
$chain->with('string', $object, 6, true);

$array = ['red', 5, false];
$chain->with($array)
```

## Class Validation

If you want the Class you are Chaining methods on to be an instance of a Class or Interface, you can use the `requires` method. This method can both be called before or after specifying the Chaining Class, since the check only happens once you run the Chain.

```php
$chain->requires(MyInterface::class)
    ->on(MyClass::class);
```

## Dealing With Missing Methods

Chain has a 'Forgiving' Mode, in order to not throw an Exceptions when any of the methods is not found on the provided Class. Simply call the `forgiving` method on the Chain Object to switch to Forgiving Mode.
