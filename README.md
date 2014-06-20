# Data Object

[![Travis Build Status](https://travis-ci.org/kore/DataObject.svg "Travis Build Status")](https://travis-ci.org/kore/DataObject)

This repository just contains a simple base class for PHP data objects.

This class throws exceptions if you try to read or write unknown properties,
and ensures a clone is performed recursively.

## Usage

To use this data object base class for your own data objects, just use
something like this:

```php
class Person extends \Kore\DataObject\DataObject
{
    public $prename;

    public $forename;
}
```

If you now access unknown properties you will get exceptions. For more details
on the motivation behind this, read:
http://qafoo.com/blog/016_struct_classes_in_php.html
