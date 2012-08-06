<?php

/**
 * @file
 * Contains KeyValueStore\Storage\StorageInterface.
 */

namespace KeyValueStore\Storage;

/**
 * Defines the interface for key/value store implementations.
 */
interface StorageInterface {
  /**
   * Constructs a new key/value collection.
   *
   * @param string $collection
   *   The collection for which the object is created.
   * @param array $options
   *   An associative array of options for the key/value storage collection.
   */
  public function __construct($collection, array $options);

  /**
   * Returns the name of this collection.
   *
   * @return string
   *   The name of this collection.
   */
  public function getCollectionName();

  /**
   * Returns the stored value for a given key.
   *
   * @param $key
   *   The key of the data to retrieve.
   *
   * @return mixed
   *   The stored value, or FALSE if no value exists.
   */
  public function get($key);

  /**
   * Returns the stored key/value pairs for a given set of keys.
   *
   * @param array $keys
   *   A list of keys to retrieve.
   *
   * @return array
   *   An associative array of items successfully returned, indexed by key.
   *   @todo What's returned for non-existing keys?
   */
  public function getMultiple(array $keys);

  /**
   * Returns all stored key/value pairs in the collection.
   *
   * @return array
   *   An associative array containing all stored items in the collection.
   */
  public function getAll();

  /**
   * Saves a value for a given key.
   *
   * @param string $key
   *   The key of the data to store.
   * @param mixed $value
   *   The data to store.
   */
  public function set($key, $value);

  /**
   * Saves key/value pairs.
   *
   * @param array $data
   *   An associative array of key/value pairs.
   */
  public function setMultiple(array $data);

  /**
   * Deletes an item from the key/value store.
   *
   * @param string $key
   *   The item name to delete.
   */
  public function delete($key);

  /**
   * Deletes multiple items from the key/value store.
   *
   * @param array $keys
   *   A list of item names to delete.
   */
  public function deleteMultiple(array $keys);

}
