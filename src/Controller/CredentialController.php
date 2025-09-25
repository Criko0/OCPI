<?php

namespace App\Controller;

use App\Dto\OcpiResponseDto as AppOcpiResponseDto;
use App\Enum\StatusCodesEnum;
use App\Repository\CredentialRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/credentials')]
final class CredentialController extends AbstractController
{
    public function __construct(
        private CredentialRepository $credentialRepository,
    ) {
    }

    #[Route('', name: 'app_credentials_get', methods: [Request::METHOD_GET])]
    public function get(): JsonResponse
    {
        $credentials = $this->credentialRepository->findOneBy([
            'id' => 1, // TODO: should be oneself credentials. identify it by ID or whatever.
        ]);

        if (null === $credentials) {
            $ocpiResponseDto = new AppOcpiResponseDto(
                StatusCodesEnum::STATUS_3000->value,
                StatusCodesEnum::STATUS_3000->message()
            );
        }

        $response = [];

        return $this->json($response);
    }
}
