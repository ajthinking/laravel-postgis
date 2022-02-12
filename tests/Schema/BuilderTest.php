<?php

namespace Ajthinking\LaravelPostgis\Tests\Schema;

use Mockery;
use Ajthinking\LaravelPostgis\PostgisConnection;
use Ajthinking\LaravelPostgis\Schema\Blueprint;
use Ajthinking\LaravelPostgis\Schema\Builder;
use Ajthinking\LaravelPostgis\Tests\BaseTestCase;

class BuilderTest extends BaseTestCase
{
    public function testReturnsCorrectBlueprint()
    {
        $connection = Mockery::mock(PostgisConnection::class);
        $connection->shouldReceive('getSchemaGrammar')->once()->andReturn(null);

        $mock = Mockery::mock(Builder::class, [$connection]);
        $mock->makePartial()->shouldAllowMockingProtectedMethods();
        $blueprint = $mock->createBlueprint('test', function () {
        });

        $this->assertInstanceOf(Blueprint::class, $blueprint);
    }
}
