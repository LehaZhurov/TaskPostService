<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quieries:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает Querie';
    protected function getFileExample($name, $apiv): string
    {
        $example =
"<?php
namespace App\Http\ApiV{$apiv}\Queries;
// use App\Model\Posts;
class {$name}Querie{
        
    public function get() : void
    {
        //code
    }    
        
}";
        return $example;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $apiversion = $this->ask('Укажите версию Api');
        $name = $this->ask('Введите название Queries');
        $path = "app/Http/ApiV{$apiversion}/Queries";
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $fp = fopen($path . "/{$name}Querie.php", "w");
        fwrite($fp, $this->getFileExample($name, $apiversion));
        fclose($fp);
        $this->info('Запрос создан в ' . $path);
    }
}
