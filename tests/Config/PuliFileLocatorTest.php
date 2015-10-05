<?php

/*
 * This file is part of the puli/symfony-bridge package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\SymfonyBridge\Tests\Config;

use Puli\Repository\InMemoryRepository;
use Puli\Repository\Resource\DirectoryResource;
use Puli\Repository\Resource\LinkResource;
use Puli\Repository\Tests\Resource\TestFile;
use Puli\SymfonyBridge\Config\PuliFileLocator;
use Webmozart\PathUtil\Path;

/**
 * @since  1.0
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class PuliFileLocatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InMemoryRepository
     */
    private $repo;

    /**
     * @var PuliFileLocator
     */
    private $locator;

    protected function setUp()
    {
        $this->repo = new InMemoryRepository();
        $this->locator = new PuliFileLocator($this->repo);
    }

    public function testSupportOnlyPathsStartingWithSlash()
    {
        $this->assertTrue($this->locator->supports('/foo/bar'));
        $this->assertFalse($this->locator->supports('foo/bar'));
        $this->assertFalse($this->locator->supports('../foo/bar'));
        $this->assertFalse($this->locator->supports('@foo/bar'));
    }

    public function testAcceptAbsolutePaths()
    {
        $path = Path::normalize(__DIR__).'/Fixtures/main/routing.yml';

        $this->assertSame($path, $this->locator->locate($path));
    }

    public function testAcceptKnownPaths()
    {
        $path = Path::normalize(__DIR__).'/Fixtures/main/routing.yml';

        $this->repo->add('/webmozart/puli', new DirectoryResource(__DIR__.'/Fixtures/main'));

        $this->assertSame($path, $this->locator->locate('/webmozart/puli/routing.yml'));
    }

    public function testAcceptLinks()
    {
        $path = Path::normalize(__DIR__).'/Fixtures/main/routing.yml';

        $this->repo->add('/webmozart/puli', new DirectoryResource(__DIR__.'/Fixtures/main'));
        $this->repo->add('/routing.yml', new LinkResource('/webmozart/puli/routing.yml'));

        $this->assertSame($path, $this->locator->locate('/routing.yml'));
    }

    /**
     * @expectedException \RuntimeException
     */
    public function testAcceptRelativePaths()
    {
        // Unfortunately we receive the absolute path, not the Puli path, in
        // the second argument. For this reason, files referenced via a
        // relative path cannot be overridden.

        // The locator throws an exception in order to prevent relative paths.
        $this->locator->locate('routing.yml', __DIR__.'/Fixtures/main');
    }

    public function testReturnLastPathIfFirstIsFalse()
    {
        $overriddenPath = Path::normalize(__DIR__).'/Fixtures/override/routing.yml';

        $this->repo->add('/webmozart/puli', new DirectoryResource(__DIR__.'/Fixtures/main'));
        $this->repo->add('/webmozart/puli', new DirectoryResource(__DIR__.'/Fixtures/override'));

        $this->assertSame(array($overriddenPath), $this->locator->locate('/webmozart/puli/routing.yml', null, false));
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRejectUnknownPaths()
    {
        $this->locator->locate('/foo/bar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testRejectNonLocalPaths()
    {
        $this->repo->add('/webmozart/puli', new TestFile());

        $this->locator->locate('/webmozart/puli');
    }
}
