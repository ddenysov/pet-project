<?php
declare(strict_types=1);

namespace Zinc\Core\Kernel;

class KernelConfig
{
    private string $baseDir;

    /**
     * @throws \Exception
     */
    public function __construct(array $dirs)
    {
        if (!isset($dirs['base_dir'])) {
            throw new \Exception('Base dir not provided');
        }

        $this->baseDir = $dirs['base_dir'];
    }

    public function getBaseDir(): string
    {
        return $this->baseDir;
    }
}