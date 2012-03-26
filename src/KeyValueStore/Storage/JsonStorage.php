<?php

namespace KeyValueStore\Storage;

class JsonStorage extends FileStorage {
  public function getExtension() {
    return "json";
  }

  public function encode($data) {
    return json_encode($data);
  }

  public function decode($string) {
    return json_decode($string, TRUE);
  }
}
