<?php

namespace App\Console\Commands;

use App\Services\InstagramLikerService;
use Illuminate\Console\Command;

class RunLikerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run:liker {--endless-mode}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Liker';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $instagramLikerService = new InstagramLikerService();
        $instagramLikerService->runLiker(
            (bool) $this->option('endless-mode')
        );
        return 0;
    }
}
