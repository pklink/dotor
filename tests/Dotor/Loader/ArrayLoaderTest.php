<?php


namespace Dotor\Loader;


use Dotor\Loader\Exception\FileIsNotReadableException;
use Dotor\Loader\Exception\FileNotReturnAnArrayException;

class ArrayLoaderTest extends \PHPUnit_Framework_TestCase
{

    private $array;

    protected function setUp()
    {
        $this->array = ['blu' => 'blah'];

        parent::setUp();
    }

    public function testCreate()
    {
        $loader = ArrayLoader::create($this->array);
        $this->assertEquals($this->array, $loader->get());
    }

    public function testCreateFromFile()
    {
        $path   = __DIR__ . '/config-valid.php';
        $loader = ArrayLoader::createFromFile($path);
        $this->assertEquals($this->array, $loader->get());
    }

    public function testGet()
    {
        $loader = new ArrayLoader();
        $loader->load($this->array);
        $this->assertEquals($this->array, $loader->get());
    }

    public function testLoadFromFile()
    {
        $path = __DIR__ . '/config-valid.php';

        // valid
        $loader = new ArrayLoader();
        $loader->loadFromFile($path);
        $this->assertEquals($this->array, $loader->get());

        // file not exist
        try {
            $loader->loadFromFile('notexist.php');
            $this->fail();
        } catch (FileIsNotReadableException $e) {
            $this->assertTrue(true);
        }

        // invalid config
        try {
            $path = __DIR__ . '/config-invalid.php';
            $loader->loadFromFile($path);
            $this->fail();
        } catch (FileNotReturnAnArrayException $e) {
            $this->assertTrue(true);
        }
    }
}
