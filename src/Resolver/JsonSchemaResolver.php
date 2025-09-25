<?php

namespace App\Resolver;

use App\Attribute\JsonSchemaValidation;
use JsonSchema\Constraints\Constraint;
use JsonSchema\Constraints\Factory;
use JsonSchema\SchemaStorage;
use JsonSchema\Validator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonSchemaResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly string $schemaBasePath = __DIR__ . '/../../resources/json-schema',
    ) {
    }

    /**
     * @return iterable<object>
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $dtoClass = $argument->getType();
        if (null === $dtoClass || !class_exists($dtoClass)) {
            return [];
        }

        // Only handle parameters marked with #[JsonSchema(...)]
        $attrs = $argument->getAttributes(JsonSchemaValidation::class, ArgumentMetadata::IS_INSTANCEOF);
        if (!$attrs) {
            return [];
        }

        /** @var JsonSchemaValidation $schemaAttr */
        $schemaAttr = $attrs[0];
        $schemaFile = $this->schemaBasePath . '/' . $schemaAttr->path;

        if (!file_exists($schemaFile)) {
            throw new BadRequestHttpException("JSON Schema not found: {$schemaFile}");
        }

        $rawJson = $request->getContent();

        $data = json_decode($rawJson, true);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('Invalid JSON payload.');
        }

        // Load the schema
        $schemaContent = file_get_contents($schemaFile);
        $schema = json_decode($schemaContent);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new BadRequestHttpException('Invalid JSON schema file.');
        }

        // Proper schema storage setup (resolves $ref)
        $schemaUri = 'file://' . realpath($schemaFile);
        $schemaStorage = new SchemaStorage();
        $schemaStorage->addSchema($schemaUri, $schema);

        $validator = new Validator(new Factory($schemaStorage));

        $validator->validate($data, $schema, Constraint::CHECK_MODE_TYPE_CAST);

        if (!$validator->isValid()) {
            $errors = array_map(
                fn ($e) => "{$e['property']}: {$e['message']}",
                $validator->getErrors()
            );
            throw new BadRequestHttpException('JSON Schema validation failed: ' . implode('; ', $errors));
        }

        $dto = $this->serializer->deserialize($rawJson, $dtoClass, JsonEncoder::FORMAT);

        yield $dto;
    }
}
