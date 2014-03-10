fantasy.premierleague.com API
=============================

Requires [omni-cache](https://github.com/mlntn/omni-cache)

Installation
------------

Use composer:
```javascript
{
  "require": {
    "mlntn/fpl-api": "*",
    "mlntn/omni-cache": "*"
  },
  "minimum-stability": "dev",
  "repositories": [
    {
      "type": "git",
      "url": "https://github.com/mlntn/fpl-api"
    },
    {
      "type": "git",
      "url": "https://github.com/mlntn/omni-cache"
    }
  ]
}
```

Write a controller:
```php
<?php
$autoloader = require 'vendor/autoload.php';
$api = new Fpl\Api(new Cache\Provider\File('./cache', 86400));

$player = $api->getPlayer(323);
die(json_encode($player));

// prettier with this:
// json_encode($player, JSON_PRETTY_PRINT ^ JSON_UNESCAPED_UNICODE ^ JSON_UNESCAPED_SLASHES)
```

What does all that code above do?
---------------------------------

The ``composer.json`` settings tell Composer to include this API and a caching tool I wrote called omni-cache.

The PHP controller sets up the autoloader, starts up a cache handler that caches to files for a maximum of 1 day, starts up the API class (passing in the cache handler) and grabs some player data (Artur Boruc) from fantasy.premierleague.com.

Check out Fpl\Api.php for other API methods.
