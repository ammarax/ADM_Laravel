<?php

namespace App\Console\Commands;

use App\Models\Person;
use App\Models\Planet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GetSWAPI extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:SWAPI';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The list of people and the
    information related to a planet can be accessed using the following APIs: GET https://swapi.dev/api/people';

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
        $returnCode = 0;
        $url = 'https://swapi.dev/api/people';
        $regID = '/https:\/\/swapi.dev\/api\/people\/(.*)\//';

        $validatorArray = [
            "name" => 'required|unique:people',
            "height" => 'required',
            "mass" => 'required',
            "hair_color" => 'required',
            "skin_color" => 'required',
            "eye_color" => 'required',
            "birth_year" => 'required',
            "gender" => 'required',
            "homeworld" => 'required',
            "created" => 'required|date',
            "edited" => 'required|date',
            "url" => 'required'
        ];

        echo "Sending request to $url \n";
        $response = Http::get($url);

        if ($response->successful()) {
            echo "Importing " . count($response['results']) . " from SWapi:";
            foreach ($response['results']  as $key => $value) {
                $validator = Validator::make($value, $validatorArray);
                if ($validator->fails()) {
                    echo "\n\t skip " . $value['name'] . ", reason : " . $validator->errors()->first();
                } else {
                    $validated = $validator->validated();
                    echo "\n " . $validated['name'];
                    preg_match($regID, $validated['url'], $id);
                    $validated['id'] = $id[1];
                    Person::create($validated);
                    echo "  imported ";
                    $this->importHomeworld($validated['homeworld']);
                }
            }
        } else {
            echo "api faild code: " . $response->statusCode;
            $returnCode = $response->statusCode;
        }

        return $returnCode;
    }

    public function importHomeworld($url) {
        $regHomeworld = '/https:\/\/swapi.dev\/api\/planets\/(.*)\//';

        $validatorArray = [
            "name" => "required|unique:planets",
            "rotation_period" => "required",
            "orbital_period" => "required",
            "diameter" => "required",
            "climate" => "required",
            "gravity" => "required",
            "terrain" => "required",
            "surface_water" => "required",
            "population" => "required",
            "created" => "required",
            "edited" => "required",
            "url" => "required"
        ];

        preg_match($regHomeworld, $url, $id);
        echo "\n\t\t planet: " . $id[1];
        if (Planet::where('id', $id[1])->count()<=1) {
            echo " importing ";
            $response = Http::get($url);
            if ($response->successful()) {
                $data = json_decode($response->getBody(), true);
                $validator = Validator::make($data, $validatorArray);
                echo " " . $response['name'];
                if ($validator->fails()) {
                    echo " : skipped - reason : " . $validator->errors()->first();
                } else {
                    $validated = $validator->validated();
                    $validated['id'] = $id[1];
                    Planet::create($validated);
                    echo " : imported ";
                }
            } else {
                echo " api faild code: " . $response->statusCode;
            }
        } else {
            echo " already imported";
        }
    }
}
