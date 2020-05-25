<?php

declare(strict_types=1);

namespace App\Swagger;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Class SwaggerDecorator
 * @package App\Swagger
 */
final class SwaggerDecorator implements NormalizerInterface
{
    /** @var NormalizerInterface $decorated */
    private $decorated;

    /**
     * SwaggerDecorator constructor.
     * @param NormalizerInterface $decorated
     */
    public function __construct(NormalizerInterface $decorated)
    {
        $this->decorated=$decorated;
    }

    /**
     * @param mixed $data
     * @param null $format
     * @return bool
     */
    public function supportsNormalization($data, $format = null): bool
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    /**
     * @param mixed $object
     * @param null $format
     * @param array $context
     * @return array|\ArrayObject|bool|float|int|string|null
     * @throws ExceptionInterface
     */
    public function normalize($object, $format = null, array $context=[])
    {
        $docs=$this->decorated->normalize($object, $format, $context);

        $docs['components']['schemas']['Token'] = [
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
            ],
        ];

        $docs['components']['schemas']['Credentials']=[
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'api',
                ],
                'password' => [
                    'type' => 'string',
                    'example' => 'api',
                ],
            ],
        ];

        $tokenDocumentation=[
            'paths' => [
                '/api/login' => [
                    'post'=>[
                        'tags' => ['Token'],
                        'operationId' => 'postCredentialsItem',
                        'summary' => 'Get JWT token to login.',
                        'requestBody' => [
                            'description'=>'Create new JWT Token',
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        '$ref'=>'#/components/schemas/Credentials',
                                    ],
                                ],
                            ],
                        ],
                        'responses' => [
                            Response::HTTP_OK => [
                                'description'=>'Get JWT token',
                                'content'=>[
                                    'application/json' => [
                                        'schemspa'=>[
                                            '$ref'=>'#/components/schemas/Token',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return array_merge_recursive($docs, $tokenDocumentation);
    }
}