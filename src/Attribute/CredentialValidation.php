<?php

namespace App\Attribute;

/**
 * Marks a parameter to be resolved by CredentialResolver.
 *
 * @see \App\Resolver\CredentialResolver
 */
#[\Attribute(\Attribute::TARGET_PARAMETER)]
final class CredentialValidation
{
}
