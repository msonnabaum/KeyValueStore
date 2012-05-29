<?php

/**
 * @file
 * Definition of RedisStorage.
 */

namespace KeyValueStore\Storage;

/**
 * Defines a default key/value store implementation.
 */
class RedisStorage implements StorageInterface {

  /**
   * @var string
   */
  protected $collection;

  /**
   * Implements KeyValueStore\Storage\StorageInterface::__construct().
   */
  public function __construct($collection, $options) {
    $this->collection = $collection;
    $this->redis = new \Redis();
    // TODO: get this from $options.
    $this->redis->connect('127.0.0.1', 6379);
    $this->redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::get().
   */
  function get($key) {
    return $this->redis->hget($this->collection, $key);
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::getMultiple().
   */
  public function getMultiple($keys) {
    $this->redis->hget($this->collection, $key);
    $results = $this->prepareKeys(array($key));
    return $results;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::set().
   */
  public function set($key, $value) {
    return $this->redis->hset($this->collection, $key, $value);
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::setMultiple().
   */
  public function setMultiple($data) {
    return $this->redis->hmset($this->collection, $key, $value);
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::delete().
   */
  public function delete($key) {
    return $this->redis->hdel($this->collection, $key);
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::deleteMultiple().
   */
  public function deleteMultiple(Array $keys) {
    $redis->multi(\Redis::PIPELINE);
    foreach ($keys as $key) {
      $this->redis->hdel($this->collection, $key);
    }
    return $redis->exec();
  }
}
