<?php

/**
 * @file
 * Contains KeyValueStore\KeyValueStoreFactory.
 */

namespace KeyValueStore;

class KeyValueStoreFactory {

  /**
   * Mapping of collection names to key/value storage classes.
   *
   * An associative array whose keys are
   * - collection names: The full $collection name being passed into
   *   KeyValueStoreFactory::get().
   * - collection base names: The basename (anything up to the first dot in a
   *   $collection name).
   * - 'default': The default/fallback key.
   * which are used to determine the key/value store controller class to use for
   * a given collection name.
   *
   * For example:
   * @code
   * array(
   *   'cache.boot' => 'KeyValueStore\Storage\MemcachedStorage',
   *   'cache' => 'KeyValueStore\Storage\RedisStorage',
   *   'default' => 'KeyValueStore\Storage\SqlStorage',
   * )
   * @endcode
   *
   * @var array
   */
  protected $storageInfo;

  /**
   * Instantiated key/value stores, keyed by collection name.
   *
   * @var array
   */
  protected $instances;

  /**
   * Constructs the key/value store factory.
   *
   * @param array $storage_info
   *   An associative array declaring which storage class to use for which
   *   collection.
   */
  public function __construct(array $storage_info) {
    $this->storageInfo = $storage_info;
  }

  /**
   * Returns the key/value store for a given collection.
   *
   * @param string $collection
   *   The name of the key/value collection store instance to return.
   * @param array $options
   *   (optional) The options to pass to the key/value store. Only used on
   *   initial instantiation.
   *
   * @return KeyValueStore\Storage\StorageInterface
   *   The key/value store instance.
   */
  public function get($collection, $options = array()) {
    if (!isset($this->instances[$collection])) {
      // Anything up to the first dot treated as the collection base.
      if ($pos = strpos($collection, '.')) {
        $collection_base = substr($collection, 0, $pos);
      }
      else {
        $collection_base = $collection;
      }

      if (isset($this->storageInfo[$collection_base])) {
        $class = $this->storageInfo[$collection_base];
      }
      else {
        $class = $this->storageInfo['default'];
      }
      $this->instances[$collection] = new $class($collection, $options);
    }
    return $this->instances[$collection];
  }

}
