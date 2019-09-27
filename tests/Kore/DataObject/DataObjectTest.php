<?php

namespace Kore\DataObject;

use PHPUnit\Framework\TestCase;

class TestDataObject extends DataObject {
    public $property;
}

/**
 * @covers \Kore\DataObject\DataObject
 */
class DataObjectTest extends TestCase
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

    public function testNonStrictConstructor()
    {
        $struct = new TestDataObject(
            array(
                'property' => 42,
                'nonExistingProperty' => 23,
            ),
            true
        );

        $this->assertSame(42, $struct->property);
    }

    public function testAdditionalParametersNotSet()
    {
        $struct = new TestDataObject(
            array(
                'property' => 42,
                'nonExistingProperty' => 23,
            ),
            true
        );

        $this->assertSame(42, $struct->property);
        $this->expectException(\OutOfRangeException::class);
        $this->assertNull($struct->nonExistingProperty);
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

    public function testGetUnknownValue()
    {
        $struct = new TestDataObject();

        $this->expectException(\OutOfRangeException::class);
        $this->assertNull($struct->unknown);
    }

    public function testConstructorUnknwonValue()
    {
        $this->expectException(\OutOfRangeException::class);
        $struct = new TestDataObject(
            array(
                'unknown' => 42,
            )
        );
    }

    public function testSetUnknownValue()
    {
        $struct = new TestDataObject();
        $this->expectException(\OutOfRangeException::class);
        $struct->unknown = 42;
    }

    public function testUnsetUnknownValue()
    {
        $struct = new TestDataObject();
        $this->expectException(\OutOfRangeException::class);
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

    public function testFailOnInvalidSetState()
    {
        $this->expectException(\OutOfRangeException::class);
        TestDataObject::__set_state(
            array(
                'invalid' => 42,
            )
        );
    }
}
