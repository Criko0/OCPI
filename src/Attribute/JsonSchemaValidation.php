<?php

namespace App\Attribute;

/**
 * Marks a parameter to be resolved by CredentialResolver.
 *
 * @see \App\Resolver\JsonSchemaResolver
 */
#[\Attribute(\Attribute::TARGET_PARAMETER)]
final class JsonSchemaValidation
{
    public function __construct(
        public readonly string $path,
    ) {
    }
}
