# PHP Collections
[![Source](https://img.shields.io/badge/source-S_McDonald-blue.svg)](https://github.com/s-mcdonald/LucaAccounts)

PHP misses out on what many other languages have such as Generics and Collections. My Collection class helps in this area by defining a abstract collection class and allowing the child class derived from it to enforce types. Although my implementation is not Generics, it does allow you to be more type aware and safe with lists and collections of objects. All you have to do is create your own child class that enforces the types.


<a name="installation"></a>
## Installation

Via Composer. Run the following command from your project's root.

```
    composer require s-mcdonald/collections

```



<a name="usage"></a>
## Basic Usage

```php

        // Create a new collection
        $collection = new StringCollection();


        // Push items onto the stack
        $collection->push('foo');
        $collection->push('bar');
        $collection->push('baz')->push('jaz'); 


        // perform .each(i,k)
        $collection->each(function($item, $key){
            echo $item.' has key '.$key;
        });

```

This will output;

```

        foo has key 0
        bar has key 1
        baz has key 2
        jaz has key 3

```


## Navigation

* [Basic Usage](#usage)
* [Installation](#installation)
* [Basic Commands](#basic-commands)
* [Documentation](#documentation)
* [Quick-Start](#quick-start)
* [Files](#files)
* [License](#license)








<a name="basic-commands"></a>
### Basic Commands

```php

        $collection->get(1);           // string
        $collection->exists(2);        // true
        $collection->exists(7);        // false
        $collection->contains('foo');  // true
        $collection->contains('food'); // false
        $collection->isEmpty();        // false
        $collection->isNotEmpty();     // true
        $collection->search('bar');    // performs array_search and retrieves key of 1
        $collection->prepend('dazzling'); // insert item at begining of stack.

```


<a name="documentation"></a>
## Other Commands



The `add(..)` and `remove(..)` functions returns a new collection while `push` will push a new item to the current collection.

### add()
```php

        $collection->add("a")
        $collection->add("b")->add("c");

```

### remove()
```php

        $collection->remove('b');

```


### removeWhere()

A conditional remove function.

```php
        $collection->removeWhere(function($obj){
            return ($obj == "testbed3");
        });
```


### where()


```php

        echo $collection->where(function($obj){
            return (substr($obj,0,1) == 'f');
        });

```



### shuffle()


```php

        $collection->shuffle();


```


### reverse()


```php

        $collection->reverse();

```




### except($keys)


```php

        $collection->except(2,5,7);

```


### reverse()


```php


        $collection->reverse();

```



### nth(n)

Get every nth

```php


        $collection->nth(3);
        
```




### first(n)

First element

```php

        echo $collection->first(function($obj){
            echo ($obj);
        });

```



### last(n)

Last element

```php

        echo $collection->last(function($obj){
            echo ($obj);
        });

```






### merge(arrayable)

Merge an array, collection or arrayable.


```php

        $collection1 = new StringCollection();
        $collection2 = new StringCollection();

        $collection1->push('foo');
        $collection1->push('bar');   

        $collection2->push('baz');
        $collection2->push('daz');

        echo $collection1->merge($collection2);

```



### combine()

Performs array_combine()

```php


        $collection1 = new StringCollection();
        $collection2 = new StringCollection();

        $collection1->push('foo');
        $collection1->push('bar');   

        $collection2->push('baz');
        $collection2->push('daz');

        echo $collection1->combine($collection2);


```


### toString()

```php

        echo $collection->shuffle()->toString();
        echo $collection->toString();
        echo $collection;

```




## Issues
This is still in development and Im working on fixing some of the TypeSafty checks.


<a name="features"></a>
## Features

1) Type checking/safety.
2) Method chaining.
3) Extensible.
4) Flexible type checking based on your requirements.


<a name="note"></a>
## Note
To ensure that type checking and type safety is adhered to, it is the responsibility of the child class to maintain which is out of bounds of this package. The base abstract class provides you with a way to quickly and easily implement this. See the provided StringCollection class for an example.




<a name="quick-start"></a>
## Quick-Start

* Extend the `protected safeXxxxMethods()` as shown below.
* For the `safeAdd($item)` create a method called `add()`
* To ensure type safety, add a type Hint i.e `add(string $value);` or `add(MyClass $value)`;
* Then call the protected function `safeAdd()`

```php
      public function add(string $item)
      {
          return parent::safeAdd($item);
      }
```



<a name="files"></a>
## Files

```
s-mcdonald/collections/
            │    
            └ src/
              │    
              ├── Components/
              │   │
              │   └── Collection.php
              │            
              ├── Contracts/
              │   │
              │   ├── ArrayableInterface.php
              │   │            
              │   └── CollectionInterface.php
              │            
              │  
              ├── Exceptions/
              │   │
              │   └── InvalidTypeException.php
              │
              │
              │
              └── StringCollection.php

```


### License
<a name="license"></a>
Licensed under the terms of the [MIT License](http://opensource.org/licenses/MIT)
