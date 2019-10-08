# lum.units.php

## Summary

Classes representing different units of measurement, with the ability
to convert between them.

The configuration file format is a bit weird, but it's that way for
historical reasons. I'll probably make it support a nicer format at some
point, while keeping a compatibility wrapper for the original version.

## Classes

| Class                   | Description                                       |
| ----------------------- | ------------------------------------------------- |
| Lum\Units\Units         | The main Units library.                           |
| Lum\Units\Exception     | Something went wrong.                             |
| Lum\Units\HasUnits      | A trait for classes with units.                   |
| Lum\Units\TypeClass     | A container representing a class of units.        |
| Lum\Units\Item          | An individual unit.                               |

## Examples

See `examples` for a sample data file, and a script to convert between the
units defined in it. You can only convert between units of the same type class.
So for instance:

```
php example/convert.php 10 ha ac
# 24.710516301528

php example/convert.php 5 min sec
# 300

php example/convert.php 1.5 b mb
# 1572864

php example/convert.php 10 ha mb
# PHP Fatal error: Uncaught Lum\Units\Exception...
```

## TODO

- Write tests.
- Add new configuration format that is somewhat nicer.
- Add some kind of formatting feature using the 'sign'.

## Official URLs

This library can be found in two places:

 * [Github](https://github.com/supernovus/lum.units.php)
 * [Packageist](https://packagist.org/packages/lum/lum-units)

## Author

Timothy Totten

## License

[MIT](https://spdx.org/licenses/MIT.html)
