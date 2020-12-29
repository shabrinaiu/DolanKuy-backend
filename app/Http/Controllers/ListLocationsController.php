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

    public function dashboard(Request $request)
    {

        $category = DB::table('category_locations')
        ->where('name', 'like', 'Wisata')->get()->first();

        $locations = DB::table('list_locations')
        ->where('category_id', '=', $category->id)
        ->orderBy('updated_at', 'desc')
        ->get();

        return response()->json(compact('locations'));
    }

    public function getAcomodation(Request $request)
    {
        $category = DB::table('category_locations')
        ->where('name', 'not like', 'Wisata')->get();

        $response["acomodation"] = array();
        $response["category"] = array();

        foreach ($category as $key) {
            $temp = DB::table('list_locations')
            ->where('category_id', '=', $key->id)->get();

            foreach ($temp as $key2 ) {

                $distance["id"] = $key2->id;
                $distance["name"] = $key2->name;
                $distance["address"] = $key2->address;
                $distance["description"] = $key2->description;
                $distance["category_id"] = $key2->category_id;
                $distance["image"] = $key2->image;
                $distance["contact"] = $key2->contact;
                $distance["latitude"] = $key2->latitude;
                $distance["longitude"] = $key2->longitude;

                $acomodation[] = $key2;
                if(Auth::guard('users')->check()){
                    if($request->userLat==0 && $request->userLong==0){
                        $distance["distance"] = 0;
                    }else {
                        $distance["distance"] = ListLocationsController::getDistance(
                                    $request->get('userLat'), $key2->latitude,
                                    $request->get('userLong'), $key2->longitude);
                    }
                }else {
                    $distance["distance"] = 0;
                }

                array_push($response["acomodation"], $distance);

            }

            array_push($response["category"], $key);

        }



        return response()->json($response);
    }

    public function index(Request $request)
    {
        $category = DB::table('category_locations')
        ->where('name', 'like', 'Wisata')->get()->first();

        $list_location = DB::table('list_locations')
        ->where('category_id', '=', $category->id)->get();

        $response["locations"] = array();

        foreach ($list_location as $key ) {

            $distance["id"] = $key->id;
            $distance["name"] = $key->name;
            $distance["address"] = $key->address;
            $distance["description"] = $key->description;
            $distance["category_id"] = $key->category_id;
            $distance["image"] = $key->image;
            $distance["contact"] = $key->contact;
            $distance["latitude"] = $key->latitude;
            $distance["longitude"] = $key->longitude;

            if(Auth::guard('users')->check()){
                if($request->userLat==0 && $request->userLong==0){

                    $distance["distance"] = 0;
                }else {
                    $distance["distance"] = ListLocationsController::getDistance(
                                $request->get('userLat'), $key->latitude,
                                $request->get('userLong'), $key->longitude);
                }
            } else {
                $distance["distance"] = 0;
            }


            array_push($response["locations"], $distance);

        }

        return response()->json($response);
    }

    public function search(Request $request)
	{
        if(empty($request->has('search'))){
            return null;
        }
        $search = $request->search;

    	$search_result = DB::table('list_locations')
        ->where('address','like','%'.$search.'%')
        ->orWhere('name', 'like','%'.$search.'%')
        ->get();

    	return response()->json(compact('search_result'));

	}

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            //'tag' => 'required',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        if($request->hasFile('image')) {

            $this->validate($request,[
                'image' => 'required|image|mimes:png,jpeg,jpg'
            ]);

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);
        }else{
            $filename= "N/A";
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
        $detail_location = ListLocations::find($id);

        if (empty($detail_location)){
            return null;
        }

        $currentGalery = DB::table('galery')->where('list_location_id', $detail_location->id)->get();

        if (empty($currentGalery)){
            return response()->json(compact('detail_location'));
        }

        return response()->json(compact('detail_location', 'currentGalery'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            //'tag' => 'required',
            'category_id' => 'required'
        ]);

        $list_location = ListLocations::find($id);

        if(empty($list_location)){
            return null;
        }

        if($request->get('name')==NULL){
            $name = $list_location->name;
        } else{
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $name = $request->get('name');
        }

        if($request->get('address')==NULL){
            $address = $list_location->address;
        } else{
            $validator = Validator::make($request->all(), [
                'address' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $address = $request->get('address');
        }

        if($request->get('description')==NULL){
            $description = $list_location->description;
        } else{
            $validator = Validator::make($request->all(), [
                'description' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $description = $request->get('description');
        }

        if($request->get('contact')==NULL){
            $contact = $list_location->contact;
        } else{
            $validator = Validator::make($request->all(), [
                'contact' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $contact = $request->get('contact');
        }

        if($request->get('latitude')==NULL){
            $latitude = $list_location->latitude;
        } else{
            $validator = Validator::make($request->all(), [
                'latitude' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $latitude = $request->get('latitude');
        }

        if($request->get('longitude')==NULL){
            $longitude = $list_location->longitude;
        } else{
            $validator = Validator::make($request->all(), [
                'longitude' => 'required'
            ]);

            if($validator->fails()){
                return response()->json(['status' => $validator->errors()->toJson()], 400);
            }
            $longitude = $request->get('longitude');
        }

        if($request->hasFile('image')) {
            $this->validate($request,[
                'image' => 'required|image|mimes:png,jpeg,jpg'
            ]);
            Storage::delete('/public/dolankuy/' . $list_location->image);
            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);
        }else{
            $filename = $list_location->image;
        }

        $list_location->update([
            'name' => $name,
            'address' => $address,
            'image' => $filename,
            'category_id' => $request->category_id,
            'description' => $description,
            //'tag' => $request->tag,
            'contact' => $contact,
            'latitude' => $latitude,
            'longitude' => $longitude
        ]);

        return response()->json($list_location);

    }

    public function destroy(Request $request, $id)
    {
        $list_location = ListLocations::find($id);
        if(empty($list_location)){
            return null;
        }
        $currentGalery = DB::table('galery')->where('list_location_id', $list_location->id)->get();

        if(empty($currentGalery)){
            return null;
        }

        if($request->hasFile('image')) {
            foreach ($currentGalery as $key => $value) {
                Storage::delete('/public/dolankuy/' . $value->filename);
            }
        }
        $list_location->delete();
        return response()->json($list_location);
    }
}
