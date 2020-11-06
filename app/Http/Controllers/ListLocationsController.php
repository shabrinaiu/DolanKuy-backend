<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListLocations;
use App\Models\Galery;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ListLocationsController extends Controller
{
    
    public function index()
    {
        $category = CategoryLocations::all();
        $list_location = ListLocations::all();
        $galery = Galery::all();
        return response()->json([$list_location, $category, $galery]);
    }

   
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'tag' => 'required',
            'image' => 'required|image|mimes:png,jpeg,jpg',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);

            $list_location = ListLocations::create([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => $filename,
                'tag' => $request->tag,
                'contact' => $request->contact,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        
        return response()->json($list_location);
    }

    
    public function show($id)
    {
        $list_location = ListLocations::find($id);
        $currentGalery = DB::table('galery')->where('list_location_id', $list_location->id)->get();
        return response()->json([$list_location, $currentGalery]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'tag' => 'required',
            'image' => 'required|image|mimes:png,jpeg,jpg',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $list_location = ListLocations::find($id);

        if($request->hasFile('image')) {
            Storage::delete('/public/dolankuy/' . $list_location->image);
        }
        $file = $request->file('image');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('public/dolankuy/', $filename); 
        $list_location->update([ 
            'name' => $request->name,
            'address' => $request->address,
            'image' => $filename,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'tag' => $request->tag,
            'contact' => $request->contact,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude
        ]);
        
        return response()->json($list_location);

    }

    public function destroy(Request $request, $id)
    {
        $list_location = ListLocations::find($id);
        $currentGalery = DB::table('galery')->where('list_location_id', $list_location->id)->get();
        if($request->hasFile('image')) {
            foreach ($currentGalery as $key => $value) {
                Storage::delete('/public/dolankuy/' . $value->filename);
            }
        }
        $list_location->delete();
        return response()->json($list_location);
    }
}
