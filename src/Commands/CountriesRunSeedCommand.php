<?php

namespace Bhry98\LaravelUsersCore\Commands;

use Bhry98\LaravelUsersCore\Database\Seeders\UsersCoreCountriesSeeder;
use Bhry98\LaravelUsersCore\Database\Seeders\UsersCoreTypesSeeder;
use Illuminate\Console\Command;

class CountriesRunSeedCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bhry98-users-core:seed-default-countries';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add default package countries';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->line("starting seeding");
        $this->call('db:seed', ['--class' => UsersCoreCountriesSeeder::class]);
        $this->info("seeded successfully");
    }

}