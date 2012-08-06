<?php
namespace KeyValueStore;

use KeyValueStore\KeyValueStore;
use KeyValueStore\Storage\FileStorage;
use KeyValueStore\KeyValueTest;

class FileStorageTest extends KeyValueTest {
  protected $kv;

  protected function setUp() {
    parent::setUp();
    $this->cwd = getcwd();
    $this->extension = "txt";
  }

  public function getStorage($collection = NULL, $options = array()) {
    $collection = $collection ?: $this->collection;
    return new FileStorage($collection, $options);
  }

  /**
   * @test
   */
  public function testFileDirectoryPathDefault() {
    $ext = $this->extension;
    $kv = $this->getStorage('foo');
    $this->assertEquals($this->cwd . DIRECTORY_SEPARATOR . 'keyvalue', $kv->getDirectoryPath());
    $this->assertEquals('foo.' . $ext, $kv->getFileName());

    $kv = $this->getStorage('foo:bar');
    $this->assertEquals($this->cwd . DIRECTORY_SEPARATOR . 'keyvalue' . DIRECTORY_SEPARATOR . 'foo', $kv->getDirectoryPath());
    $this->assertEquals('bar.' . $ext, $kv->getFileName());

    $kv = $this->getStorage('foo:bar:baz');
    $this->assertEquals($this->cwd . DIRECTORY_SEPARATOR . 'keyvalue' . DIRECTORY_SEPARATOR . 'foo' . DIRECTORY_SEPARATOR . 'bar', $kv->getDirectoryPath());
    $this->assertEquals('baz.' . $ext, $kv->getFileName());
  }

  /**
   * @test
   */
  public function testFileDirectoryPathCustom() {
    $ext = $this->extension;
    $opts = array(
      'base_directory' => sys_get_temp_dir(),
      'directory_name' => 'keyvaluefoo',
    );

    $base = $opts['base_directory'] . DIRECTORY_SEPARATOR  . $opts['directory_name'];

    $kv = $this->getStorage('foo', $opts);
    $this->assertEquals($base, $kv->getDirectoryPath());
    $this->assertEquals($kv->getFileName(), 'foo.' . $ext);

    $kv = $this->getStorage('foo:bar', $opts);
    $this->assertEquals($base . DIRECTORY_SEPARATOR . 'foo', $kv->getDirectoryPath());
    $this->assertEquals($kv->getFileName(), 'bar.' . $ext);

    $kv = $this->getStorage('foo:bar:baz', $opts);
    $this->assertEquals($base . DIRECTORY_SEPARATOR . 'foo' . DIRECTORY_SEPARATOR . 'bar', $kv->getDirectoryPath());
    $this->assertEquals('baz.' . $ext, $kv->getFileName());
  }
}

