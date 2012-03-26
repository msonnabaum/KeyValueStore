<?php
namespace KeyValueStore;

use KeyValueStore\KeyValueStore;
use KeyValueStore\Storage\MemoryStorage;

class KeyValueTest extends \PHPUnit_Framework_TestCase {
  protected $kv;

  protected function setUp() {
    $class = explode('\\', __CLASS__);
    $this->collection = end($class);
  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown() {
  }

  public function getKv($collection = NULL) {
    $collection = $collection ?: $this->collection;
    return new KeyValueStore($this->getStorage($collection), $collection);
  }

  public function getStorage($collection = NULL) {
    $collection = $collection ?: $this->collection;
    return new MemoryStorage($collection);
  }

  /**
   * @test
   */
  public function testSetGet() {
    $kv = $this->getKv();
    $kv->set("foo", "bar");
    $res = $kv->get("foo");
    $this->assertEquals('bar', $res);
  }

  /**
   * @test
   */
  public function testSetGetMultiple() {
    $values = array("foo" => "bar", "baz" => "qux");
    $kv = $this->getKv();
    $kv->setMultiple($values);
    $res = $kv->getMultiple(array("foo", "baz"));
    $this->assertEquals($values, $res);
  }

  /**
   * @test
   */
  public function testDelete() {
    $kv = $this->getKv();
    $kv->set("foo", "bar");
    $res = $kv->delete("foo");
    $this->assertEquals(TRUE, $res);

    $res = $kv->get("foo");
    $this->assertEquals(FALSE, $res);
  }

  /**
   * @test
   */
  public function testDeleteMultiple() {
    $values = array("foo" => "bar", "baz" => "qux");
    $kv = $this->getKv();
    $kv->setMultiple($values);

    $res = $kv->deleteMultiple(array_keys($values));
    $this->assertEquals(TRUE, $res);

    $res = $kv->get("foo");
    $this->assertEquals(FALSE, $res);
    $res = $kv->get("bar");
    $this->assertEquals(FALSE, $res);
  }
}
