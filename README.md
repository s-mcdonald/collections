# PHP Collections
[![Source](https://img.shields.io/badge/source-S_McDonald-blue.svg)](https://github.com/s-mcdonald/LucaAccounts)

PHP misses out on what many other languages have such as Generics and Collections. My Collection class helps in this area by defining a abstract collection class and
allowing the child class derived from it to enforce types.
Although my implementation is not Generics, it does allow you to be more type aware and safe with lists and collections of objects.

All you have to do is create your own child class that enforces the types.


## Basic Usage
```
        //
        // Create a Collection
        //
        $collection = new StringCollection();


        //
        // Add items to the Collection
        //
        $collection->push("this is valid");
        $collection->push("foobar");

        //
        // Throws exceptions
        //
        $collection->push(16); //InvalidTypeException


```



## Documentation

* [Features](#features)
* [Installation](#installation)
* [Quick Start](#quick-start)
* [Files](#files)
* [License](#license)

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
To ensure that type checking and type safety is adhered to, it is the responsibility of the child class to maintain which is out of bounds of this package.
The base abstract class provides you with a way to quickly and easily implement this.
See the provided StringCollection class for an example.

<a name="installation"></a>
## Installation

Via Composer. Run the following command from your project's root.

```
composer require s-mcdonald/collections
```


<a name="quick-start"></a>
## Quick-Start

* Extend the `protected safeXxxxMethods()` as shown below.
* For the safeAdd($item) create a method called add()
* To ensure type safety, add a type Hint i.e add(string $value); or add(MyClass $value);
* Then call the protected function safeAdd()

```
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

## License
<a name="license"></a>
Licensed under the terms of the [MIT License](http://opensource.org/licenses/MIT)
