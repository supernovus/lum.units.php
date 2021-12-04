<?php

namespace Lum\Units;

class Units implements \ArrayAccess, \Countable, \Iterator
{
  use HasUnits;

  protected $classes = []; // A list of classes.

  /**
   * Build a Units object.
   */
  public function __construct ($conf=null)
  {
    if (is_array($conf))
    { // The array configuration data was passed.
      $this->loadArray($conf);
    }
    elseif (is_string($conf))
    { // A string is assumed to be a configuration file.
      $this->loadFile($conf);
    }
  }
 
  /**
   * Load units from an associative array.
   */
  public function loadArray (array $conf)
  {
    foreach ($conf as $uid => $udef)
    {
      $cid = $udef['class'];
      if (!isset($classes[$cid]))
        $classes[$cid] = new TypeClass([], $cid);
      $class = $classes[$cid];
      $unit = $class->add_unit($udef, $uid);
      $this->addUnit($unit, $uid);
    }
  }

  /**
   * Load units from a JSON configuration file.
   */
  public function loadFile (string $filename)
  {
    if (file_exists($filename) && is_readable($filename) && is_file($filename))
    {
      $json = json_decode(file_get_contents($file), true);
      if (isset($json) && is_array($json))
      {
        return $this->loadArray($json);
      }
      else
      {
        throw new Exception("File '$filename' does not contain valid JSON");
      }
    }
    else
    {
      throw new Exception("Invalid file '$filename' specified");
    }
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

