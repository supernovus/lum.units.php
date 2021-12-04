<?php

namespace Lum\Units;

/**
 * Common Units operations.
 *
 * Return information about Units, including conversion numbers.
 */
trait HasUnits
{
  protected $units = [];

  public function getUnits ()
  {
    return $this->units;
  }

  public function convert ($value, $from, $to)
  {
    if (is_string($from))
    {
      $from = $this->units[$from];
    }
    if (isset($from) && $from instanceof Item)
    {
      return $from->convert($value, $to);
    }
    throw new Exception("Invalid 'from' unit passed to convert()");
  }

  /**
   * Add a new unit Item object.
   */
  public function addUnit (Item $unit, $ident=null)
  {
    if (!$ident)
    { // No ident passed, find one in the Item.
      if ($unit->ident)
        $ident = $unit->ident;
      else
        throw new Exception("No identifier found for unit");
    }
    elseif (!isset($unit->ident))
    { // The unit Item has no ident, set it. 
      $unit->ident = $ident;
    }

    if (isset($this->units[$unit]))
    {
      throw new Exception("Attempt to overwrite existing unit '$ident'");
    }

    // We passed all checks, let's assign it now.
    $this->units[$ident] = $unit;

    return $this;
  }

  /**
   * Return the total count of units in our class.
   */
  public function count ()
  {
    return count($this->units);
  }

  /**
   * Does a unit exist?
   */
  public function offsetExists ($offset)
  {
    return isset($this->units[$offset]);
  }

  /**
   * Get a Unit
   */
  public function offsetGet ($offset)
  {
    if (isset($this->units[$offset]))
      return $this->units[$offset];
  }

  /**
   * Add a unit to our units.
   */
  public function offsetSet ($offset, $value)
  {
    if ($value instanceof Item)
      $this->units[$offset] = $value;
    else
      throw new Exception("Invalid Unit item.");
  }

  /**
   * We don't allow unsetting units.
   */
  public function offsetUnset ($offset)
  {
    throw new Exception("Cannot unset Units.");
  }

  // Iterator interface.

  public function current ()
  {
    return current($this->units);
  }

  public function key ()
  {
    return key($this->units);
  }

  public function next ()
  {
    return next($this->units);
  }

  public function rewind ()
  {
    return reset($this->units);
  }

  public function valid ()
  {
    return ($this->current() !== False);
  }

}

