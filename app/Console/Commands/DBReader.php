<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DBReader extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:alala';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $models = [
            "Category",
            //"Customer",
            "Employee",
            "Order Detail",
            "Product",
            "Shipper",
            "Supplier",
            "Territory"
        ];

        foreach ($models as $model) {
            $modelFileName = str_replace(' ', '', $model);


            try {
                unlink('app/models/' . $modelFileName . '.php');
                unlink('app/Http/Controllers/' . $modelFileName . 'Controller.php');
                unlink('app/Http/Requests/Store' . $modelFileName . 'Request.php');
                unlink('app/Http/Requests/Update' . $modelFileName . 'Request.php');
            } catch (\Exception $e) {
                //do nothing
            }

            $table = Str::plural($model);

            $columns = $columns = DB::select("PRAGMA table_info('$table')");

            $tableInfo = [];

            foreach ($columns as $column) {
                $tableInfo[$column->name] = [
                    "isPK" => $column->pk,
                    "type" => $column->type,
                    "nullable" => $column->notnull,
                ];
            }

            $this->makeModel($modelFileName, $table, $tableInfo);
            $this->makeController($modelFileName);
            $this->makeRequests($modelFileName, $tableInfo);
            $this->makeTests($modelFileName, $tableInfo);
        }
    }

    function makeModel(string $modelFileName, string $table, array $tableInfo)
    {

        $pk = array_keys($tableInfo)[0];
        $fillable = json_encode(array_keys($tableInfo), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $stub = file_get_contents(base_path('stubs/custom-model.stub'));

        $content = str_replace(
            ['{{ className }}', '{{ primaryKey }}', '{{ fillable }}', '{{ casts }}'],
            [$modelFileName, $pk, $fillable, '[]'],
            $stub
        );

        $path = app_path("Models/{$modelFileName}.php");
        file_put_contents($path, $content);
    }

    function makeController(string $modelFileName)
    {
        $stub = file_get_contents(base_path('stubs/custom-controller.stub'));

        $content = str_replace(
            ['{{ modelName }}'],
            [$modelFileName],
            $stub
        );

        $path = app_path("Http/Controllers/{$modelFileName}Controller.php");
        file_put_contents($path, $content);
    }


    function makeRequests(string $modelFileName, array $tableInfo)
    {
        $indexStub = file_get_contents(base_path('stubs/custom-index-request.stub'));

        $indexContent = str_replace(
            ['{{ modelName }}'],
            [$modelFileName],
            $indexStub
        );

        $requestsPath = app_path("Http/Requests/$modelFileName");

        if (!is_dir($requestsPath)) {
            mkdir($requestsPath, 0755, true);
        }

        $indexPath = app_path("Http/Requests/$modelFileName/Index.php");
        file_put_contents($indexPath, $indexContent);

        $requests = ['Store', 'Update'];
        $stub = file_get_contents(base_path('stubs/custom-request.stub'));

        foreach ($requests as $request) {
            $rules = [];

            foreach ($tableInfo as $columnName => $info) {
                $rule = [];

                if ($info['isPK']) {
                    continue;
                }

                if (!$info['nullable']) {
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
                [$request, $modelFileName, $rulesString],
                $stub
            );

            $path = app_path("Http/Requests/{$modelFileName}/{$request}.php");
        }
        file_put_contents($path, $content);
    }

    function makeTests(string $modelFileName, array $tableInfo)
    {
        $stub = file_get_contents(base_path('stubs/custom-test.stub'));

        $path = "tests/Feature/{$modelFileName}Test.php";



        $testPayload = [];

        foreach (array_keys($tableInfo) as $columnName) {
            if ($tableInfo[$columnName]['isPK']) {
                $testPayload[$columnName] = 'TESTPK';
            }

            $testPayload[$columnName] = 'TESTDATA';
        }

        $testPayloadString = $this->array_string($testPayload);

        $content = str_replace(
            ['{{ modelName }}', '{{ routeName }}', '{{ createTestPayload }}', '{{ updateTestPayload }}', '{{ testPK }}'],
            [$modelFileName, Str::kebab(Str::plural($modelFileName)), $testPayloadString, $testPayloadString, "'TESTPK'"],
            $stub
        );
        file_put_contents($path, $content);
    }

    function array_string(array $data): string
    {
        $dataString = var_export($data, true);
        $dataString = str_replace(['array (', ')'], ['[', ']'], $dataString);

        return $dataString;
    }
}
