<?php

namespace App\Resolver;

use App\Attribute\CredentialValidation;
use App\Entity\Credential;
use App\Repository\CredentialRepository;
use App\Util\Constants;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Query\Parameter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class CredentialResolver implements ValueResolverInterface
{
    public function __construct(
        private CredentialRepository $credentialRepository,
    ) {
    }

    /**
     * @return iterable<Credential>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if (Credential::class !== $argument->getType()) {
            return [];
        }

        if (!$argument->getAttributes(CredentialValidation::class, ArgumentMetadata::IS_INSTANCEOF)) {
            return []; // only resolve when #[FromCredential] is used
        }

        $countryCode = $request->attributes->getString('countryCode');
        $partyId = $request->attributes->getString('partyId');
        $token = str_replace(Constants::AUTHORIZATION_TOKEN_LITERAL, '', $request->headers->get('Authorization'));

        $queryBuilder = $this->credentialRepository->createQueryBuilder('Credential');

        /** @var Credential|null $credential */
        $credential = $queryBuilder
            ->innerJoin('Credential.roles', 'CredentialRole')
            ->where(
                $queryBuilder->expr()->eq('Credential.token', ':token'),
                $queryBuilder->expr()->eq('CredentialRole.countryCode', ':countryCode'),
                $queryBuilder->expr()->eq('CredentialRole.partyId', ':partyId')
            )
            ->setParameters(new ArrayCollection([
                new Parameter('countryCode', $countryCode, Types::STRING),
                new Parameter('partyId', $partyId, Types::STRING),
                new Parameter('token', $token, Types::STRING),
            ]))
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $credential) {
            throw new UnauthorizedHttpException('Authorization', 'Invalid credentials');
        }

        yield $credential;
    }
}
