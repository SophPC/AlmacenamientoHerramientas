<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use App\Place;

class PlaceController extends Controller
{
    
    public function create()
    {
        if (Auth::check()) {
            return view('places.create');
        } else {
            abort(403);
        }
    }

    public function store()
    {
        $data = request()->validate([
            'id' => 'unique:places,id|required|alpha_num|size:5',
            'name' => 'string|required',
        ]);

        $place = Place::create($data);

        return Redirect::to('/place/' . $place->id);
    }

    public function show(Place $place)
    {
        return view('places.show', compact('place'));
    }

    public function showAll(Request $request)
    {
        if ($request->ajax()) {
            $data = Place::all();
            return DataTables::of($data)
                ->setRowAttr([
                    'href' => '/place/{{ $id }}',
                ])
                ->make(true);
        }
        return view('places.showAll');
    }

    public function edit(Place $place)
    {
        if (Auth::check()) {
            return view('places.edit', compact('place'));
        } else {
            abort(403);
        }
    }

    public function update(Place $place)
    {
        $data = request()->validate([
            'id' => 'required|alpha_num|size:5',
            'name' => 'string|required',
        ]);

        $place->update($data);

        return Redirect::to('/place/' . $place->id);
    }

    public function destroy($place_id)
    {
        Place::destroy($place_id);

        return Redirect::to('/places');
    }

}
