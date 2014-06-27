<?php


namespace Dotor\Loader;


class ArrayLoaderTest extends \PHPUnit_Framework_TestCase
{

    private $array;

    protected function setUp()
    {
        $this->array = ['blu' => 'blah'];

        parent::setUp();
    }


    public function testGet()
    {
        $loader = new ArrayLoader();
        $loader->load($this->array);
        $this->assertEquals($this->array, $loader->get());
    }
}
