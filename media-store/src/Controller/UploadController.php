<?php

namespace App\Controller;

use Aws\S3\S3Client;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class UploadController
{
    private mixed    $bucket;
    private S3Client $s3Client;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    #[Route('/upload', name: 'upload', methods: ['POST', 'GET'], format: 'json')]
    #[CanCreateRide()]
    public function __invoke(
        Request $request
    ) {

        $demoFile = $request->files->get('demo');

        $file = $demoFile[0];
        $filePath = $file->getRealPath();
        $fileName = $file->getClientOriginalName();


        $endpoint = 'http://minio:9000';  // Твой URL для MinIO
        $accessKey = 'your-access-key';  // Твой ключ доступа
        $secretKey = 'your-secret-key';  // Твой секретный ключ
        $bucket = 'images';  // Название бакета в MinIO

        $this->bucket = $bucket;

        // Создаем экземпляр S3-клиента с настройками для MinIO
        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => 'us-east-1',  // Можно выбрать любую, так как MinIO не использует регионы так, как AWS
            'endpoint' => $endpoint,
            'use_path_style_endpoint' => true,  // Это важно для MinIO
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        $a = $result = $s3Client->listObjectsV2([
            'Bucket' => 'images',
        ]);

        $url = "http://localhost:9000/{$bucket}/$fileName";

        try {
            // Загружаем файл в MinIO
            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key' => $fileName,
                'SourceFile' => $filePath,
                'ContentType' => $file->getMimeType(), // Указываем MIME тип
            ]);


            // Возвращаем ответ с URL загруженного файла
            return new JsonResponse([
                'url' => str_ireplace('minio:9000', 'localhost:9100', $result->get('ObjectURL')),
            ]);
        } catch (\Exception $e) {
            // Обрабатываем ошибки
            dd($e->getMessage());
        }
    }
}
