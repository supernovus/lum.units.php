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

    if (isset($this->units[$ident]))
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
  public function count (): int
  {
    return count($this->units);
  }

  /**
   * Does a unit exist?
   */
  public function offsetExists ($offset): bool
  {
    return isset($this->units[$offset]);
  }

  /**
   * Get a Unit
   */
  public function offsetGet ($offset): mixed
  {
    if (isset($this->units[$offset]))
      return $this->units[$offset];
  }

  /**
   * Add a unit to our units.
   */
  public function offsetSet ($offset, $value): void
  {
    if ($value instanceof Item)
      $this->units[$offset] = $value;
    else
      throw new Exception("Invalid Unit item.");
  }

  /**
   * We don't allow unsetting units.
   */
  public function offsetUnset ($offset): void
  {
    throw new Exception("Cannot unset Units.");
  }

  // Iterator interface.

  public function current (): mixed
  {
    return current($this->units);
  }

  public function key (): mixed
  {
    return key($this->units);
  }

  public function next (): void
  {
    next($this->units);
  }

  public function rewind (): void
  {
    reset($this->units);
  }

  public function valid (): bool
  {
    return ($this->current() !== False);
  }

}

