<?php

/**
 * @file
 * Definition of FileBackend.
 */

namespace KeyValueStore\Storage;

use Exception;

/**
 * Defines a file based key/value store implementation.
 */
class FileStorage implements StorageInterface {

  /**
   * @var string
   */
  protected $collection;

  public $data = array();
  public $file = NULL;
  public $options = array();
  protected $defaults = array();
  protected $file_exists = FALSE;
  protected $directory_exists = FALSE;

  /**
   * Available options:
   *
   *  * directory_name:        The name of the directory files are stored in.
   *  * base_directory:        The parent directory (defaults to cwd).
   *  * directory_permissions: Default directory permissions (defaults to 0755)
   *
   * @param $collection
   * @param array $options
   *   An associative array of session options
   */
  public function __construct($collection, array $options = array()) {
    $this->collection = $collection;

    $this->options = array_merge(array(
      'directory_name' => 'keyvalue',
      'base_directory' => getcwd(),
      'directory_permissions' => 0755,
    ), $options);

    $file = $this->getFile();
    $this->data = $this->loadFile($file);
    $this->mtime = $this->fileExists() ? filemtime($file) : NULL;
  }


  public function loadFile($file) {
    if ($this->fileExists()) {
      $content = file_get_contents($file);
      if ($content === FALSE) {
        throw new \Exception('Read file is invalid.');
      }
      else {
        return $this->decode($content);
      }
    }
  }

  public function reload($force = FALSE) {
    if ($force || ($this->mtime < filemtime($this->getFile()))) {
      $this->data = $this->loadFile($this->getFile());
    }
  }

  public function getFile() {
    if (!$this->file) {
      $this->file = $this->getDirectoryPath() . DIRECTORY_SEPARATOR . $this->getFileName();
    }
    return $this->file;
  }

  public function getFileName() {
    if ($pos = strrpos($this->collection, ':')) {
      $file = substr($this->collection, $pos + 1);
    }
    else {
      $file = $this->collection;
    }
    return "{$file}.{$this->getExtension()}";
  }

  public function getExtension() {
    return "txt";
  }

  public function fileExists() {
    if ($this->file_exists === FALSE) {
      $this->file_exists = file_exists($this->getFile());
    }
    return $this->file_exists;
  }

  public function dirExists() {
    if ($this->directory_exists === FALSE) {
      $this->directory_exists = is_dir($this->directory);
    }
    return $this->directory_exists;
  }

  /**
   * Returns the path to the file.
   *
   * @return
   *   @todo
   */
  public function getDirectoryPath() {
    $base_directory = $this->options['base_directory'] . DIRECTORY_SEPARATOR . $this->options['directory_name'];

    if (strpos($this->collection, ':') !== FALSE) {
      $path_parts = explode(':', $this->collection);
      array_pop($path_parts);
      $directory_path = implode(DIRECTORY_SEPARATOR, $path_parts);
      $this->directory = $base_directory . DIRECTORY_SEPARATOR . $directory_path;
    }
    else {
      $this->directory = $base_directory;
    }

    return $this->directory;
  }

  public function writeFile() {
    if (!$this->dirExists()) {
      mkdir($this->directory, $this->options['directory_permissions'], TRUE);
    }
    if (file_put_contents($file = $this->getFile(), $this->encode($this->data)) === FALSE) {
      throw new \Exception(sprintf('Failed to write file "%s".', $file));
    }
    else {
      return TRUE;
    }
  }

  public function encode($data) {
    return serialize($data);
  }

  public function decode($string) {
    return unserialize($string);
  }

  /**
   * Implements KeyValueStore\KeyValueStoreInterface::get().
   */
  public function get($key) {
    $this->reload();
    return isset($this->data[$key]) ? $this->data[$key] : FALSE;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::getMultiple().
   */
  public function getMultiple($keys) {
    $this->reload();

    $values = array();
    foreach ($keys as $key) {
      if (isset($this->data[$key])) {
        $values[$key] = $this->data[$key];
      }
    }
    return $values;
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::set().
   */
  public function set($key, $value) {
    $this->data[$key] = $value;
    return $this->writeFile();
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::setMultiple().
   */
  public function setMultiple($data) {
    foreach ($data as $key => $value) {
      $this->data[$key] = $value;
    }
    return $this->writeFile();
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::delete().
   */
  public function delete($key) {
    unset($this->data[$key]);
    return $this->writeFile();
  }

  /**
   * Implements KeyValueStore\Storage\StorageInterface::deleteMultiple().
   */
  public function deleteMultiple(Array $keys) {
    foreach ($keys as $key) {
      unset($this->data[$key]);
    }
    return $this->writeFile();
  }
}
