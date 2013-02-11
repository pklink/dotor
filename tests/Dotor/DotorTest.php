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
                    'object' => new \stdClass()
                ],
            ],
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
    }


    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWithArray()
    {
        $this->instance->get(array());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testExceptionWithObject()
    {
        $this->instance->get(new \stdClass());
    }

}
