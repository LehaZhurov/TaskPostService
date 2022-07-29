<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Domain\Posts\Action\DeletedAllVoicesPostAction;

class ResetPostVoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:reset-rating {postId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обнуляет голоса указанного поста';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(DeletedAllVoicesPostAction $action)
    {
        $postId = $this->argument('postId');
        if ($postId) {
            $action->execute($postId);
            $this->info('Post Voices deleted successfully');
        }
    }
}
