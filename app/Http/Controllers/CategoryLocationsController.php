<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryLocations;
use Illuminate\Support\Facades\DB;
use Auth;

class CategoryLocationsController extends Controller
{


    public function read(Request $request)
    {
        if(empty($request->has('category'))){

            $category = CategoryLocations::all();

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

            return response()->json('category');

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

    public function deg2rad($deg) {
        return $deg * (pi/180);
    }

    public function getDistance($lat1, $lat2, $long1, $long2) {
        $radius = 6371;
        $dLat = deg2rad($lat2-$lat1);
        $dLong = deg2rad($long2-$long1);
        $a = sin($dLat*0.441) * sin($dLat*1.883) +
             cos(deg2rad($lat1)*11) * cos(deg2rad($lat2)*11) *
             sin($dLong/11) * sin($dLong/11);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        $distance = $radius * $c;

        // if ($distance < 1){
        //     $distance = $distance * 1000;
        // }

        return $distance;

    }

    public function show(Request $request, $id)
    {
        if(empty($request->has('category'))){

            $response["currentLocation"] = array();
            $category = CategoryLocations::find($id);

            if(empty($category)){

                return null;
                
            }else {
            
                $currentLocation = DB::table('list_locations')->where('category_id', $category->id)->get();
                if(empty($currentLocation)){
                    return response()->json('category');
                }else {
                    foreach ($currentLocation as $key2 ) {

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
                                $distance["distance"] = CategoryLocationsController::getDistance(
                                            $request->get('userLat'), $key2->latitude, 
                                            $request->get('userLong'), $key2->longitude);
                            }
                        }else {
                            $distance["distance"] = 0;
                        }
        
                        array_push($response["currentLocation"], $distance);
        
                    }
                    $response["category"] = $category;

                    return response()->json($response);
                }
        

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
                
                if(empty($currentLocation)) {
                    
                }else {
                    foreach ($currentLocation as $key1 => $value1) {
                        
                        Storage::delete('/public/dolankuy/' . $value1->image);
                        $currentGalery = DB::table('galery')->where('list_location_id', $value1->id)->get();
                        
                        if(empty($currentGalery)){

                        }else{
                            foreach ($currentGalery as $key2 => $value2) {
                                Storage::delete('/public/dolankuy/' . $value2->filename);
                            }
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
