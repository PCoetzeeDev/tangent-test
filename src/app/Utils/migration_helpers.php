<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

/*
 * Note: Add helper files to composer.json under autoload/files and dump autoload to activate
 */

if (!function_exists('create_vo_schema')) {
    /**
     * @param string $tableName
     * @param bool $softDeletes
     * @return void
     */
	function create_valueobject_schema (string $tableName, bool $softDeletes=true) : void
    {
		Schema::create($tableName, function (Blueprint $table) use ($softDeletes) {
            $table->increments('id');
			$table->text('name');
			$table->text('slug')->unique();
			$table->integer('order')->default(1);
			$table->boolean('is_active')->default(true);
			$table->timestamps();

			if ($softDeletes === true) {
    			$table->softDeletes();
			}
        });
	}
}


if (!function_exists('populate_vo_data')) {
    /**
     * @param array $slugNames
     * @param string $tableName
     * @param int $order
     * @return void
     */
	function populate_vo_data (array $slugNames, string $tableName, int $order = 0) : void
    {
        $rowData = [];
        $now = now('UTC')->format('Y-m-d H:i:s');

        foreach ($slugNames as $slugName) {
            $rowData[] = [
                'slug' => slugify($slugName),
	            'name' => $slugName,
	            'order' => $order,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $order = $order + 100;
        }

        DB::table($tableName)->insert($rowData);
	}
}

if (!function_exists('create_foreign_key')) {
    /**
     * @param Blueprint $table
     * @param string $tableName name of foreign table, aka. not the one referenced in $table, ie. profiles
     * @param string $onDelete eg. CASCADE, SET NULL, SET DEFAULT, RESTRICT, NO ACTION
     * @param string $tableNameKey if different from <table name without s>_<foreign key> e.g. profile_foos_id
     * @param bool $nullable
     * @param bool $bigInt
     * @param string $foreignKey Default: id
     * @param string $onUpdate
     * @param mixed|null $default Default value on insert, null needs nullable = true
     * @return void
     */
	function create_foreign_key (
        Blueprint $table,
        string $tableName,
        string $onDelete = '',
        string $tableNameKey = '',
        bool $nullable = false,
        bool $bigInt = false,
        string $foreignKey = 'id',
        string $onUpdate = '',
        mixed $default = null
    ) : void
    {
	    if ($tableNameKey === '') {
	        $tableNameKey = substr($tableName, 0, -1) . '_' . $foreignKey;
	    }

	    if ($bigInt) {
    	    $table
                ->bigInteger($tableNameKey)
                ->unsigned()
                ->nullable($nullable)
                ->default($default);
	    } else {
    	    $table
                ->integer($tableNameKey)
                ->unsigned()
                ->nullable($nullable)
                ->default($default);
	    }

        if ($onDelete !== '' && $onUpdate !== '') {
            $table
                ->foreign($tableNameKey)
                ->references($foreignKey)
                ->on($tableName)
                ->onUpdate($onUpdate)
                ->onDelete($onDelete);
        } elseif ($onDelete !== '') {
            $table
                ->foreign($tableNameKey)
                ->references($foreignKey)
                ->on($tableName)
                ->onDelete($onDelete);
        } elseif ($onUpdate !== '') {
            $table
                ->foreign($tableNameKey)
                ->references($foreignKey)
                ->on($tableName)
                ->onUpdate($onUpdate);
        } else {
            $table
                ->foreign($tableNameKey)
                ->references($foreignKey)
                ->on($tableName);
        }
	}
}

if (!function_exists('create_unique_code_for_table')) {
    /**
     * Generate a unique value for a given field and table
     *
     * @param string $table
     * @param string $field
     * @param int $length
     * @return string
     * @throws Exception
     */
    function create_unique_code_for_table (string $table, string $field = 'code', int $length = 4) : string
    {
        if ($length < 2) {
            throw new Exception('Length of requested string must be at least 2');
        }

        do {
            $uniqueCode = get_decent_code($length);
            $foundCode = (
                DB::table($table)
                    ->where($field, '=', $uniqueCode)
                    ->limit(1)
                    ->first() !== null
            );

            $length++;
        } while ($foundCode);

        return $uniqueCode;
    }
}
