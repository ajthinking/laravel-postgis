<?php

namespace Ajthinking\LaravelPostgis\Tests\Geometries;

use Ajthinking\LaravelPostgis\Geometries\LineString;
use Ajthinking\LaravelPostgis\Geometries\MultiLineString;
use Ajthinking\LaravelPostgis\Geometries\Point;
use Ajthinking\LaravelPostgis\Tests\BaseTestCase;

class MultiLineStringTest extends BaseTestCase
{
    public function testFromGeoJSON()
    {
        $geojson = new \GeoJson\Geometry\MultiLineString([[[1, 1], [2, 2], [2, 3]], [[3, 4], [4, 3], [6, 5]]]);

        $multilinestring = MultiLineString::fromGeoJSON($geojson);

        $this->assertInstanceOf(MultiLineString::class, $multilinestring);
        $this->assertEquals(2, $multilinestring->count());
        $this->assertEquals($geojson, $multilinestring->toGeoJSON());
    }

    public function testFromGeoJSON3d()
    {
        $geojson = new \GeoJson\Geometry\MultiLineString([[[1, 1, 1], [2, 2, 2], [2, 3, 4]], [[3, 4, 5], [4, 3, 2], [6, 5, 4]]]);

        $multilinestring = MultiLineString::fromGeoJSON($geojson);

        $this->assertInstanceOf(MultiLineString::class, $multilinestring);
        $this->assertEquals(2, $multilinestring->count());
        $this->assertEquals($geojson, $multilinestring->toGeoJSON());
    }

    public function testFromWKT()
    {
        $multilinestring = MultiLineString::fromWKT('MULTILINESTRING((1 1,2 2,2 3),(3 4,4 3,6 5))');
        $this->assertInstanceOf(MultiLineString::class, $multilinestring);

        $this->assertSame(2, $multilinestring->count());
    }

    public function testFromWKT3d()
    {
        $multilinestring = MultiLineString::fromWKT('MULTILINESTRING Z((1 1 1,2 2 2,2 3 4),(3 4 5,4 3 2,6 5 4))');
        $this->assertInstanceOf(MultiLineString::class, $multilinestring);

        $this->assertSame(2, $multilinestring->count());
    }

    public function testToWKT()
    {
        $collection = new LineString(
            [
                new Point(1, 1),
                new Point(1, 2),
                new Point(2, 2),
                new Point(2, 1),
                new Point(1, 1)
            ]
        );

        $multilinestring = new MultiLineString([$collection]);

        $this->assertSame('MULTILINESTRING((1 1,2 1,2 2,1 2,1 1))', $multilinestring->toWKT());
    }

    public function testToWKT3d()
    {
        $collection = new LineString(
            [
                new Point(1, 1, 1),
                new Point(1, 2, 3),
                new Point(2, 2, 2),
                new Point(2, 1, 3),
                new Point(1, 1, 1)
            ]
        );

        $multilinestring = new MultiLineString([$collection]);

        $this->assertSame('MULTILINESTRING Z((1 1 1,2 1 3,2 2 2,1 2 3,1 1 1))', $multilinestring->toWKT());
    }

    public function testJsonSerialize()
    {
        $multilinestring = MultiLineString::fromWKT('MULTILINESTRING Z((1 1 1,2 2 2,2 3 4),(3 4 5,4 3 2,6 5 4))');

        $this->assertInstanceOf(\GeoJson\Geometry\MultiLineString::class, $multilinestring->jsonSerialize());
        $this->assertSame(
            '{"type":"MultiLineString","coordinates":[[[1,1,1],[2,2,2],[2,3,4]],[[3,4,5],[4,3,2],[6,5,4]]]}',
            json_encode($multilinestring)
        );
    }
}
