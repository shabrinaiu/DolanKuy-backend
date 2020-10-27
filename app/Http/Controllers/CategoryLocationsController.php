<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\DB;

class CategoryLocationsController extends Controller
{
    public function index()
    {
        $category = CategoryLocations::all();
        return response()->json($category);
    }

   
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        $category = CategoryLocations::create([
            'name'=> $request->name
        ]);
        
        return response()->json($category);
    }

    public function show($id)
    {
        $category = CategoryLocations::find($id);
        $currentLocation = DB::table('list_locations')->where('category_id', $category->id)->get();
        return response()->json($currentLocation);
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
         ]);
      
         $category = CategoryLocations::find($id);
         $category->name = $request->name;
         $category->save();
         return response()->json($category);
    }

    
    public function destroy($id)
    {
        $category = CategoryLocations::find($id);
        $currentLocation = DB::table('list_locations')->where('category_id', $category->id)->get();
        
        foreach ($currentLocation as $key1 => $value1) {
            Storage::delete('/public/dolankuy/' . $value1->image);
            $currentGalery = DB::table('galery')->where('list_location_id', $value1->id)->get();
            foreach ($currentGalery as $key2 => $value2) {
                Storage::delete('/public/dolankuy/' . $value2->filename);
            }
        }
        
        $category->delete();
        return response()->json($category);
    }
}
