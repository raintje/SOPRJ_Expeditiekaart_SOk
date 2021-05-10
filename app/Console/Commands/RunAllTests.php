<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RunAllTests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:all';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run all tests';

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
        $this->call('migrate:fresh', [
            '--env' => 'dusk.local',
            '--seed' => true,
        ]);
        $this->call('dusk');

        $this->call('migrate:fresh', [
            '--env' => 'dusk.local',
            '--seed' => true,
        ]);

        $this->call('test');

    }
}
