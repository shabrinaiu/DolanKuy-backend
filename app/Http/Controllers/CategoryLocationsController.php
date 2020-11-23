<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\DB;

class CategoryLocationsController extends Controller
{
    public function index()
    {
        $category = DB::table('category_locations')
        ->where('name', 'not like', 'Wisata')->get();

        $response["category"] = array();
        
        foreach ($category as $key) {
            array_push($response["category"], $key);
        }

        return response()->json($response);
    }

    public function search($name){
        
        if($name == 'wisata'){
            return response()->json('tidakAda');
        }else {
            $search = CategoryLocations::where('name', 'like', "%{$name}%")->get();
            return response()->json($search);
        }

        
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
        
        return response()->json(compact('category', 'currentLocation'));
    }

    
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required'
         ]);
      
         $category = CategoryLocations::find($id);
         $category->update([
            'name' => $request->name,
         ]);
         
         return response()->json($category);
    }

    
    public function destroy(Request $request, $id)
    {
        $category = CategoryLocations::find($id);
        $currentLocation = DB::table('list_locations')->where('category_id', $category->id)->get();
        
        if($request->hasFile('image')) {
            foreach ($currentLocation as $key1 => $value1) {
                Storage::delete('/public/dolankuy/' . $value1->image);
                $currentGalery = DB::table('galery')->where('list_location_id', $value1->id)->get();
                foreach ($currentGalery as $key2 => $value2) {
                    Storage::delete('/public/dolankuy/' . $value2->filename);
                }
            }
        }
        
        $category->delete();
        return response()->json($category);
    }
}
