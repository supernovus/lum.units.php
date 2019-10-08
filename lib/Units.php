<?php

namespace Lum\Units;

class Units implements \ArrayAccess, \Countable, \Iterator
{
  use HasUnits;

  protected $classes; // A list of classes.

  /**
   * Build a Units object.
   */
  public function __construct ($conf)
  {
    $classes = [];
    $units = [];
    foreach ($conf as $uid => $udef)
    {
      $cid = $udef['class'];
      if (!isset($classes[$cid]))
        $classes[$cid] = new TypeClass();
      $class = $classes[$cid];
      $unit = new Item($udef, $class);
      $class[$uid] = $unit;
      $units[$uid] = $unit;
      if (isset($udef['base']) && $udef['base'])
        $class->base = $uid;
      if (isset($udef['step']))
        $class->step = $udef['step'];
    }
    $this->classes = $classes;
    $this->units = $units;
  }

  /**
   * Return all our known type classes.
   */
  public function getClasses ()
  {
    return $this->classes;
  }

  /**
   * Return a specific type class if it was found.
   */
  public function getclass ($class)
  {
    if (isset($this->classes[$class]))
      return $this->classes[$class];
  }

}

