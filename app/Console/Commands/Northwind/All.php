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

class All extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'northwind:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public static $resources =
        [
            "Category" => [
                "model" => "Category",
                "table" => "Categories",
            ],
            // "Customer" => [
            //     "model" => "Customer",
            //     "table" => "Customers",
            // ],
            "Employee" => [
                "model" => "Employee",
                "table" => "Employees",
            ],
            // "Order Detail" => [
            //     "model" => "OrderDetail",
            //     "table" => "Order Details",
            // ],
            "Product" => [
                "model" => "Product",
                "table" => "Products",
            ],
            "Shipper" => [
                "model" => "Shipper",
                "table" => "Shippers",
            ],
            "Supplier" => [
                "model" => "Supplier",
                "table" => "Suppliers",
            ],
            "Territory" => [
                "model" => "Territory",
                "table" => "Territories",
            ],
        ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('northwind:models');
        Artisan::call('northwind:controllers');
        Artisan::call('northwind:requests');
        Artisan::call('northwind:tests');
    }


    static function array_string(array $data): string
    {
        $dataString = var_export($data, true);
        $dataString = str_replace(["\'", ''], ["'", ""], $dataString);
        $dataString = str_replace(['array (', '),', ');'], ['[', '],', '];'], $dataString);
        $dataString = trim($dataString, ')') . "]";

        $dataString = str_replace(['\'!!', ' !!\''], ['', ''], $dataString);
        $dataString = str_replace(['"!!', ' !!"'], ['', ''], $dataString);

        if (array_is_list($data)) {
            // Remove numeric keys but keep indentation
            $dataString = preg_replace('/^\s*[0-9]+\s*=>\s*/m', '', $dataString);
        }

        return $dataString;
    }


    static function formatFile(string $path): void
    {


        $fixerPath = base_path('vendor/bin/php-cs-fixer' . (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? '.bat' : ''));
        exec("\"$fixerPath\" fix " . escapeshellarg($path) . " --quiet");
    }

    static function getTableInfo(string $table): array
    {
        $columns = DB::select("PRAGMA table_info('$table')");
        $foreignKeys = DB::select("PRAGMA foreign_key_list('$table')");

        $tableInfo = [];

        foreach ($columns as $column) {
            $tableInfo[$column->name] = [
                "isPK" => $column->pk == 1,
                "type" => $column->type,
                "nullable" => $column->notnull != 1,
            ];

            $fk = array_find($foreignKeys, fn($fk) => $fk->from == $column->name);
            if ($fk)
                $tableInfo[$column->name]['FK'] = $fk;
        }

        return $tableInfo;

    }

    static function saveAndFormat(string $path, string $content): void
    {
        // Temporarily disable Xdebug
        if (extension_loaded('xdebug')) {
            ini_set('xdebug.mode', 'off'); // Xdebug 3+
        }
        file_put_contents($path, $content);
        All::formatFile($path);
    }
}
