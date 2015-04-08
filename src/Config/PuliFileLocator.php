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
use Puli\Repository\Api\Resource\FilesystemResource;
use Puli\Repository\Api\ResourceNotFoundException;
use Puli\Repository\Api\ResourceRepository;
use RuntimeException;

/**
 * @since  1.0
 * @author Bernhard Schussek <bschussek@gmail.com>
 */
class PuliFileLocator implements ChainableFileLocator
{
    /**
     * @var ResourceRepository
     */
    private $repo;

    public function __construct(ResourceRepository $repo)
    {
        $this->repo = $repo;
    }

    public function supports($path)
    {
        return isset($path[0]) && '/' === $path[0];
    }

    /**
     * Returns a full path for a given Puli path.
     *
     * @param mixed   $path The Puli path to locate
     * @param string  $currentPath    The current path
     * @param boolean $first          Whether to return the first occurrence or
     *                                an array of file names
     *
     * @return string|array The full path to the file|An array of file paths
     *
     * @throws InvalidArgumentException When the path is not found
     */
    public function locate($path, $currentPath = null, $first = true)
    {
        // Accept actual file paths
        if (file_exists($path)) {
            return $path;
        }

        if (null !== $currentPath && file_exists($currentPath.'/'.$path)) {
            throw new RuntimeException(sprintf(
                'You tried to load the file "%s" using a relative path. '.
                'This functionality is not supported due to a limitation in '.
                'Symfony, because then this file cannot be overridden anymore. '.
                'Please pass the absolute Puli path instead.',
                $path
            ));
        }

        try {
            $resource = $this->repo->get($path);

            if (!$resource instanceof FilesystemResource) {
                throw new InvalidArgumentException(sprintf(
                    'The file "%s" is not a local file.',
                    $path
                ));
            }

            return $first
                ? $resource->getFilesystemPath()
                : array($resource->getFilesystemPath());
        } catch (ResourceNotFoundException $e) {
            throw new InvalidArgumentException(sprintf(
                'The file "%s" could not be found.',
                $path
            ), 0, $e);
        }
    }
}
