<?php

namespace App\Console\Commands;

use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\UserSettings;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
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
        $audits = $this->getMorphTable('auditable_id', 'auditable_type');
        $audits[] = [
            'relation' => (new User())->getTable(),
            'conditions' => [
                'user_type' => get_morph_type_of(User::class)
            ],
        ];
        
        $config = [
            'audits' => $audits
        ];


        foreach ($config as $table => $data) {
            if (Arr::isAssoc($data)) {
                $query = $this->getQuery($table, $data);
                DB::statement($query);
            } else {
                foreach ( $data as $_data) {
                    $query = $this->getQuery($table, $_data);
                    DB::statement($query);
                }
            }
        }

        echo 'final';

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
        echo $query . PHP_EOL;
        echo '-----------------------' . PHP_EOL;
        return $query;
    }

    protected function getMorphTable($relatedId, $relatedType)
    {
        $classes = [
            ServiceRequest::class,
            User::class,
            UserSettings::class,
        ];
        $data = [];
        foreach ($classes as $class) {
            $data[] = [
                'relation' => (new $class)->getTable(),
                'relation_id' => $relatedId,
                'conditions' => [
                    $relatedType => get_morph_type_of($class)
                ],
            ];
        }

        return $data;
    }
}
