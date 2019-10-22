<?php

namespace Meero\Serializer\Normalizer;

use Meero\Entity\Area;
use Meero\Service\AreaService;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

class AreaNormalizer implements ContextAwareNormalizerInterface
{
    public function supportsNormalization($data, $format = null, array $context = [])
    {
        if (false === $data instanceof Area) {
            return false;
        }

        if (AreaService::FORMAT_JSON !== $format) {
            return false;
        }

        return true;
    }

    public function normalize($object, $format = null, array $context = [])
    {
        $polygon = [];
        /*foreach ($object->getPolygon() as $key => $value) {
            $polygon[$key] = ['lat' => $value[0], 'lng' => $value[1]];
        }*/
        $data = [
            'uuid' => $object->getId(),
            'polygon' => $object->getPolygon(),
            'created_at' => $object->getCreatedAt()->format('Y-m-d H:i:sP'),
            'updated_at' => $object->getUpdatedAt()->format('Y-m-d H:i:sP'),
        ];

        return $data;
    }
}
