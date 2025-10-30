<?php

namespace App\Console\Commands\Northwind;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Requests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Laravel's Request files for Northwinds database";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (All::$resources as $resource) {

            // Removes existing requests
            try {
                unlink('app/Http/Requests/' . $resource['model'] . '/Index.php');
                unlink('app/Http/Requests/' . $resource['model'] . '/Store.php');
                unlink('app/Http/Requests/' . $resource['model'] . '/Update.php');
            } catch (\Exception $e) {
                //do nothing
            }

            $this->makeRequests($resource['model'], All::getTableInfo($resource['table']));
        }
    }

    function makeRequests(string $modelName, array $tableInfo)
    {
        $indexStub = file_get_contents(base_path('stubs/custom-index-request.stub'));

        $indexContent = str_replace(
            ['{{ modelName }}'],
            [$modelName],
            $indexStub
        );

        $requestsPath = app_path("Http/Requests/$modelName");

        if (!is_dir($requestsPath)) {
            mkdir($requestsPath, 0755, true);
        }

        $indexPath = app_path("Http/Requests/$modelName/Index.php");
        file_put_contents($indexPath, $indexContent);

        $requests = ['Store', 'Update'];
        $stub = file_get_contents(base_path('stubs/custom-request.stub'));

        foreach ($requests as $request) {
            $rules = [];

            foreach ($tableInfo as $columnName => $info) {
                $rule = [];

                if ($info['isPK']) {
                    $rules[$columnName] = 'prohibited';
                    continue;
                }

                if (!$info['nullable']) {
                    if ($request == 'Store')
                        $rule[] = 'required';
                } else {
                    $rule[] = 'nullable';
                }

                switch (strtolower($info['type'])) {
                    case 'integer':
                    case 'int':
                        $rule[] = 'integer';
                        break;
                    case 'real':
                    case 'float':
                    case 'double':
                        $rule[] = 'numeric';
                        break;
                    case 'text':
                    case 'varchar':
                    case 'char':
                        $rule[] = 'string';
                        break;
                    case 'date':
                    case 'datetime':
                        $rule[] = 'date';
                        break;
                }

                $rules[$columnName] = implode('|', $rule);
            }

            $rulesString = var_export($rules, true);
            $rulesString = str_replace(['array (', ')'], ['[', ']'], $rulesString);


            $content = str_replace(
                ['{{ className }}', '{{ modelName }}', '{{ rules }}'],
                [$request, $modelName, $rulesString],
                $stub
            );

            $path = app_path("Http/Requests/{$modelName}/{$request}.php");
            All::saveAndFormat($path, $content);
        }
    }
}
