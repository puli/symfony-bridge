Puli Bridge for the Symfony Components
======================================

[![Build Status](https://travis-ci.org/puli/symfony-puli-bridge.png?branch=master)](https://travis-ci.org/puli/symfony-puli-bridge)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/puli/symfony-puli-bridge/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/211008bd-5d7f-4557-bd73-151a5bb79b2c/mini.png)](https://insight.sensiolabs.com/projects/211008bd-5d7f-4557-bd73-151a5bb79b2c)
[![Latest Stable Version](https://poser.pugx.org/puli/symfony-puli-bridge/v/stable.png)](https://packagist.org/packages/puli/symfony-puli-bridge)
[![Total Downloads](https://poser.pugx.org/puli/symfony-puli-bridge/downloads.png)](https://packagist.org/packages/puli/symfony-puli-bridge)
[![Dependency Status](https://www.versioneye.com/php/puli:symfony-puli-bridge/1.0.0/badge.png)](https://www.versioneye.com/php/puli:symfony-puli-bridge/1.0.0)

Latest release: none

PHP >= 5.3.9

This bridge provides a file locator for the [Symfony Config component] that 
locates configuration files using a [Puli] repository. With this locator, you
can refer from one configuration file to another via its Puli path:

```yaml
# routing.yml
_acme_demo:
    resource: /acme/demo-bundle/config/routing.yml
```

Installation/Documentation
--------------------------

Follow the guide [Locating Config Files with Puli] to install the locator in
your project. This guide will tell you all you need to know to use the locator.

Contribute
----------

Contributions to are very welcome!

* Report any bugs or issues you find on the [issue tracker].
* You can grab the source code at Puli’s [Git repository].

Support
-------

If you are having problems, send a mail to bschussek@gmail.com or shout out to
[@webmozart] on Twitter.

License
-------

All contents of this package are licensed under the [MIT license].

[Symfony Config component]: http://symfony.com/doc/current/components/config/introduction.html
[Puli]: https://github.com/puli/puli
[Locating Config Files with Puli]: http://puli.readthedocs.org/en/latest/extensions/symfony-config.html
[issue tracker]: https://github.com/puli/puli/issues
[Git repository]: https://github.com/puli/symfony-puli-bridge
[@webmozart]: https://twitter.com/webmozart
[MIT license]: LICENSE
