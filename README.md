Locating Config Files with Puli
===============================

[![Build Status](https://travis-ci.org/puli/symfony-puli-bridge.png?branch=master)](https://travis-ci.org/puli/symfony-puli-bridge)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/badges/quality-score.png?s=f1fbf1884aed7f896c18fc237d3eed5823ac85eb)](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/)
[![Code Coverage](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/badges/coverage.png?s=5d83649f6fc3a9754297da9dc0d997be212c9145)](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/211008bd-5d7f-4557-bd73-151a5bb79b2c/mini.png)](https://insight.sensiolabs.com/projects/211008bd-5d7f-4557-bd73-151a5bb79b2c)
[![Latest Stable Version](https://poser.pugx.org/puli/symfony-puli-bridge/v/stable.png)](https://packagist.org/packages/puli/symfony-puli-bridge)
[![Total Downloads](https://poser.pugx.org/puli/symfony-puli-bridge/downloads.png)](https://packagist.org/packages/puli/symfony-puli-bridge)
[![Dependency Status](https://www.versioneye.com/php/puli:symfony-puli-bridge/1.0.0/badge.png)](https://www.versioneye.com/php/puli:symfony-puli-bridge/1.0.0)

Latest release: none

PHP >= 5.3.9

Puli provides a file locator for the [Symfony Config component] that locates
configuration files with a Puli resource locator. With this extension, you can
refer from one configuration file to another via its Puli path:

```yaml
# routing.yml
_acme_demo:
    resource: /acme/demo-bundle/config/routing.yml
```

Installation
------------

You can install the bridge with [Composer]:

```json
{
    "require": {
        "puli/symfony-puli-bridge": "~1.0@dev"
    }
}
```

Run `composer install` or `composer update` to install the library. At last,
include Composer's generated autoloader and you're ready to start:

```php
require_once __DIR__.'/vendor/autoload.php';
```

To locate configuration files with Puli, create a new [`PuliFileLocator`] and
pass it to your file loaders:

```php
use Puli\Symfony\PuliBridge\Config\PuliFileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

$loader = new YamlFileLoader(new PuliFileLocator($repo));

// Locates the file from Puli's repository
$routes = $loader->load('/acme/blog/config/routing.yml');
```

You need to pass Puli's resource repository to the constructor of the
[`PuliFileLocator`]. If you don't know how to create that repository, you can 
find more information in Puli's [main documentation].

Chained Locators
----------------

If you want to use the [`PuliFileLocator`] and Symfony's conventional
`FileLocator` side by side, you can use them both by wrapping them into a
[`FileLocatorChain`]:

```php
use Puli\Symfony\PuliBridge\Config\PuliFileLocator;
use Puli\Symfony\PuliBridge\Config\FileLocatorChain;
use Puli\Symfony\PuliBridge\Config\ChainableFileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;

$locatorChain = new FileLocatorChain(array(
    new PuliFileLocator($repo),
    // Symfony's FileLocator expects a list of paths
    new ChainableFileLocator(array(__DIR__)),
));

$loader = new YamlFileLoader($locatorChain);

// Loads the file from __DIR__/config/routing.yml
$routes = $loader->load('config/routing.yml');
```

[`ChainableFileLocator`] is a simple extension of Symfony's `FileLocator` that
supports the interface required by the locator chain. Note that this locator
must come *after* the [`PuliFileLocator`] in the chain.

Puli also provides a chainable version of the file locator bundled with the
[Symfony HttpKernel component]: [`ChainableKernelFileLocator`]. Use that
locator if you want to load configuration files from Symfony bundles:

```php
use Puli\Symfony\PuliBridge\Config\PuliFileLocator;
use Puli\Symfony\PuliBridge\Config\FileLocatorChain;
use Puli\Symfony\PuliBridge\Config\ChainableFileLocator;
use Puli\Symfony\PuliBridge\HttpKernel\ChainableKernelFileLocator;

$locatorChain = new FileLocatorChain(array(
    new PuliFileLocator($repo),
    new ChainableKernelFileLocator($httpKernel),
    new ChainableFileLocator(array(__DIR__)),
));

$loader = new YamlUserLoader($locatorChain);

// Loads the file from AcmeBlogBundle
$routes = $loader->load('@AcmeBlogBundle/Resources/config/routing.yml');
```

Take care again that the [`ChainableFileLocator`] comes last in the chain.

Limitations
-----------

Due to limitations with Symfony's `FileLocatorInterface`, relative file
references are not properly supported. Let's load some routes for example:

```php
$routes = $loader->load('/acme/blog/config/routing-dev.yml');
```

Consider that this file contains the following import:

```yaml
# routing-dev.yml
_main:
    resource: routing.yml
```

What happens if we override this file in the Puli repository?

```php
// Load files from /path/to/blog
$repo->add('/acme/blog', '/path/to/blog');

// Override just routing.yml with a custom file
$repo->add('/acme/blog/config/routing.yml', '/path/to/routing.yml');

// Load the routes
$routes = $loader->load('/acme/blog/config/routing-dev.yml');

// Expected: Routes loaded from
//  - /path/to/blog/config/routing-dev.yml
//  - /path/to/routing.yml

// Actual: Routes loaded from
//  - /path/to/blog/config/routing-dev.yml
//  - /path/to/blog/config/routing.yml
```

This is a limitation in Symfony and cannot be worked around. For this
reason, [`PuliFileLocator`] does not support relative file paths.

[Composer]: https://getcomposer.org
[Symfony Config component]: http://symfony.com/doc/current/components/config/introduction.html
[Symfony HttpKernel component]: http://symfony.com/doc/current/components/http_kernel/introduction.html
[main documentation]: https://github.com/puli/puli/blob/master/README.md
[`PuliFileLocator`]: src/Config/PuliFileLocator.php
[`FileLocatorChain`]: src/Config/FileLocatorChain.php
[`ChainableFileLocator`]: src/Config/ChainableFileLocator.php
[`ChainableKernelFileLocator`]: src/HttpKernel/ChainableKernelFileLocator.php
