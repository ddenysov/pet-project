<?php

namespace App\Controller;

use Aws\S3\S3Client;
use Exception;
use Ride\Application\Handlers\Command\CreateRideCommand;
use Ride\Delivery\Http\Request\Dto\CreateRideRequest;
use Ride\Delivery\Http\Security\CanCreateRide;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Temporary dirty code. Dont look :)
 */
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
    )
    {
        $demoFile = $request->files->get('demo');
        $file     = $demoFile[0];
        $fileName = md5(time()) .  '_' .$file->getClientOriginalName();

        // Сохраняем файл во временную директорию
        $tempDir      = sys_get_temp_dir();
        $tempFilePath = $tempDir . '/' . uniqid() . '_' . $file->getClientOriginalName();
        $file->move($tempDir, basename($tempFilePath));

        $endpoint  = 'http://minio:9000';  // Твой URL для MinIO
        $accessKey = 'your-access-key';    // Твой ключ доступа
        $secretKey = 'your-secret-key';    // Твой секретный ключ
        $bucket    = 'images';             // Название бакета в MinIO

        $this->bucket = $bucket;

        // Создаем экземпляр S3-клиента с настройками для MinIO
        $s3Client = new S3Client([
            'version'                 => 'latest',
            'region'                  => 'us-east-1',  // Можно выбрать любую, так как MinIO не использует регионы так, как AWS
            'endpoint'                => $endpoint,
            'use_path_style_endpoint' => true,  // Это важно для MinIO
            'credentials'             => [
                'key'    => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        try {
            // Создаем уменьшенные версии изображения
            $resizedFilePath1 = sys_get_temp_dir() . '/' . '1200_' . $fileName;
            $resizedFilePath2 = sys_get_temp_dir() . '/' . '300_' . $fileName;
            $this->resizeImage($tempFilePath, $resizedFilePath1, $resizedFilePath2);

            $result = $s3Client->putObject([
                'Bucket'      => $bucket,
                'Key'         => $fileName,
                'SourceFile'  => $resizedFilePath1,
                'ContentType' => mime_content_type($resizedFilePath1),
            ]);

            $s3Client->putObject([
                'Bucket'      => $bucket,
                'Key'         => 'preview_' . $fileName,
                'SourceFile'  => $resizedFilePath2,
                'ContentType' => mime_content_type($resizedFilePath2),
            ]);

            // Возвращаем ответ с URL загруженных файлов
            return new JsonResponse([
                'url' => str_ireplace('minio:9000', 'localhost:9100', $result->get('ObjectURL')),
            ]);
        } catch (\Exception $e) {
            // Обрабатываем ошибки
            dump($e->getMessage());
            dd($e->getTrace());
        }
    }

    /**
     * @throws Exception
     */
    private function resizeImage($sourcePath, $outputPath1, $outputPath2): void
    {
        // Загружаем изображение
        [$originalWidth, $originalHeight, $type] = \getimagesize($sourcePath);
        if ($originalWidth < 1200) {
            throw new Exception("Ширина изображения должна быть не менее 1200 пикселей.");
        }

        switch ($type) {
            case IMAGETYPE_JPEG:
                $sourceImage = \imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $sourceImage = \imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $sourceImage = \imagecreatefromgif($sourcePath);
                break;
            default:
                throw new Exception("Неподдерживаемый тип изображения.");
        }

        // Создание изображения с шириной 1200 пикселей
        $newWidth1     = 1200;
        $newHeight1    = (int) (($originalHeight / $originalWidth) * $newWidth1);
        $resizedImage1 = \imagecreatetruecolor($newWidth1, $newHeight1);
        \imagecopyresampled($resizedImage1, $sourceImage, 0, 0, 0, 0, $newWidth1, $newHeight1, $originalWidth, $originalHeight);
        \imagejpeg($resizedImage1, $outputPath1);

        // Создание изображения с высотой 300 пикселей
        $newHeight2    = 300;
        $newWidth2     = (int) (($originalWidth / $originalHeight) * $newHeight2);
        $resizedImage2 = \imagecreatetruecolor($newWidth2, $newHeight2);
        \imagecopyresampled($resizedImage2, $sourceImage, 0, 0, 0, 0, $newWidth2, $newHeight2, $originalWidth, $originalHeight);
        \imagejpeg($resizedImage2, $outputPath2);

        // Очистка памяти
        \imagedestroy($sourceImage);
        \imagedestroy($resizedImage1);
        \imagedestroy($resizedImage2);
    }
}
