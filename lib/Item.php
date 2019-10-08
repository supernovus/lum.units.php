<?php

namespace Lum\Units;

class Item
{
  public $class; // Our Unit Class.
  public $to;    // Multiply by this to convert this to a base value.
  public $pos;   // The position, for a stepping unit.
  public $sign;  // The symbol to use for the unit in expressions.

  public function __construct ($opts, $class)
  {
    $this->class = $class;
    foreach (['to','pos','sign'] as $field)
    {
      if (isset($opts[$field]))
      {
        $this->$field = $opts[$field];
      }
    }
  }

  public function to_base ($value)
  {
    if (isset($this->to))
    {
      return $value * $this->to;
    }
    return $value;
  }

  public function from_base ($value)
  {
    if (isset($this->to))
    {
      return $value * (1 / $this->to);
    }
    return $value;
  }

  public function convert ($value, $unit)
  {
    if (is_string($unit))
    {
      $unit = $this->class[$unit];
    }
    if (isset($unit) && $unit instanceof Item)
    {
      if (isset($this->pos))
      {
        if (isset($this->class->step))
        {
          $step = $this->class->step;
          $pos1 = $this->pos + 1;
          $pos2 = $unit->pos + 1;
          if ($pos1 == $pos2)
          { // It's the same unit.
            return $value;
          }
          if ($pos1 > $pos2)
          { // We're converting into a larger unit.
            $diff = $pos1 - $pos2;
            $conv = pow($step, $diff);
            return $value / $conv;
          }
          else
          { // We're converting into a smaller unit.
            $diff = $pos2 - $pos1;
            $conv = pow($step, $diff);
            return $value * $conv;
          }
        }
        throw new Exception("No 'step' defined");
      }
      else
      { // We're using to/from conversions.
        $base = $this->to_base($value);
        $base_unit = $this->class->base();
        if ($base_unit === $unit)
          return $base;
        return $unit->from_base($base);
      }
    }
    throw new Exception("Invalid 'to' unit passed to convert()");
  }
}

