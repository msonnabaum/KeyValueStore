<?php

/**
 * @file
 * Definition of MemoryStorage.
 */

namespace KeyValueStore\Storage;

/**
 * Defines a default key/value store implementation.
 */
class MemoryStorage implements StorageInterface {

  /**
   * @var string
   */
  protected $collection;

  /**
   * Implements KeyValueStore\Storage\StorageInterface::__construct().
   */
  public function __construct($collection, array $parameters = array()) {
    $this->collection = $collection;
    $this->data = array();
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::get().
   */
  function get($key) {
    return isset($this->data[$key]) ? $this->data[$key] : FALSE;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::getMultiple().
   */
  public function getMultiple($keys) {
    $results = array();
    foreach ($keys as $key) {
      $results[$key] = $this->data[$key];
    }
    return $results;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::set().
   */
  public function set($key, $value) {
    return $this->data[$key] = $value;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::setMultiple().
   */
  public function setMultiple($data) {
    $this->data = $data + $this->data;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::delete().
   */
  public function delete($key) {
    unset($this->data[$key]);
    return TRUE;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::deleteMultiple().
   */
  public function deleteMultiple(array $keys) {
    foreach ($keys as $key) {
      unset($this->data[$key]);
    }
    return TRUE;
  }
}

