<?php

namespace Meero\Tests\Unit\Serializer\Normalizer;

use Meero\Entity\Area;
use Meero\Serializer\Normalizer\AreaNormalizer;
use Meero\Service\AreaService;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AreaNormalizerTest extends TestCase
{
    public function testSupportsNormalization()
    {
        $data = new Area();
        $format = AreaService::FORMAT_JSON;

        $normalizer = new AreaNormalizer();
        $result = $normalizer->supportsNormalization($data, $format);
        $this->assertTrue($result);
    }

    public function testSupportsNormalizationWithBadFormat()
    {
        $data = new Area();
        $normalizer = new AreaNormalizer();
        $result = $normalizer->supportsNormalization($data, 'xml');
        $this->assertFalse($result);
    }

    public function testNormalize()
    {
        $data = new Area();
        $uuid = Uuid::uuid4()->toString();
        $data->setId($uuid);
        $data->setPolygon([
            ['lat' => -10, 'lng' => 10],
            ['lat' => 10, 'lng' => 10],
        ]);
        $date = new \DateTime();
        $data->setCreatedAt($date);
        $data->setUpdatedAt($date);
        $format = AreaService::FORMAT_JSON;

        $normalizer = new AreaNormalizer();
        $result = $normalizer->normalize($data, $format);

        $array = ['uuid' => $uuid, 'polygon' => [['lat' => -10, 'lng' => 10], ['lat' => 10, 'lng' => 10]], 'created_at' => $date->format('Y-m-d H:i:sP'), 'updated_at' => $date->format('Y-m-d H:i:sP')];

        $this->assertEquals($array, $result);
    }
}
