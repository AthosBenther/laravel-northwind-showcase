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
use function Pest\Laravel\artisan;

class Collections extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:collections';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Generates Laravel's Collections files for Northwinds database";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach (All::$resources as $resource) {
            // try {
            //     unlink('app/http/resources/' . $resource['model'] . 'Resource.php');
            // } catch (\Exception $e) {
            //     //do nothing
            // }

            $model = $resource['model'];
            Artisan::call("make:resource " . $model . 'Collection --collection');
        }
    }
}
