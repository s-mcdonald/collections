<?php declare(strict_types = 1);

namespace SamMcDonald\Collections;

use SamMcDonald\Collections\Components\Collection;
use SamMcDonald\Collections\Exceptions\InvalidTypeException;

class StringCollection extends Collection
{

    /*
     * Create the Collection with defaults
     */
    public function __construct($items = []) 
    {  
        // true to enforce types
        parent::__construct($items, true);
    }


    /**
     * pop()
     * 
     * @return mixed string|null
     */
    public function pop()
    {
        return parent::safePop();
    }


    /**
     * push(string)
     * 
     * @param  string $item [description]
     * @return $this        [description]
     */
    public function push(string $item)
    {
        return parent::safePush($item);
    }


    /**
     * unset(int)
     * 
     * @param  string $key [description]
     * @return $this       [description]
     */
    public function unset(string $key)
    {
        return parent::safeUnset($key);
    }


    /**
     * Typed add.
     * 
     * @param string $item [description]
     */
    public function add(string $item)
    {
        return parent::safeAdd($item);
    }

    /**
     * remove(string)
     * 
     * @param  string $item [description]
     * @return [type]       [description]
     */
    public function remove(string $item)
    {
        return parent::safeRemove($item);
    }

    /**
     * prepend(string)
     * 
     * @param  string $item [description]
     * @return [type]       [description]
     */
    public function prepend(string $item)
    {
        return parent::safePrepend($item);
    }

    /**
     * merge(collection)
     * 
     * @param  AccountCollection $collection [description]
     * @return [type]                        [description]
     */
    public function merge(StringCollection $collection)
    {
        return parent::safeMerge($collection);
    }

    /**
     * combine(collection)
     * 
     * @param  AccountCollection $collection [description]
     * @return [type]                        [description]
     */
    public function combine(StringCollection $collection)
    {
        return parent::safeCombine($collection);
    }

    /**
     * Checks for type safety
     * This is called by the base-class
     * 
     * @param  [type] $value [description]
     * @return [type]        [description]
     */
    protected function typeCheck($value = null)
    {
        if(is_string($value))
        {
            return true;
        }
        throw new InvalidTypeException("Is not a valid type", 1);
    }

}