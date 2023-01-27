<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Entity\GitHub;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\MetadataAwareNameConverter;
use Doctrine\Common\Annotations\AnnotationReader;

class GitHubSerializer
{
    private Serializer $serializer;

    public function __construct()
    {
        $classMetadataFactory = new ClassMetaDataFactory(
            new AnnotationLoader(new AnnotationReader())
        );
        $metadataAwareNameConverter = new MetadataAwareNameConverter($classMetadataFactory);
        $normalizer = new ObjectNormalizer($classMetadataFactory, $metadataAwareNameConverter, null, new ReflectionExtractor());
        $this->serializer = new Serializer([new DateTimeNormalizer(), $normalizer]);
    }

    public function denormalizeEntity(array $rawData): GitHub
    {
        return $this->serializer->denormalize($rawData, GitHub::class);
    }

    public function normalizeArray(GitHub $contact): array
    {
        return $this->serializer->normalize($contact);
    }
}
