<?php

namespace SamMcDonald\Collections\Components;

use SamMcDonald\Collections\Contracts\ArrayableInterface;

abstract class Collection implements \IteratorAggregate
{
    /*
     * Internal array container
     * 
     * @var array
     */
    private $items;

    private $enforceType;


    /*
     * protected constructor. Can only be 
     * called from child class. This is
     * to enforce types if the chil 
     * class chooses to do so.
     */
    protected function __construct($items = [], bool $enforceType = false) 
    {  
        $items = $this->getArrayableItems($items);
        
        $this->enforceType = $enforceType;

        if($this->enforceType)
        {
            foreach ($items as $key => $item) 
            {
                $this->typeCheck($item);
            }
        }

        $this->items = $items;
    }

 
    /*
     *
     * Iterators and Accessors
     * 
     * These methods are all marked as final and public
     * They are used to iterate, access or perform simple
     * functions to the items in the stack. 
     *
     * They do not alter the internal stack.
     * 
     */
    

    /**
     * Get the stack as array.
     * 
     * @return [type] [description]
     */
    final public function all()
    {
        return $this->items;
    }


    /**
     * $colelction->get(4);
     * 
     * @param  [type] $key     [description]
     * @param  [type] $default [description]
     * @return [type]          [description]
     */
    final public function get($key, $default = null)
    {
        if ($this->exists($key, $this->items)) 
        {
            return $this->items[$key];
        }

        return $default;
    }


    /**
     * Count of items in the stack.
     * 
     * @return [type] [description]
     */
    final public function count()
    {
        return count($this->items);
    }


    /**
     * Check if key exists.
     * 
     * @param  string $key [description]
     * @return [type]      [description]
     */
    final public function exists($key = '') : bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * Check if stack has a value.
     * 
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    final public function contains($value) : bool
    {
        return in_array($value, $this->items);
    }

    /**
     * Divide stack into array for keys and array of values.
     * 
     * @return [type] [description]
     */
    final public function divide()
    {
        return [array_keys($this->items), array_values($this->items)];
    }

    /**
     * Check if stack is empty.
     * 
     * @return boolean [description]
     */
    final public function isEmpty() : bool
    {
        return empty($this->items);
    }

    /**
     * Opposite of isEmpty()
     * @return boolean [description]
     */
    final public function isNotEmpty() : bool
    {
        return ! $this->isEmpty();
    }

    /**
     * Returns the key if found
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    final public function search($value)
    {
        return array_search($value, $this->items);
    }


    /**
     * $collection->each(function($item,$key) {
     *     echo $item;
     * })
     *
     * @author Taylor Otwell - Adopted from Laravel
     * @param  callable $callback [description]
     * @return [type]             [description]
     */
    final public function each(callable $callback)
    {
        foreach ($this->items as $key => $item) 
        {
            if ($callback($item, $key) === false) 
            {
                break;
            }
        }

        return $this;
    }


    /**
     * $collection->last(function($last_item){
     *     return $last_item->id == 5;
     * });
     *
     * 
     * @param  callable|null $callback [description]
     * @return [type]                  [description]
     */
    final public function last(callable $callback = null)
    {
        if($this->count() <= 0)
        {
            return false;
        }

        $items = $this->items;

        $last_item = array_pop($items);

        if (isset($callback))
        {
            call_user_func($callback, $last_item);
        }

        return $last_item;
    }


    final public function first(callable $callback = null)
    {
        $items = $this->items;

        $ar = array_reverse($items, true);

        $col = new static($ar);
        return $col->last($callback);
    }


    final public function removeWhere(callable $condition)
    {
        $items = $this->items;

        foreach ($items as $key => $value)
        {
            if ($condition($value))
            {
                unset($items[$key]);
            }
        }

        return new static($items);
    }

    final public function shuffle()
    {
        $items = $this->items;

        shuffle($items);

        return new static($items);
    }


    final public function reverse()
    {
        $items = $this->items;

        return new static(array_reverse($items, true));
    }

    /**
     * Filter/Where the internal stack
     * @param  callable $condition [description]
     * @return [type]              [description]
     */
    final public function where(callable $condition)
    {
        $items = [];

        foreach ($this->items as $item) 
        {
            if ($condition($item)) 
            {
                $items[] = $item;
            }
        }

        return new static($items);
    }

    final public function except(...$keys)
    {
        $items = $this->items;

        foreach ($items as $key => $value) 
        {
            if(in_array($key,$keys))
            {
                unset($items[$key]);
            }
        }

        return new static($items);
    }

    /**
     * Create a new collection consisting of every n-th element.
     *
     * @param  int  $step
     * @param  int  $offset
     * @return static
     */
    final public function nth($step, $offset = 0)
    {
        $items = [];

        $position = 0;

        foreach ($this->items as $item) 
        {
            if ($position % $step === $offset) 
            {
                $items[] = $item;
            }

            $position++;
        }

        return new static($items);
    }


    /*
     |
     | Mutators

     | These methods will affect and alter 
     | the internal list. The visibility 
     | of the methods that are marked as 
     | protected will also be prefixed 
     | with 'safe' = safeMethodName().
     |
     | eg: pop == safePop()
     |
     | This allows the child class to control 
     | the type safety nature of the list.
     | 
     */
    

    /**
     * Empty/clear the list.
     * 
     * usage: $collection->clear();
     * 
     * @return $this [description]
     */
    final public function clear()
    {
        unset($this->items);
        $this->items = [];
        return $this;
    }


    /**
     * Resets the internal array keys
     * @return $this 
     */
    final public function reset()
    {
        $this->items = array_values($this->items);
        return $this;
    }


    /**
     * safePop -   pop the last el off the stack.
     *             To ensure type safety, this 
     *             must be called from child.
     *             
     * @return mixed returns the last popped element in the list
     */
    final protected function safePop()
    {
        if($this->count() <= 0)
        {
            return null;
        }

        return array_pop($this->items);
    }

    /**
     * safePush -  Push element onto the stack.
     *             To ensure type safety, this 
     *             must be called from child.
     *             
     * @param  mixed  $item 
     * @return $this  The no. of items in list
     */
    final protected function safePush($item)
    {
        if($this->enforceType)
        {        
            $this->typeCheck($item);
        }
        $this->items[] = $item;

        return $this;
    }


    /**
     * safeInsert -  Insert item to a specific position
     *               within the stack.
     *               
     *               To ensure type safety, this 
     *               must be called from child class.
     *             
     * @param  mixed  $item 
     * @param int $position Index of item to be placed within the internal array
     * @return $this  The no. of items in list
     */
    final protected function safeInsert($item, int $position = 0)
    {
        // @dev: safe to do so
        if(($this->count() > $position) && ($position > 0))
        {
            if($this->enforceType)
            {        
                $this->typeCheck($item);
            }

            $this->arrayInsertAt($item, $position);
        }
        elseif(($this->count() == 0) || ($position == 0))
        {
            return $this->safePrepend($item);
        }
        elseif($position > $this->count())
        {
            $this->items[] = $item;
        }

        return $this;
    }


    //@dev
    private function arrayInsertAt($item,$position)
    {
        $items = $this->items;
        $first = array_splice($items, 0, ($position)); 
        $first[] = $item;
        $this->items = array_merge($first,$items);
    }

    /**
     * safeUnset - Unset value from the stack.
     *             If internal keys are
     *             0,1,2,3,4,5 - and you unset(3)
     *             result will be
     *             0,1,2,4,5 - key are preserved.
     *             
     * @param  mixed $key Key of the stack item
     * @return $this      
     */
    final protected function safeUnset($key)
    {
        if($this->exists($key))
        {
            unset($this->items[$key]);
        }

        return $this;
    }


    /*
     |
     | Immutators

     | These methods will return a nwe colelction
     | and not affect or alter the internal list. 
     | The visibility are marked as protected 
     | and also prefixed with 'safe' = safeMethodName().
     |
     | eg: pop == safePop()
     |
     | This allows the child class to control 
     | the type safety nature of the list.
     | 
     */

    final protected function safeAdd($item)
    {
        if($this->enforceType)
        {        
            $this->typeCheck($item);
        }
        $items = $this->items;

        $items[] = $item;

        return new static($items);
    }

    final protected function safeRemove($item, $key = null)
    {
        $items = $this->items;

        if($key === null)
        {
            if($key = $this->search($item))
            {
                unset($items[$key]);
            }
        }
        else
        {
            if(array_key_exists($key, $items))
            {
                if($items[$key] == $item)
                {
                    unset($items[$key]);
                }
            }     
        }

        return new static($items);
    }


    final protected function safePrepend($item)
    {
        if($this->enforceType)
        {        
            $this->typeCheck($item);
        }
        $items = $this->items;

        array_unshift($items, $item);

        return new static($items);
    }


    final protected function safeMerge($array)
    {
        $items = $this->getArrayableItems($array);

        return new static(array_merge($this->items, $items));
    }


    final protected function safeCombine($array)
    {
        $items = $this->getArrayableItems($array);

        return new static(array_combine($this->items, $items));
    }



    /**
     * Convert the collection to its string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toJson();
    }

    public function toString()
    {
        return $this->toJson();
    }

    public function toJson($options = 0)
    {
        return json_encode($this->items, $options);
    }

    public function toArray()
    {
        return $this->items;
    }

    private function getArrayableItems($items)
    {
        if (is_array($items)) 
        {
            return $items;
        } 
        elseif ($items instanceof self) 
        {
            return $items->all();
        } 
        elseif ($items instanceof ArrayableInterface) 
        {
            return $items->toArray();
        }

        return (array) $items;
    }


    protected function typeCheck($value = null)
    {
        return true;
    }


    /**
     * Ability to run a foreach on the class
     * 
     * @return [type] [description]
     */
    public function getIterator() 
    {
        return new \ArrayIterator($this->items);
    }    
}