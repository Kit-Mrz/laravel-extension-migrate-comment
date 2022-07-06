<?php

namespace Mrzkit\LaravelExtensionMigrateComment;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar as Grammar;
use Illuminate\Support\Fluent;

class MySqlGrammar extends Grammar
{
    public function __construct()
    {
        $this->setTablePrefix(env('DB_PREFIX'));
    }

    /**
     * @desc 编译创建
     * @Override
     * @param Blueprint $blueprint
     * @param Fluent $command
     * @param Connection $connection
     * @return array
     */
    public function compileCreate(Blueprint $blueprint, Fluent $command, Connection $connection)
    {
        /** @var string $sql */
        $sql = $this->compileCreateTable(
            $blueprint, $command, $connection
        );

        // Once we have the primary SQL, we can add the encoding option to the SQL for
        // the table.  Then, we can check if a storage engine has been supplied for
        // the table. If so, we will add the engine declaration to the SQL query.
        $sql = $this->compileCreateEncoding(
            $sql, $connection, $blueprint
        );

        if (isset($blueprint->comment) && !empty($blueprint->comment)) {
            $sql .= " COMMENT='{$blueprint->comment}' ";
        }

        // Finally, we will append the engine configuration onto this SQL statement as
        // the final thing we do before returning this finished SQL. Once this gets
        // added the query will be ready to execute against the real connections.
        $vs = array_values(array_filter(array_merge([
                                                        $this->compileCreateEngine(
                                                            $sql, $connection, $blueprint
                                                        )
                                                    ], $this->compileAutoIncrementStartingValues($blueprint))));

        return $vs;
    }
}
