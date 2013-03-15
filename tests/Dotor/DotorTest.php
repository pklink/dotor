<?php

namespace Dotor;

class DotorTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Dotor;
     */
    protected $instance;

    /**
     * @var array
     */
    protected $array;

    public function setUp()
    {
        $this->array = [
            'bla' => 'blu',
            'level0' => [
                '01' => '001',
                '02' => '002',
                '03' => [
                    'index'  => 'value',
                    'object' => new \stdClass(),
                    'int'    => 3,
                ],
            ],
            'false'      => false,
            'true'       => true,
            'zeroString' => '0',
            'zeroInt'    => 0,
            'oneString'  => '1',
            'oneInt'     => 1,
        ];

        $this->instance = new Dotor($this->array);
    }

    public function testGet()
    {
        $this->assertEquals($this->array, $this->instance->get(null));
        $this->assertEquals(null, $this->instance->get(''));

        $this->assertEquals('blu', $this->instance->get('bla'));
        $this->assertEquals($this->array['level0'], $this->instance->get('level0'));
        $this->assertEquals('001', $this->instance->get('level0.01'));
        $this->assertEquals('002', $this->instance->get('level0.02'));
        $this->assertEquals($this->array['level0']['03'], $this->instance->get('level0.03'));
        $this->assertEquals('value', $this->instance->get('level0.03.index'));
        $this->assertEquals(new \stdClass(), $this->instance->get('level0.03.object'));

        $this->assertEquals(null, $this->instance->get('notexist'));
        $this->assertEquals(null, $this->instance->get('asdasdwq.yxcasad'));
        $this->assertEquals(12312, $this->instance->get('asdasdwq.yxcasad', 12312));
        $this->assertEquals('yep', $this->instance->get('....', 'yep'));
        $this->assertEquals('yep', $this->instance->get('bla....', 'yep'));

        // array
        try {
            $this->instance->get(array());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }

        // object
        try {
            $this->instance->get(new \stdClass());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }
    }


    public function testGetArray()
    {
        $this->assertEquals($this->array['level0'], $this->instance->getArray('level0'));
        $this->assertEquals($this->array['level0']['03'], $this->instance->getArray('level0.03'));
        $this->assertEquals([], $this->instance->getArray('level0.03.object'));
        $this->assertEquals(array(1), $this->instance->getArray('level0.03.object', array(1)));
        $this->assertEquals([], $this->instance->getArray('asdqyyyf'));
        $this->assertEquals(array(1), $this->instance->getArray('asdqyyyf', array(1)));
    }


    public function testGetScalar()
    {
        $this->assertEquals('blu', $this->instance->getScalar('bla'));
        $this->assertEquals('002', $this->instance->getScalar('level0.02'));
        $this->assertEquals('', $this->instance->getScalar('level0.03.object'));
        $this->assertEquals(55, $this->instance->getScalar('level0.03.object', 55));
        $this->assertEquals('', $this->instance->getScalar('asdqyyyf'));
        $this->assertEquals(55, $this->instance->getScalar('asdqyyyf', 55));

        // non scalar default
        $this->assertEquals('blu', $this->instance->getScalar('bla', new \stdClass()));

        try {
            $this->instance->getScalar('level0.03.object', new \stdClass());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }

        try {
            $this->instance->getScalar('vlvlvlv', new \stdClass());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }
    }


    public function testGetBoolean()
    {
        $this->assertFalse($this->instance->getBoolean('bla', false));
        $this->assertFalse($this->instance->getBoolean('level0.02', false));
        $this->assertFalse($this->instance->getBoolean('level0.03.object', false));
        $this->assertTrue($this->instance->getBoolean('level0.03.object', true));
        $this->assertTrue($this->instance->getBoolean('asdqyyyf', true));
        $this->assertTrue($this->instance->getBoolean('asdqyyyf', true));
        $this->assertFalse($this->instance->getBoolean('false', true));
        $this->assertTrue($this->instance->getBoolean('true', false));

        $this->assertFalse($this->instance->getBool('bla', false));
        $this->assertFalse($this->instance->getBool('level0.02', false));
        $this->assertFalse($this->instance->getBool('level0.03.object', false));
        $this->assertTrue($this->instance->getBool('level0.03.object', true));
        $this->assertTrue($this->instance->getBool('asdqyyyf', true));
        $this->assertTrue($this->instance->getBool('asdqyyyf', true));
        $this->assertFalse($this->instance->getBool('false', true));
        $this->assertTrue($this->instance->getBool('true', false));

        $this->assertFalse($this->instance->getBoolean('zeroString', true));
        $this->assertFalse($this->instance->getBoolean('zeroInt', true));
        $this->assertTrue($this->instance->getBoolean('oneString', false));
        $this->assertTrue($this->instance->getBoolean('oneInt', false));

        // non boolean default
        try {
            $this->instance->getBoolean('level0.03.object', new \stdClass());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }

        try {
            $this->instance->getBoolean('vlvlvlv', new \stdClass());
            $this->fail('No exception has been thrown.');
        } catch (\InvalidArgumentException $e) {
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->fail('Unexpected exception has been thrown.');
        }
    }

}
