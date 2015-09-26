<?php

/*
 * This file is part of the puli/symfony-bridge package.
 *
 * (c) Bernhard Schussek <bschussek@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Puli\SymfonyBridge\Config;

use InvalidArgumentException;
use Symfony\Component\Config\FileLocatorInterface;

/**
 * @since  1.0
 *
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class FileLocatorChain implements FileLocatorInterface
{
    /**
     * @var ChainableFileLocator[]
     */
    private $locators = array();

    public function __construct(array $locators = array())
    {
        foreach ($locators as $locator) {
            $this->addLocator($locator);
        }
    }

    public function addLocator(ChainableFileLocator $locator)
    {
        $this->locators[] = $locator;
    }

    /**
     * Returns a full path for a given file name.
     *
     * @param mixed  $name        The file name to locate
     * @param string $currentPath The current path
     * @param bool   $first       Whether to return the first occurrence or an array of filenames
     *
     * @return string|array The full path to the file|An array of file paths
     *
     * @throws InvalidArgumentException When file is not found
     */
    public function locate($name, $currentPath = null, $first = true)
    {
        foreach ($this->locators as $locator) {
            if ($locator->supports($name)) {
                return $locator->locate($name, $currentPath, $first);
            }
        }

        throw new InvalidArgumentException(sprintf(
            'The file "%s" could not be found.',
            $name
        ));
    }
}
