<?php

namespace Track\Delivery\Http\Controller;

use Common\Infrastructure\Delivery\Symfony\Http\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Uid\Uuid;
use Track\Application\Command\CreateTrackCommand;
use Track\Delivery\Http\Request\CreateTrackRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use proj4php\Proj4php;
use proj4php\Proj;
use proj4php\Point;


class ImportTrackController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/upload', name: 'upload', methods: ['POST', 'GET'], format: 'json')]
    public function __invoke(Request $request): JsonResponse
    {
        // Получаем загруженный файл
        $file = $request->files->get('demo');

        $points = [];
        if ($file && $file->isValid()) {
            $content = file_get_contents($file->getPathname());
            $xml = simplexml_load_string($content);
            foreach ($xml->trk->trkseg->trkpt as $trkpt) {
                //$points[] = [
                //    'lat' => (string) $trkpt['lat'],
                //    'lon' => (string) $trkpt['lon'],
                //    'ele' => (string) $trkpt->ele, // если elevation тоже нужна
                //    'time' => (string) $trkpt->time // если нужна метка времени
                //];

                $points[] = [
                    (float) $trkpt['lat'],
                    (float) $trkpt['lon'],
                ];
            }
        }

        $points = $this->convertWgs84ToUtm($points);

        $this->commandBus->execute(new CreateTrackCommand(
            name: 'Imported Track',
            ownerId:  $this->getIdentity()->getId()->toString(),
            accessType: 'private',
            path: $points
        ));

        return new JsonResponse([
            'ok' => date('Y-m-d H:i:s'),
        ]);
    }

    function convertWgs84ToUtm(array $wgs84Points): array
    {
        $proj4 = new Proj4php();

        // Указываем зону и систему координат UTM для твоих данных
        $wgs84 = new Proj('EPSG:4326', $proj4); // WGS84
        $utm = new Proj('EPSG:3857', $proj4); // Замените 32635 на нужный код UTM зоны

        $utmPoints = [];

        foreach ($wgs84Points as $point) {
            // Параметры точки в WGS84 (например, ['lat' => 50.48906, 'lon' => 30.36482])
            $lat = $point[0];
            $lon = $point[1];

            // Создаем точку в WGS84 и преобразуем её в UTM
            $pointSrc = new Point($lon, $lat, $wgs84);
            $pointDest = $proj4->transform($utm, $pointSrc);

            // Добавляем преобразованную точку в массив
            $utmPoints[] = [
                $pointDest->x,
                $pointDest->y
            ];
        }

        return $utmPoints;
    }
}
