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

class Controllers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:controllers';

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

        foreach (All::$resources as $resource) {
            try {
                unlink('app/Http/Controllers/' . $resource['model'] . 'Controller.php');
            } catch (\Exception $e) {
                //do nothing
            }

            $this->makeController($resource['model']);
        }
    }

    function makeController(string $modelFileName)
    {
        $stub = file_get_contents(base_path('stubs/custom-controller.stub'));

        $content = str_replace(
            ['{{ modelName }}', '{{ modelNameLC }}'],
            [$modelFileName, lcfirst($modelFileName)],
            $stub
        );

        $path = app_path("Http/Controllers/{$modelFileName}Controller.php");
        file_put_contents($path, $content);
    }
}
