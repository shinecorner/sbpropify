<?php

namespace App\Console\Commands;

use App\Models\ServiceRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CleanDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean unnecessary data';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $config = [
            'audits' => [
                'relation' => (new ServiceRequest)->getTable(),
                'relation_table_id' => 'id',
                'relation_id' => 'auditable_id',
                'conditions' => [
                    'auditable_type' => get_morph_type_of(ServiceRequest::class)
                ],
            ]
        ];


        foreach ($config as $table => $data) {
            $query = $this->getQuery($table, $data);
            DB::statement($query);
        }

    }

    protected function getQuery($table, $data)
    {
        $relation = $data['relation'];
        $relationId = $data['relation_id'] ?? Str::singular($relation) . '_id';
        $relationTableId = $data['relation_table_id'] ?? 'id';

        $query = 'DELETE FROM `' . $table
            . '` WHERE `' . $relationId .
            '` NOT IN (SELECT `' . $relationTableId. '` FROM `' .  $relation .'`)';
        if (!empty($data['conditions'])) {
            foreach ( $data['conditions'] as $condition => $value) {
                $query .= ' and `' . $condition . '` = "' . $value . '"';
            }
        }
        return $query;
    }
}
