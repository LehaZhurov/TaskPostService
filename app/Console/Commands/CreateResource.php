<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'resource:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected function getFileExample($name, $apiv): string
    {
        $example =
            "<?php
namespace App\Http\ApiV{$apiv}\Resources;
 
use Illuminate\Http\Resources\Json\ResourceCollection;
 
class {$name}Resource extends ResourceCollection
{
    
    public function toArray()
    {
        return [
            'data' => [],
        ];
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
        $name = $this->ask('Введите название Resource');
        $path = "app/Http/ApiV{$apiversion}/Resources";
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $fp = fopen($path . "/{$name}Resource.php", "w");
        fwrite($fp, $this->getFileExample($name, $apiversion));
        fclose($fp);
        $this->info('Ресурс создан в ' . $path);
    }
}
