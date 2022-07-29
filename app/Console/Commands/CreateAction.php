<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'action:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда создает Action';

    protected function getFileExample($name, $domain): string
    {
        $example =
            "<?php
namespace App\Domain\{$domain}\Action;
use App\Domain\{$domain}\Models\YourModel;
class {$name}Action{
        
    public function execute() : void
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
        $domain = $this->ask('Укажите имя Домена');
        $name = $this->ask('Введите название Action');
        $path = "app/Domain/{$domain}/Action";
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $fp = fopen($path . "/{$name}Action.php", "w");
        fwrite($fp, $this->getFileExample($name, $domain));
        fclose($fp);
        $this->info('Действие создано в ' . $path);
    }
}
