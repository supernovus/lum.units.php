<?php

namespace Lum\Units;

class TypeClass implements \ArrayAccess, \Countable, \Iterator
{
  use HasUnits;

  public $base;     // The id of our baseline unit (if applicable.)
  public $step;     // Step increment between units (if applicable.)

  /**
   * Return the base item class.
   */
  public function base ()
  {
    if (isset($this->base))
    {
      return $this->units[$this->base];
    }
    throw new Exception("No base unit defined");
  }

  public function units ()
  {
    return array_keys($this->units);
  }

}

