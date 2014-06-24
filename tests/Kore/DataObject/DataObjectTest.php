<?php

namespace Kore\DataObject;

class TestDataObject extends DataObject {
    public $property;
}

/**
 * @covers \Kore\DataObject\DataObject
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

    public function testBasicClone()
    {
        $struct = new TestDataObject();
        $struct->property = 42;

        $clone = clone $struct;

        $this->assertSame(
            $struct->property,
            $clone->property
        );
    }

    public function testCloneAggregate()
    {
        $struct = new TestDataObject();
        $struct->property = new TestDataObject();

        $clone = clone $struct;

        $this->assertNotSame(
            $struct->property,
            $clone->property
        );
    }

    public function testCloneAggregateInArray()
    {
        $struct = new TestDataObject();
        $struct->property = array(new TestDataObject());

        $clone = clone $struct;

        $this->assertNotSame(
            $struct->property[0],
            $clone->property[0]
        );
    }

    public function testCloneAggregateInDeepArray()
    {
        $struct = new TestDataObject();
        $struct->property = array(array(new TestDataObject()));

        $clone = clone $struct;

        $this->assertNotSame(
            $struct->property[0][0],
            $clone->property[0][0]
        );
    }

    public function testSetState()
    {
        $struct = new TestDataObject();
        $struct->property = 42;

        $restored = eval("return " . var_export($struct, true) . ';');

        $this->assertEquals($struct, $restored);
        $this->assertNotSame($struct, $restored);
    }

    /**
     * @expectedException \OutOfRangeException
     */
    public function testFailOnInvalidSetState()
    {
        TestDataObject::__set_state(
            array(
                'invalid' => 42,
            )
        );
    }
}
