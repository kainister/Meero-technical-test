<?php

namespace Meero\Tests\Unit\Serializer\Normalizer;

use Meero\Entity\Area;
use Meero\Serializer\Normalizer\AreaDenormalizer;
use Meero\Service\AreaService;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class AreaDenormalizerTest extends TestCase
{
    public function testSupportsDenormalization()
    {
        // define json data
        $data = '{"polygon":[{"lat":48.846658,"lng":2.3808096000000205},{"lat":48.84967,"lng":2.380809799999952},{"lat":48.848135781907885,"lng":2.3850154037353377},{"lat":48.84482688455016,"lng":2.3855303378661574}]}';

        $type = Area::class;
        $format = AreaService::FORMAT_JSON;
        $denormalizer = new AreaDenormalizer();
        $result = $denormalizer->supportsDenormalization($data, $type, $format);

        // the json is able to be denormalized
        $this->assertTrue($result);
    }

    public function testSupportsDenormalizationWithBadFormat()
    {
        // define json data
        $data = '{"polygon":[{"lat":48.846658,"lng":2.3808096000000205},{"lat":48.84967,"lng":2.380809799999952},{"lat":48.848135781907885,"lng":2.3850154037353377},{"lat":48.84482688455016,"lng":2.3855303378661574}]}';

        $type = Area::class;
        $denormalizer = new AreaDenormalizer();
        $result = $denormalizer->supportsDenormalization($data, $type, 'xml');

        // the json was not able to be denormalized
        $this->assertFalse($result);
    }

    public function testSupportsDenormalizationWithoutPolygon()
    {
        // define json data
        $data = '{}';

        $type = Area::class;
        $format = AreaService::FORMAT_JSON;
        $denormalizer = new AreaDenormalizer();
        $result = $denormalizer->supportsDenormalization($data, $type, $format);

        // the json was not able to be denormalized
        $this->assertFalse($result);
    }

    public function testDenormalize()
    {
        // define json data
        $data = '{"uuid":"1234567890","polygon":[{"lat":48.846658,"lng":2.3808096000000205},{"lat":48.84967,"lng":2.380809799999952},{"lat":48.848135781907885,"lng":2.3850154037353377},{"lat":48.84482688455016,"lng":2.3855303378661574}],"created_at":"111111","updated_at":"111111"}';

        $type = Area::class;
        $format = AreaService::FORMAT_JSON;
        $denormalizer = new AreaDenormalizer();
        $result = $denormalizer->denormalize($data, $type, $format);

        // the result should to be an Area entity
        $this->assertInstanceOf(Area::class, $result);
        // input and ouptut data should to be equals
        $this->assertEquals('1234567890', $result->getId());
        $this->assertEquals('1970-01-02 06:51:51+00:00', $result->getCreatedAt()->format('Y-m-d H:i:sP'));
        $this->assertEquals('1970-01-02 06:51:51+00:00', $result->getUpdatedAt()->format('Y-m-d H:i:sP'));
    }
}
