<?php

namespace Bhry98\LaravelUsersCore\Commands;

use Bhry98\LaravelUsersCore\Database\Seeders\UsersCoreTypesSeeder;
use Illuminate\Console\Command;

class UsersTypeRunSeedCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bhry98-users-core:seed-default-types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add default package users type';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->line("starting seeding");
        $this->call('db:seed', ['--class' => UsersCoreTypesSeeder::class]);
        $this->info("seeded successfully");
    }

}