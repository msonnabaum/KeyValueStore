<?php
namespace KeyValueStore;

use KeyValueStore\Storage\JsonStorage;

class JsonStorageTest extends FileStorageTest {
  protected function setUp() {
    parent::setUp();
    $this->extension = "json";
  }

  public function getStorage($collection = NULL, $options = array()) {
    $collection = $collection ?: $this->collection;
    return new JsonStorage($collection, $options);
  }
}

