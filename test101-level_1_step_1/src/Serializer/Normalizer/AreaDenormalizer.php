<?php

namespace Meero\Serializer\Normalizer;

use Meero\Entity\Area;
use Meero\Service\AreaService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ContextAwareDenormalizerInterface;

class AreaDenormalizer implements ContextAwareDenormalizerInterface
{
    public function supportsDenormalization($data, $type, $format = null, array $context = [])
    {
        if (Area::class !== $type) {
            return false;
        }

        if (AreaService::FORMAT_JSON !== $format) {
            return false;
        }

        try {
            $encoder = new JsonEncoder();
            $json = $encoder->decode($data, $format);
        } catch (\Exception $exception) {
            return false;
        }

        if (!isset($json['polygon'])) {
            return false;
        }

        foreach ($json['polygon'] as $key => $value) {
            if (is_float($value["lat"]) !== true || is_float($value["lng"]) !== true) {
                return false;
            }
        }

        return true;
    }

    public function denormalize($data, $type, $format = null, array $context = [])
    {
        $encoder = new JsonEncoder();
        $json = $encoder->decode($data, $format);

        $object = new Area();

        if (isset($json['uuid'])) {
            $object->setId($json['uuid']);
        }

        if (isset($json['polygon'])) {
            $data = [];
            foreach ($json['polygon'] as $key => $value) {
                array_push($data, [$value['lat'], $value['lng']]);
            }
            $object->setPolygon($data);
        }

        if (isset($json['created_at'])) {
            $object->setCreatedAt(new \DateTime('@'.$json['created_at']));
        }
        if (isset($json['updated_at'])) {
            $object->setUpdatedAt(new \DateTime('@'.$json['updated_at']));
        }

        return $object;
    }
}
