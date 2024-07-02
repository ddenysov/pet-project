<?php

namespace App\Controller;

use App\Client\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class IndexController extends AbstractController
{
    public function __construct(private Client $client)
    {
    }

    #[Route('/index', name: 'app_index')]
    public function index(): JsonResponse
    {
        $result = $this->client->get();
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/IndexController.php',
        ]);
    }
}
