<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Models\Planet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TruncateSWAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swapi:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Truncate list of swapi for new tests.';

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
        Person::truncate();
        Planet::truncate();
    }

}
