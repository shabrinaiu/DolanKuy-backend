<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListLocations;
use App\Models\Galery;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;

class ListLocationsController extends Controller
{
    
    public function deg2rad($deg) {
        return $deg * (pi/180);
    }

    public function getDistance($lat1, $lat2, $long1, $long2) {
        $radius = 6371;
        $dLat = deg2rad($lat2-$lat1);
        $dLong = deg2rad($long2-$long1);
        $a = sin($dLat/2) * sin($dLat/2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLong/2) * sin($dLong/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $radius * $c;

        if ($distance < 1){
            $distance = $distance * 1000;
        }

        return $distance;

    }

    public function getAcomodation(Request $request)
    {
        $category = DB::table('category_locations')
        ->where('name', 'not like', 'Wisata')->get();

        foreach ($category as $key) {
            $temp = DB::table('list_locations')
            ->where('category_id', '=', $key->id)->get();

            foreach ($temp as $key2 ) {
                $acomodation[] = $key2;
                if(Auth::guard('users')->check()){
                    if($request->userLat==0 && $request->userLong==0){
                        $distance[] = 0;
                    }else {
                        $distance[] = ListLocationsController::getDistance(
                                    $request->get('userLat'), $key2->latitude, 
                                    $request->get('userLong'), $key2->longitude);
                    }
                }else {
                    $distance[] = 0;
                }
            }
        }

        return response()->json([$category, $acomodation, $distance]);
    }

    public function index(Request $request)
    {
        $category = DB::table('category_locations')
        ->where('name', 'like', 'Wisata')->get()->first();

        $list_location = DB::table('list_locations')
        ->where('category_id', '=', $category->id)->get();

        $galery = Galery::all();

        foreach ($list_location as $key ) {
            if(Auth::guard('users')->check()){
                if($request->userLat==0 && $request->userLong==0){
                    $distance[] = 0;    
                }else {
                    $distance[] = ListLocationsController::getDistance(
                                $request->get('userLat'), $key->latitude, 
                                $request->get('userLong'), $key->longitude);
                }
            } else {
                $distance[] = 0;
            }
        }
        
        return response()->json([$list_location, $galery, $distance]);
    }

    public function search(Request $request)
	{
		$search = $request->search;
 
    	$list_location = DB::table('list_locations')
		->where('address','like',"%".$search."%")->get();
 
    	return response()->json([$list_location]);
 
	}

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            //'tag' => 'required',
            'image' => 'required|image|mimes:png,jpeg,jpg',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);
        }else{
            $filename= $request->image;
        }

            $list_location = ListLocations::create([
                'name' => $request->name,
                'address' => $request->address,
                'description' => $request->description,
                'category_id' => $request->category_id,
                'image' => $filename,
                //'tag' => $request->tag,
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
            //'tag' => 'required',
            'image' => 'required|image|mimes:png,jpeg,jpg',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $list_location = ListLocations::find($id);

        if($request->hasFile('image')) {
            Storage::delete('/public/dolankuy/' . $list_location->image);
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);
        }else{
            $filename =$request->image;
        }
         
        $list_location->update([ 
            'name' => $request->name,
            'address' => $request->address,
            'image' => $filename,
            'category_id' => $request->category_id,
            'description' => $request->description,
            //'tag' => $request->tag,
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
