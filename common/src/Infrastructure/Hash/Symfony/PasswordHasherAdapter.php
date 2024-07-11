<?php

namespace Common\Infrastructure\Hash\Symfony;

use Common\Application\Hash\Port\PasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactory;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class PasswordHasherAdapter implements PasswordHasher
{
    /**
     * @param string $text
     * @return string
     */
    public function hash(string $text): string
    {
        return $this->getHasher()->hash($text);
    }

    /**
     * @param string $hash
     * @param string $text
     * @return bool
     */
    public function valid(string $hash, string $text): bool
    {
        return $this->getHasher()->verify($hash, $text);
    }

    /**
     * @return PasswordHasherInterface
     */
    private function getHasher(): PasswordHasherInterface
    {
        $factory = new PasswordHasherFactory([
            'common' => ['algorithm' => 'bcrypt'],
            'memory-hard' => ['algorithm' => 'sodium'],
        ]);

        // Retrieve the right password hasher by its name
        return $factory->getPasswordHasher('common');
    }
}