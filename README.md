Key/Value Store Component
=========================

KeyValueStore is an abstraction layer for diverse key/value storage engines.


Examples
--------

A simple usage example:

    use KeyValueStore\KeyValueStoreFactory;

    // Define which collections are handled by which storage implementations.
    $info = array(
      'cache.boot' => 'KeyValueStore\Storage\MemcachedStorage',
      'cache' => 'KeyValueStore\Storage\RedisStorage',
      'default' => 'KeyValueStore\Storage\SqlStorage',
    );
    $factory = new KeyValueStoreFactory($info);

    // This selects 'cache', since 'cache.common' is not specified.
    $storage = $factory->get('cache.common');

    // Store something.
    $storage->set('foo', 'bar');
    // Get it back.
    $storage->get('foo');

    // Store multiple key/value pairs.
    $storage->setMultiple(array(
      'bar' => 'baz',
    ));

    // Get everything.
    $storage->getAll();


Tests
-----

To run the unit tests, install dev dependencies before running PHPUnit:

    php composer.phar install --dev

Run the unit tests with:

    phpunit

