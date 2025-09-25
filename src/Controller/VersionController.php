<?php

namespace App\Controller;

use App\Enum\VersionNumberEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/versions')]
final class VersionController extends AbstractController
{
    #[Route('', name: 'app_versions_get', methods: [Request::METHOD_GET])]
    public function get(): JsonResponse
    {
        $response = [
            [
                'version' => VersionNumberEnum::V2_2_1,
                'path' => (string) $this->getParameter('app.base_url'),
            ],
        ];

        return $this->json($response);
    }
}
