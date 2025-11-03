<?php

namespace App\Console\Commands\Northwind;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PhpCsFixer\Config;
use PhpCsFixer\Console\Application;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;

class Models extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:models';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Laravel's Model files for Northwinds database";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (All::$resources as $resource) {
            try {
                unlink('app/models/' . $resource['model'] . '.php');
            } catch (\Exception $e) {
                //do nothing
            }

            $this->MakeModel($resource, All::getTableInfo($resource['table']));
        }
    }

    function makeModel(array $resource, array $tableInfo)
    {
        $modelFileName = $resource['model'];

        $pk = array_keys($tableInfo)[0];
        unset($tableInfo[0]);
        $fillable = All::array_string(array_keys($tableInfo));

        $casts = [];
        foreach ($tableInfo as $key => $value) {
            if ($value['isPK']) {
                continue;
            }
            $type = $value['type'];
            switch ($type) {
                case 'INTEGER':
                    $casts[$key] = 'integer';
                    break;
                case 'REAL':
                case 'NUMERIC':
                    $casts[$key] = 'float';
                    break;
                case 'DATE':
                case 'DATETIME':
                case 'TIMESTAMP':
                    $casts[$key] = 'datetime';
                    break;
                case 'BOOLEAN':
                    $casts[$key] = 'boolean';
                    break;
                case 'BLOB':
                    $casts[$key] = 'App\Casts\BlobImageCast';
                    break;
            }
        }

        $casts = All::array_string($casts);

        $stub = file_get_contents(base_path('stubs/custom-model.stub'));

        $content = str_replace(
            ['{{ className }}', '{{ primaryKey }}', '{{ table }}', '{{ fillable }}', '{{ casts }}'],
            [$modelFileName, $pk, $resource['table'], $fillable, $casts],
            $stub
        );

        $path = app_path("Models/{$modelFileName}.php");
        All::saveAndFormat($path, $content);
    }
}
