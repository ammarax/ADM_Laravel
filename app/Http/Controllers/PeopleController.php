<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class PeopleController extends Controller
{
    public function index(Request $request ) {
        return $this->search($request, null);
    }

    public function search(Request $request , $id) {
        $response = ['filters' => []];

        // could be replaced with Rule
        $validator = [
            "name" => "nullable|string:100",
            "height" => "nullable|string:100",
            "mass" => "nullable|string:100",
            "hair_color" => "nullable|string:100",
            "skin_color" => "nullable|string:100",
            "eye_color" => "nullable|string:100",
            "birth_year" => "nullable|string:100",
            "gender" => "nullable|string:100",
            "homeworld" => "nullable|string:100",
            "order" => "nullable|string:100",
        ];

        $valid = $request->validate($validator);

        $query = Person::when($id != null && is_numeric($id), function($query) use (&$id) {
            $query->where('id', '=', $id );
        })->when(array_key_exists('order', $valid) , function($query) use (&$valid, &$response) {
            $query->orderBy($valid['order']);
            $response['order'] = $valid['order']; // for debug purpose
            unset($valid['order']);
        });

        foreach ($valid as $key => $value) {
            $response['filters'][$key] = $value; // for debug purpose
            $query->where($key, 'like', "%$value%");
        }
        if (is_numeric($id)) {
            $response['id'] = $id; // for debug purpose
        }
        $response['data'] = $query->get();
        return $response ;
    }

    //for debug purpose
    public function truncate() {
        Person::truncate();
        return response()->json(['truncate' => 'OK'], 200);
    }
}
