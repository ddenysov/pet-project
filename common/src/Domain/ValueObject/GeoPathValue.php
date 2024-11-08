<?php

namespace Common\Domain\ValueObject;

use Common\Domain\ValueObject\Port\ArrayValue;

class GeoPathValue extends ValueObject implements ArrayValue
{
    const EARTH_RADIUS = 6371.2;

    public function __construct(protected ?array $path = null)
    {
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return json_encode($this->toArray());
    }

    public function toArray(): array
    {
        return [
            'path'   => $this->path,
            'length' => $this->getLength(),
        ];
    }

    public function getPath(): array
    {
        return $this->path;
    }

    /**
     * @param string $value
     * @return static
     */
    public static function deserialize(string $value): static
    {
        $data = json_decode($value, true);

        return new static($data['path']);
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * @return float
     */
    /**
     * Вычисление общей длины маршрута, заданного массивом точек в проекции EPSG:3857.
     *
     * @param array $route Массив точек в формате [x, y].
     * @return float Общая длина маршрута в километрах, округленная до 1 десятичного знака.
     */
    public function getLength(): float
    {
        $totalDistance = 0.0;

        for ($i = 0; $i < count($this->path) - 1; $i++) {
            [$x1, $y1] = $this->path[$i];
            [$x2, $y2] = $this->path[$i + 1];

            // Преобразуем координаты из EPSG:3857 в географические координаты (широта и долгота)
            [$lat1, $lon1] = $this->convertToLatLon($x1, $y1);
            [$lat2, $lon2] = $this->convertToLatLon($x2, $y2);

            $dLat = $this->degreesToRadians($lat2 - $lat1);
            $dLon = $this->degreesToRadians($lon2 - $lon1);

            $a = sin($dLat / 2) * sin($dLat / 2) +
                cos($this->degreesToRadians($lat1)) *
                cos($this->degreesToRadians($lat2)) *
                sin($dLon / 2) * sin($dLon / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

            $totalDistance += self::EARTH_RADIUS * $c;
        }

        return round($totalDistance, 1);
    }

    /**
     * Преобразует значение в радианы.
     *
     * @param float $degrees Значение в градусах.
     * @return float Значение в радианах.
     */
    private function degreesToRadians(float $degrees): float
    {
        return $degrees * M_PI / 180.0;
    }

    /**
     * Преобразует координаты из проекции EPSG:3857 в географические координаты (широта и долгота).
     *
     * @param float $x Координата X в проекции EPSG:3857.
     * @param float $y Координата Y в проекции EPSG:3857.
     * @return array Массив с широтой и долготой [latitude, longitude].
     */
    private function convertToLatLon(float $x, float $y): array
    {
        $originShift = 2 * M_PI * 6378137 / 2.0;

        $lon = ($x / $originShift) * 180.0;
        $lat = ($y / $originShift) * 180.0;

        $latRad   = $lat * M_PI / 180.0;
        $latFinal = (180.0 / M_PI) * (2 * atan(exp($latRad)) - M_PI / 2.0);

        return [$latFinal, $lon];
    }
}