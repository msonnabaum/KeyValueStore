<?php

/**
 * @file
 * Definition of StorageInterface.
 */

namespace KeyValueStore\Storage;

/**
 * Defines an interface for key/value implementations.
 *
 */
interface StorageInterface {
  /**
   * Constructs a new key/value collection.
   *
   * @param $collection
   *   The collection for which the object is created.
   * @param $options
   */
  function __construct($collection, array $options);

  /**
   * Returns data from the key/value store.
   *
   * @param $key
   *   The key of the data to retrieve.
   *
   * @return
   *   The value or FALSE on failure.
   */
  function get($key);

  /**
   * Returns data from the key/value store when given an array of keys.
   *
   * @param $keys
   *   An array of keys for the data to retrieve.
   *
   * @return
   *   An array of the items successfully returned, indexed by key.
   */
  function getMultiple($keys);

  /**
   * Stores data in the key/value store.
   *
   * @param $key
   *   The key of the data to store.
   * @param $value
   *   The data to store.
   */
  function set($key, $value);

  /**
   * Stores data in the key/value store.
   *
   * @param $data
   *   An array of key/value pairs.
   */
  function setMultiple($data);

  /**
   * Deletes an item.
   *
   * @param $key
   *    The key to delete.
   */
  function delete($key);

  /**
   * Deletes multiple items from the key/value store.
   *
   * @param $keys
   *   An array of $keys to delete.
   */
  function deleteMultiple(Array $keys);
}
