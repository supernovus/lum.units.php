<?php

require_once 'vendor/autoload.php';

$conf  = json_decode(file_get_contents('./example/units.json'), true);
$units = new Lum\Units\Units($conf);

$classnames =
[
  'd' => 'Distance',
  'a' => 'Area',
  'm' => 'Mass',
  'v' => 'Volume',
  't' => 'Time',
  'b' => 'Bytesize',
];

if ($argc == 2 && trim($argv[1]) == '--list')
{
  $classes = $units->getClasses();
  foreach ($classes as $cid => $class)
  {
    $type = $classnames[$cid];
    echo "[$type]\n";
    foreach ($class->getUnits() as $uid => $unit)
    {
      echo " - $uid\n";
    }
  }
  exit;
}
elseif ($argc != 4)
{
  error_log("usage: {$argv[0]} <value> <in-unit> <to-unit>");
  error_log("or: {$argv[0]} --list  for a list of units.");
  exit(1);
}

$val = floatval(trim($argv[1]));
$in  = trim($argv[2]);
$to  = trim($argv[3]);
$converted = $units->convert($val, $in, $to);

echo "$converted\n";
