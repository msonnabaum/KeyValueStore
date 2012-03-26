<?php
namespace KeyValueStore;

use KeyValueStore\Storage\YamlStorage;

class YamlStorageTest extends FileStorageTest {
  protected function setUp() {
    parent::setUp();
    $this->extension = "yml";
  }

  public function getStorage($collection = NULL, $options = array()) {
    $collection = $collection ?: $this->collection;
    return new YamlStorage($collection, $options);
  }
}

