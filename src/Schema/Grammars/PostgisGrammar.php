<?php

namespace MStaack\LaravelPostgis\Schema\Grammars;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Grammars\PostgresGrammar;
use MStaack\LaravelPostgis\Schema\Blueprint;
use MStaack\LaravelPostgis\Exceptions\UnsupportedGeomtypeException;

class PostgisGrammar extends PostgresGrammar
{
    public static $allowed_geom_types = ['GEOGRAPHY', 'GEOMETRY'];

     /**
     * Check if the type is uuid, use internal guid
     * 
     * @param  string $type
     * @return \Doctrine\DBAL\Types\Type
     */
    protected function getDoctrineColumnType($type)
    {
        if($type === 'uuid') {
            $type = 'guid';
        }

        return parent::getDoctrineColumnType($type);
    }

    /**
     * Create the column definition for a character type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeCharacter(Fluent $column)
    {
        return "character({$column->length})";
    }

    /**
     * Create the column definition for a hstore type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeHstore(Fluent $column)
    {
        return "hstore";
    }

    /**
     * Create the column definition for a uuid type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeUuid(Fluent $column)
    {
        return "uuid";
    }

    /**
     * Create the column definition for a jsonb type.
     *
     * @param Fluent $column
     * @return string
     */
    protected function typeJsonb(Fluent $column)
    {
        return "jsonb";
    }

    /**
     * Create the column definition for an IPv4 or IPv6 address.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeIpAddress(Fluent $column)
    {
        return 'inet';
    }
    /**
     * Create the column definition for a CIDR notation-style netmask.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeNetmask(Fluent $column)
    {
        return 'cidr';
    }

    /**
     * Create the column definition for a MAC address.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeMacAddress(Fluent $column)
    {
        return 'macaddr';
    }

    /**
     * Create the column definition for a line represented as a standard linear equation Ax + By + C = 0.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeLine(Fluent $column)
    {
        return 'line';
    }

    /**
     * Create the column definition for a line segment represented by two points (x1, y1), (x2, y2).
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeLineSegment(Fluent $column)
    {
        return 'lseg';
    }

    /**
     * Create the column definition for a path represented as a list of points (x1, y1), (x2, y2), ..., (xn, yn).
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typePath(Fluent $column)
    {
        return 'path';
    }

    /**
     * Create the column definition for a box represented by opposite corners of the box as points (x1, y1), (x2, y2).
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeBox(Fluent $column)
    {
        return 'box';
    }

    /**
     * Create the column definition for a circle represented by a center point and a radius <(x, y), r>
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeCircle(Fluent $column)
    {
        return 'circle';
    }

    /**
     * Create the column definition for storing amounts of currency with a fixed fractional precision.
     *
     * This will store values in the range of: -92233720368547758.08 to +92233720368547758.07. (92 quadrillion).
     * Output is locale-sensitive, see lc_monetary setting of PostgreSQL instance/s.
     *
     * @param  \Illuminate\Support\Fluent  $column
     * @return string
     */
    protected function typeMoney(Fluent $column)
    {
        return 'money';
    }

    /**
     * Create the column definition for an int4range type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeInt4range(Fluent $column)
    {
        return "int4range";
    }

    /**
     * Create the column definition for an int8range type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeInt8range(Fluent $column)
    {
        return "int8range";
    }

    /**
     * Create the column definition for an numrange type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeNumrange(Fluent $column)
    {
        return "numrange";
    }

    /**
     * Create the column definition for an tsrange type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeTsrange(Fluent $column)
    {
        return "tsrange";
    }

    /**
     * Create the column definition for an tstzrange type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeTstzrange(Fluent $column)
    {
        return "tstzrange";
    }

    /**
     * Create the column definition for an daterange type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeDaterange(Fluent $column)
    {
        return "daterange";
    }
    
    /**
     * Create the column definition for a Text Search Vector type.
     *
     * @param Fluent $column
     *
     * @return string
     */
    protected function typeTsvector(Fluent $column)
    {
        return "tsvector";
    }

    /**
     * @param mixed $value
     * @return mixed|string
     */
    protected function getDefaultValue($value)
    {
        if($this->isUuid($value)) return strval($value);

        return parent::getDefaultValue($value);
    }

    /**
     * Check if string matches on of uuid_generate functions
     *
     * @param $value
     * @return int
     */
    protected function isUuid($value)
    {
        return preg_match('/^uuid_generate_v/', $value);
    }

    /**
     * Compile a gin index key command.
     *
     * @param  \MStaack\LaravelPostgis\Schema\Blueprint  $blueprint
     * @param  \Illuminate\Support\Fluent  $command
     * @return string
     */
    public function compileGin(Blueprint $blueprint, Fluent $command)
    {
        $columns = $this->columnize($command->columns);

        return sprintf('CREATE INDEX %s ON %s USING GIN(%s)', $command->index, $this->wrapTable($blueprint), $columns);
    }
    
    /**
     * Compile a gist index key command.
     *
     * @param  \MStaack\LaravelPostgis\Schema\Blueprint  $blueprint
     * @param  \Illuminate\Support\Fluent  $command
     * @return string
     */
    public function compileGist(Blueprint $blueprint, Fluent $command)
    {
        $columns = $this->columnize($command->columns);

        return sprintf('CREATE INDEX %s ON %s USING GIST(%s)', $command->index, $this->wrapTable($blueprint), $columns);
    }

    /**
     * Adds a statement to add a point geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typePoint(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'POINT');
    }

    /**
     * Adds a statement to add a point geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeMultipoint(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'MULTIPOINT');
    }

    /**
     * Adds a statement to add a polygon geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typePolygon(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'POLYGON');
    }

    /**
     * Adds a statement to add a multipolygon geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeMultipolygon(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'MULTIPOLYGON');
    }

    /**
     * Adds a statement to add a multipolygonz geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeMultiPolygonZ(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'MULTIPOLYGONZ');
    }

    /**
     * Adds a statement to add a linestring geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeLinestring(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'LINESTRING');
    }

    /**
     * Adds a statement to add a multilinestring geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeMultilinestring(Fluent $column)
    {
        return $this->createTypeDefinition($column, 'MULTILINESTRING');
    }

    /**
     * Adds a statement to add a linestring geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeGeography(Fluent $column)
    {
        return 'GEOGRAPHY';
    }

    /**
     * Adds a statement to add a geometry column
     *
     * @param \Illuminate\Support\Fluent $column
     * @return string
     */
    public function typeGeometry(Fluent $column)
    {
        return 'GEOMETRY';
    }

    /**
     * Adds a statement to add a geometrycollection geometry column
     *
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @return string
     */
    public function compileGeometrycollection(Blueprint $blueprint, Fluent $command)
    {
        $command->type = 'GEOMETRYCOLLECTION';

        return $this->compileGeometry($blueprint, $command);
    }

    /**
     * Adds a statement to create the postgis extension
     *
     * @return string
     */
    public function compileEnablePostgis()
    {
        return 'CREATE EXTENSION postgis';
    }

    /**
     * Adds a statement to create the postgis extension, if it doesn't already exist
     *
     * @return string
     */
    public function compileEnablePostgisIfNotExists()
    {
        return 'CREATE EXTENSION IF NOT EXISTS postgis';
    }

    /**
     * Adds a statement to drop the postgis extension
     *
     * @return string
     */
    public function compileDisablePostgis()
    {
        return 'DROP EXTENSION postgis';
    }

    /**
     * Adds a statement to drop the postgis extension, if it exists
     *
     * @return string
     */
    public function compileDisablePostgisIfExists()
    {
        return 'DROP EXTENSION IF EXISTS postgis';
    }

    /**
     * Adds a statement to add a geometry column
     *
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @return string
     */
    protected function compileGeometry(Blueprint $blueprint, Fluent $command)
    {

        $dimensions = $command->dimensions ?: 2;
        $typmod = $command->typmod ? 'true' : 'false';
        $srid = $command->srid ?: 4326;
        $schema = function_exists('config') ? config('postgis.schema') : 'public';

        return sprintf(
                "SELECT %s.AddGeometryColumn('%s', '%s', %d, '%s.%s', %d, %s)",
                $schema,
                $blueprint->getTable(),
                $command->column,
                $srid,
                $schema,
                strtoupper($command->type),
                $dimensions,
                $typmod
        );
    }

    /**
     * Checks if the given $column is a valid geometry type
     *
     * @param \Illuminate\Support\Fluent $column
     * @return boolean
     */
    protected function isValid($column)
    {
        return in_array(strtoupper($column->geomtype), PostgisGrammar::$allowed_geom_types) && is_int((int) $column->srid);
    }

    /**
     * Create definition for geometry types.
     * @param Fluent $column
     * @param string $geometryType
     * @return string
     * @throws UnsupportedGeomtypeException
     */
    private function createTypeDefinition(Fluent $column, $geometryType)
    {
        $schema = function_exists('config') ? config('postgis.schema') : 'public';
        $type = strtoupper($column->geomtype);
        if ($this->isValid($column)) {
            if ($type == 'GEOGRAPHY' && $column->srid != 4326) {
                throw new UnsupportedGeomtypeException('Error with validation of srid! SRID of GEOGRAPHY must be 4326)');
            }
            return $schema . '.' . $type . '(' . $geometryType . ', ' . $column->srid . ')';
        } else {
            throw new UnsupportedGeomtypeException('Error with validation of geom type or srid!');
        }
    }

}
