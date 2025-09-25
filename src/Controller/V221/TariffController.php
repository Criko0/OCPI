<?php

namespace App\Controller\V221;

use App\Attribute\CredentialValidation;
use App\Attribute\JsonSchemaValidation;
use App\Dto\V221\tariffs\TariffDto;
use App\Entity\Credential;
use App\Entity\Tariff;
use App\Util\Constants;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\ObjectMapper\ObjectMapper;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/tariffs')]
final class TariffController extends AbstractController
{
    #[Route(
        path: Constants::PARTY_IDENTIFIER_PATH,
        name: 'tariffs_put',
        methods: [Request::METHOD_PUT],
    )]
    public function put(
        #[CredentialValidation] Credential $credential,
        #[JsonSchemaValidation('V221/ocpi.2_2_1.tariff.json')] TariffDto $tariffDto,
    ): JsonResponse {
        $mapper = new ObjectMapper(
            propertyAccessor : PropertyAccess::createPropertyAccessor(),
        );

        $product = $mapper->map($tariffDto, Tariff::class);

        dd($product);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TariffsController.php',
            'value' => $tariffDto,
            'credential' => $credential,
        ]);
    }

    #[Route(
        path: Constants::PARTY_IDENTIFIER_PATH . '/{tariffId<[ -~]{1,36}>}',
        name: 'tariffs_get',
        methods: [Request::METHOD_GET],
    )]
    public function get(
        #[CredentialValidation] Credential $credential,
        string $tariffId,
    ): JsonResponse {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/TariffsController.php',
            'credential' => $credential,
            'tariffId' => $tariffId,
        ]);
    }
}
