<?php

namespace Kore\DataObject;

class TestDataObject extends Struct {
    public $property;
}

/**
 * @covers \Kagency\CouchdbEndpoint\DataObject
 */
class DataObjectTest extends \PHPUnit_Framework_TestCase
{
    public function testGetValue()
    {
        $struct = new TestDataObject();

        $this->assertNull($struct->property);
    }

    public function testConstructor()
    {
        $struct = new TestDataObject(
            array(
                'property' => 42,
            )
        );

        $this->assertSame(42, $struct->property);
    }

    public function testSetValue()
    {
        $struct = new TestDataObject();
        $struct->property = 42;

        $this->assertSame(42, $struct->property);
    }

    public function testUnsetValue()
    {
        $struct = new TestDataObject();
        $struct->property = 42;
        unset($struct->property);

        $this->assertFalse(isset($struct->property));
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testGetUnknownValue()
    {
        $struct = new TestDataObject();

        $this->assertNull($struct->unknown);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testConstructorUnknwonValue()
    {
        $struct = new TestDataObject(
            array(
                'unknown' => 42,
            )
        );
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testSetUnknownValue()
    {
        $struct = new TestDataObject();
        $struct->unknown = 42;
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testUnsetUnknownValue()
    {
        $struct = new TestDataObject();
        unset($struct->unknown);
    }
}
