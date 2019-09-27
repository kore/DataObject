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

In some cases it might be necessary that additional attributes can be passed while construction and are knowingly
ignored and not added to the DataObject. Therefore a constructor parameter `$ignoreAdditionalAttributes` has been added,
which is set to `false` by default, but could be set to `true` in the rare cases when needed.
This will allow to create a DataObject of an array with more values where the additional values will be ignored and no
exception will be thrown **during** construction. If you later try to access a property which is not existing though,
an exception will be raised!
