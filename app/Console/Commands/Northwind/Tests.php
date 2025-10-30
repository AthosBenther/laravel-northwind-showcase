<?php

namespace App\Console\Commands\Northwind;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class Tests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:tests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Laravel's Controller files for Northwinds database";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (All::$resources as $resource) {


            $this->makeFeatureTests($resource['model'], All::getTableInfo($resource['table']));
        }
    }

    function makeFeatureTests(string $modelFileName, array $tableInfo)
    {
        $path = "tests/Feature/{$modelFileName}Test.php";

        try {
            unlink($path);
        } catch (\Exception $e) {
            //do nothing
        }



        $testPayload = [];

        foreach ($tableInfo as $key => $value) {
            if ($value['isPK'])
                continue;

            switch ($value['type']) {
                case 'INT':
                case 'INTEGER':
                    if ($value['isPK'])
                        break;
                    if (isset($value['FK']))
                        break;
                    $testPayload[$key] = '!! fake()->numberBetween(1, 1000) !!';
                    break;
                case 'NUMERIC':
                case 'REAL':
                case 'FLOAT':
                case 'DOUBLE':
                case 'DECIMAL':

                    $testPayload[$key] = '!! fake()->randomNumber() !!';
                    break;
                case 'BOOLEAN':
                    $testPayload[$key] = '!! fake()->boolean() !!';
                    break;
                case 'TEXT':
                    $testPayload[$key] = '!! fake()->sentence() !!';
                    break;
                case 'BLOB':
                    break;
                case 'DATE':
                    $testPayload[$key] = "!! fake()->dateTime()->format('Y-m-d\TH:i:s.u\Z') !!";
                    break;
                default:
                    throw new \Exception("Unhandled type {$value['type']} in Tests generation");
            }
        }

        $testPayloadString = All::array_string($testPayload);

        $stub = file_get_contents(base_path('stubs/custom-feature-test.stub'));
        $content = str_replace(
            ['{{ modelName }}', '{{ routeName }}', '{{ createTestPayload }}', '{{ updateTestPayload }}', '{{ testPK }}'],
            [$modelFileName, Str::kebab(Str::plural($modelFileName)), $testPayloadString, $testPayloadString, "'TESTPK'"],
            $stub
        );
        All::saveAndFormat($path, $content);
    }

    function textValue(string $colName): string
    {
        if ($colName == 'FirstName')
            return '!! fake()->firstName() !!';
        return '!! fake()->sentence() !!';
    }
}
