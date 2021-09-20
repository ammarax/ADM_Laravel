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
        $response = [];

        $query = Person::when($id != null && is_numeric($id), function($query) use($id) {
            $query->where('id', '=', $id );
        })->when($request->has('order'),function($query) use($request) {
            $query->orderBy($request->order);
        });

        $filters = ["name","height","mass","hair_color","skin_color","eye_color","birth_year","gender","homeworld"];
        foreach ($filters as $key => $value) {
            $response[$value] = '';
        }
        foreach ($request->all() as $key => $value) {
            if (in_array($key, $filters)) {
                $response[$key] = $value;
                $query->where($key, 'like', "%$value%");
            }
        }

        if (is_numeric($id)) {
            $response['id'] = $id;
        }
        $response['data'] = $query->get();
        return $response ;
    }

    public function truncate() {
        Person::truncate();
        return response()->json(['truncate' => 'OK'], 200);
    }
}
