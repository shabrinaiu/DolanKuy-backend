<?php

namespace App\Http\Controllers;
use App\Models\Galery;
use App\Models\ListLocations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class GaleryController extends Controller
{
    public function index()
    {
        $galery = Galery::all();
        return response()->json($galery);
    }

   
    public function store(Request $request)
    {
        $this->validate($request, [
            'filename' => 'required',
        ]);

        $category = CategoryLocations::create([
            'name'=> $request->name
        ]);
        
        return response()->json($category);
    }

    public function show(ListLocations $list_location)
    {
        $galery = DB::table('galery')->where('list_location_id', $list_location->id)->get();;
        return response()->json($galery);
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
        $galery = Galery::find($id);
        $galery->delete();
        return response()->json($galery);
    }
}
