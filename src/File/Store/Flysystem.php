<?php

namespace AnyCloud\File\Store;

use Laminas\Log\LoggerAwareInterface;
use Laminas\Log\LoggerAwareTrait;
use League\Flysystem\Filesystem;
use League\Flysystem\Visibility;
use Omeka\File\Store\StoreInterface;

class Flysystem implements StoreInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    public function put($source, $storagePath)
    {
        $fh = fopen($source, 'r');
        if ($fh === false) {
            throw new \Omeka\File\Exception\RuntimeException(sprintf('Failed to open "%s"', $source));
        }

        $t0 = microtime(true);

        $config = ['visibility' => Visibility::PUBLIC];
        $this->filesystem->writeStream($storagePath, $fh, $config);
        fclose($fh);

        $elapsed = microtime(true) - $t0;
        $this->getLogger()->debug(sprintf('AnyCloud: write "%s" in %.3fs', $storagePath, $elapsed));
    }

    public function delete($storagePath)
    {
        $t0 = microtime(true);

        $this->filesystem->delete($storagePath);

        $elapsed = microtime(true) - $t0;
        $this->getLogger()->debug(sprintf('AnyCloud: delete "%s" in %.3fs', $storagePath, $elapsed));
    }

    public function getUri($storagePath)
    {
        return $this->filesystem->publicUrl($storagePath);
    }
}
