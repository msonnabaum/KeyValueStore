<?php

/**
 * @file
 * Definition of KeyValueStore.
 */

namespace KeyValueStore;

use KeyValueStore\Storage\StorageInterface;

class KeyValueStore {

  protected $storage;

  public function __construct(StorageInterface $storage, $collection) {
    $this->collection = $collection;
    $this->storage = $storage;
  }

  /**
   * Returns data from the key/value store.
   *
   * @param $key
   *   The key of the data to retrieve.
   *
   * @return
   *   The value or FALSE on failure.
   */
  function get($key) {
    return $this->storage->get($key);
  }

  /**
   * Returns data from the key/value store when given an array of keys.
   *
   * @param $keys
   *   An array of keys for the data to retrieve.
   *
   * @return
   *   An array of the items successfully returned, indexed by key.
   */
  function getMultiple($keys) {
    return $this->storage->getMultiple($keys);
  }

  /**
   * Stores data in the key/value store.
   *
   * @param $key
   *   The key of the data to store.
   * @param $value
   *   The data to store.
   */
  function set($key, $value) {
    return $this->storage->set($key, $value);
  }

  /**
   * Stores data in the key/value store.
   *
   * @param $data
   *   An array of key/value pairs.
   */
  function setMultiple($data) {
    return $this->storage->setMultiple($data);
  }

  /**
   * Deletes an item.
   *
   * @param $key
   *    The key to delete.
   */
  function delete($key) {
    return $this->storage->delete($key);
  }

  /**
   * Deletes multiple items from the key/value store.
   *
   * @param $keys
   *   An array of $keys to delete.
   */
  function deleteMultiple(array $keys) {
    return $this->storage->deleteMultiple($keys);
  }
}
