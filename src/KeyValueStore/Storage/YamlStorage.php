<?php

/**
 * @file
 * Contains KeyValueStore\Storage\YamlStorage.
 */

namespace KeyValueStore\Storage;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Dumper;

class YamlStorage extends FileStorage {

  protected $parser;
  protected $dumper;

  /**
   * Implements KeyValueStore\Storage\StorageInterface::__construct().
   */
  public function __construct($collection, array $options) {
    $this->parser = new Parser();
    $this->dumper = new Dumper();
    parent::__construct($collection, $options);
  }

  public function getExtension() {
    return "yml";
  }

  public function encode($data) {
    return $this->dumper->dump($data);
  }

  public function decode($string) {
    return $this->parser->parse($string);
  }
}

