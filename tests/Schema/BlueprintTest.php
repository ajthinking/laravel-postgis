<?php

namespace Ajthinking\LaravelPostgis\Tests\Schema;

use Mockery;
use Ajthinking\LaravelPostgis\Schema\Blueprint;
use Ajthinking\LaravelPostgis\Tests\BaseTestCase;

class BlueprintTest extends BaseTestCase
{
    protected $blueprint;

    public function setUp(): void
    {
        parent::setUp();

        $this->blueprint = Mockery::mock(Blueprint::class)
            ->makePartial()->shouldAllowMockingProtectedMethods();
    }

    public function testMultiPoint()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('multipoint', ['col', null, 2, true]);

        $this->blueprint->multipoint('col');
    }

    public function testPolygon()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('polygon', ['col', null, 2, true]);

        $this->blueprint->polygon('col');
    }

    public function testMulltiPolygon()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('multipolygon', ['col', null, 2, true]);

        $this->blueprint->multipolygon('col');
    }

    public function testLineString()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('linestring', ['col', null, 2, true]);

        $this->blueprint->linestring('col');
    }

    public function testMultiLineString()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('multilinestring', ['col', null, 2, true]);

        $this->blueprint->multilinestring('col');
    }

    public function testGeography()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('geography', ['col', null, 2, true]);

        $this->blueprint->geography('col');
    }

    public function testGeometryCollection()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('geometrycollection', ['col', null, 2, true]);

        $this->blueprint->geometrycollection('col');
    }

    public function testEnablePostgis()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('enablePostgis', []);

        $this->blueprint->enablePostgis();
    }

    public function testEnablePostgisIfNotExists()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('enablePostgis', []);

        $this->blueprint->enablePostgisIfNotExists();
    }

    public function testDisablePostgis()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('disablePostgis', []);

        $this->blueprint->disablePostgis();
    }

    public function testDisablePostgisIfExists()
    {
        $this->blueprint
            ->shouldReceive('addCommand')
            ->with('disablePostgis', []);

        $this->blueprint->disablePostgisIfExists();
    }

    public function testGinIndex()
    {
        $this->blueprint
            ->shouldReceive('indexCommand')
            ->with('gin', 'col', 'myName');

        $this->blueprint->gin('col', 'myName');
    }
    
    public function testGistIndex()
    {
        $this->blueprint
            ->shouldReceive('indexCommand')
            ->with('gist', 'col', 'myName');

        $this->blueprint->gist('col', 'myName');
    }

    public function testCharacter()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('character', 'col', 14);

        $this->blueprint->character('col', 14);
    }

    public function testHstore()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('hstore', 'col');

        $this->blueprint->hstore('col');
    }

    public function testUuid()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('uuid', 'col');

        $this->blueprint->uuid('col');
    }

    public function testJsonb()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('jsonb', 'col');

        $this->blueprint->jsonb('col');
    }

    public function testInt4range()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('int4range', 'col');

        $this->blueprint->int4range('col');
    }

    public function testInt8range()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('int8range', 'col');

        $this->blueprint->int8range('col');
    }

    public function testNumrange()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('numrange', 'col');

        $this->blueprint->numrange('col');
    }

    public function testTsrange()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('tsrange', 'col');

        $this->blueprint->tsrange('col');
    }

    public function testTstzrange()
    {
        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('tstzrange', 'col');

        $this->blueprint->tstzrange('col');
    }	
}
