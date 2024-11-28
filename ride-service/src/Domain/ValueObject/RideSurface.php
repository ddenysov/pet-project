<?php

namespace Ride\Domain\ValueObject;

final class RideSurface
{
    private int $dirtPercentage;
    private int $asphaltPercentage;

    private function __construct(int $dirtPercentage, int $asphaltPercentage)
    {
        if ($dirtPercentage + $asphaltPercentage !== 100) {
            throw new \InvalidArgumentException('The sum of dirt and asphalt percentages must be 100.');
        }

        if ($dirtPercentage < 0 || $dirtPercentage > 100 || $asphaltPercentage < 0 || $asphaltPercentage > 100) {
            throw new \InvalidArgumentException('Percentages must be between 0 and 100.');
        }

        $this->dirtPercentage = $dirtPercentage;
        $this->asphaltPercentage = $asphaltPercentage;
    }

    public static function fromPercentages(int $dirtPercentage, int $asphaltPercentage): self
    {
        return new self($dirtPercentage, $asphaltPercentage);
    }

    public function getDirtPercentage(): int
    {
        return $this->dirtPercentage;
    }

    public function getAsphaltPercentage(): int
    {
        return $this->asphaltPercentage;
    }

    public function toString(): string
    {
        return sprintf('%d%% dirt, %d%% asphalt', $this->dirtPercentage, $this->asphaltPercentage);
    }

    public function equals(RideSurface $other): bool
    {
        return $this->dirtPercentage === $other->dirtPercentage &&
            $this->asphaltPercentage === $other->asphaltPercentage;
    }
}