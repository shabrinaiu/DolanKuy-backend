<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\DB;

class CategoryLocationsController extends Controller
{


    public function read(Request $request)
    {
        if(empty($request->has('category'))){

            $category = CategoryLocations::all();

            $response["category"] = array();
            
            foreach ($category as $key) {
                array_push($response["category"], $key);
            }

            return response()->json(compact('category'));

        } else {

            return "LOL";

        }
    }

    public function index(Request $request)
    {
        if(empty($request->has('category'))){

            $category = DB::table('category_locations')
            ->where('name', 'not like', 'Wisata')->get();

            $response["category"] = array();
            
            foreach ($category as $key) {
                array_push($response["category"], $key);
            }

            return response()->json($response);

        } else {

            return "LOL";

        }
    }
   
    public function store(Request $request)
    {
        if(empty($request->has('name'))){

            return null;

        } else {

            $this->validate($request, [
                'name' => 'required',
            ]);

            $category = CategoryLocations::create([
                'name'=> $request->name
            ]);
            
            return response()->json($category);

        }
    }

    public function show(Request $request, $id)
    {
        if(empty($request->has('category'))){

            $category = CategoryLocations::find($id);

            if(empty($category)){

                return null;
                
            }else {
            
                $currentLocation = DB::table('list_locations')->where('category_id', $category->id)->get();
                
                return response()->json(compact('category', 'currentLocation'));
            }

        } else {

            return "LOL";

        }

    }

    
    public function update(Request $request, $id)
    {
        if(empty($request->has('name'))){

            return null;

        } else {

            $category = CategoryLocations::find($id);

            if (empty($category)){

                return null;

            } else {

                $this->validate($request,[
                    'name' => 'required'
                 ]);
              
                 
                 $category->update([
                    'name' => $request->name,
                 ]);
                 
                 return response()->json($category);

            }

        }
        
    }

    
    public function destroy(Request $request, $id)
    {
        if(empty($request->has('category'))){

            $category = CategoryLocations::find($id);

            if(empty($category)){

                return null;

            }else {
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

        } else {

            return "LOL";

        }

    }
}
