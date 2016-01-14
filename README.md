Puli Bridge for the Symfony Components
======================================

[![Build Status](https://travis-ci.org/puli/symfony-bridge.png?branch=master)](https://travis-ci.org/puli/symfony-bridge)
[![Build status](https://ci.appveyor.com/api/projects/status/3ldji4vsb0e82oqa/branch/master?svg=true)](https://ci.appveyor.com/project/webmozart/symfony-bridge/branch/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/puli/symfony-bridge/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/puli/symfony-bridge/?branch=master)
[![Latest Stable Version](https://poser.pugx.org/puli/symfony-bridge/v/stable.png)](https://packagist.org/packages/puli/symfony-bridge)
[![Total Downloads](https://poser.pugx.org/puli/symfony-bridge/downloads.png)](https://packagist.org/packages/puli/symfony-bridge)
[![Dependency Status](https://www.versioneye.com/php/puli:symfony-bridge/1.0.0/badge.png)](https://www.versioneye.com/php/puli:symfony-bridge/1.0.0)

Latest release: [1.0.0-beta4](https://packagist.org/packages/puli/symfony-bridge#1.0.0-beta4)

PHP >= 5.3.9

This bridge provides a file locator for the [Symfony Config component] that 
locates configuration files using a [Puli] repository. With this locator, you
can refer from one configuration file to another via its Puli path:

```yaml
# routing.yml
_acme_demo:
    resource: /acme/demo-bundle/config/routing.yml
```

Read [Puli at a Glance] if you want to learn more about Puli.

Authors
-------

* [Bernhard Schussek] a.k.a. [@webmozart]
* [The Community Contributors]

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

[Bernhard Schussek]: http://webmozarts.com
[The Community Contributors]: https://github.com/puli/symfony-bridge/graphs/contributors
[Symfony Config component]: http://symfony.com/doc/current/components/config/introduction.html
[Puli]: http://puli.io
[Locating Config Files with Puli]: http://docs.puli.io/en/latest/extensions/symfony-bridge.html
[Puli at a Glance]: http://docs.puli.io/en/latest/index.html
[issue tracker]: https://github.com/puli/issues/issues
[Git repository]: https://github.com/puli/symfony-bridge
[@webmozart]: https://twitter.com/webmozart
[MIT license]: LICENSE
