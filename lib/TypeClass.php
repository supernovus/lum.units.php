<?php

namespace Lum\Units;

class TypeClass implements \ArrayAccess, \Countable, \Iterator
{
  use HasUnits;

  public $ident;    // A typeclass identifier. Generally a single letter.
  public $base;     // The id of our baseline unit (if applicable.)
  public $step;     // Step increment between units (if applicable.)

  public function __construct ($opts=[], $ident=null)
  {
    $this->ident = $ident; // May be overwritten by 'ident' option.

    foreach(['base','step','ident'] as $field)
    {
      if (isset($opts[$field]))
      {
        $this->$field = $opts[$field];
      }
    }

    if (isset($opts['units']) && is_array($opts['units']))
    { // Add all the units passed to the constructor.
      $this->add_units($opts['units']);
    }
  }

  /**
   * Add a set of units all at once via an associative array structure.
   */
  public function add_units (array $units)
  {
    foreach ($units as $uid => $udef)
    {
      if (is_array($udef))
      {
        $this->add_unit($udef, $uid);
      }
    }
  }

  /**
   * Add a new unit via a simple array definition.
   */
  public function add_unit (array $udef, $ident=null)
  {
    // Build the Item instance.
    $unit = new Item($udef, $this, $ident);

    // Add the Item with validation checks, etc.
    $this->addUnit($unit, $ident);

    if (!isset($this->base) && isset($udef['base']) 
      && is_bool($udef['base']) && $udef['base'])
    { // It's the base unit for this typeclass.
      $this->base = $unit->ident;
    }

    if (!isset($this->step) && isset($udef['step']) 
      && is_numeric($udef['step']) && $udef['step'] != 0)
    { // The step size for this type class was defined in this unit def.
      $this->step = $udef['step'];
    }

    return $unit;
  }

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

