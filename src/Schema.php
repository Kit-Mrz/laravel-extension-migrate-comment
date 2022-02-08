<?php

namespace Mrzkit\LaravelExtensionMigrateComment;

use Illuminate\Database\MySqlConnection;
use Illuminate\Database\Schema\Builder;
use Illuminate\Database\Schema\MySqlBuilder;
use Illuminate\Support\Facades\Schema as IlluminateSchema;

class Schema extends IlluminateSchema
{
    /**
     * @desc 获取门面访问者
     * @return Builder|MySqlBuilder
     */
    protected static function getFacadeAccessor()
    {
        /** @var MySqlConnection $connection */
        $connection = static::$app['db']->connection();

        $schemaBuilder = $connection->setSchemaGrammar(new MySqlGrammar())->getSchemaBuilder();

        return $schemaBuilder;
    }
}
