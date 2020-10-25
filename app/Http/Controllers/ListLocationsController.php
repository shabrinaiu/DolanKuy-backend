<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListLocations;

class ListLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_location = ListLocations::all();
        return response()->json($list_location);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'tag' => 'required',
            'image' => 'required',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $list_location = ListLocations::create([
            'name' => $request->name,
            'address' => $request->address,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'image' => $request->image,
            'tag' => $request->tag,
            'contact' => $request->contact,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        return response()->json($list_location);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list_location = ListLocations::find($id);
        return response()->json($list_location);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'address' => 'required',
            'description' => 'required',
            'tag' => 'required',
            'image' => 'required',
            'contact' => 'required',
            'category_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $list_location = ListLocations::find($id);
        $list_location->name = $request->name;
        $list_location->address = $request->address;
        $list_location->image = $request->image;
        $list_location->category_id = $request->category_id;
        $list_location->description = $request->description;
        $list_location->tag = $request->tag;
        $list_location->contact = $request->contact;
        $list_location->latitude = $request->latitude;
        $list_location->longitude = $request->longitude;
        $list_location->save();
        return response()->json($list_location);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list_location = ListLocations::find($id);
        $list_location->delete();
        return response()->json($list_location);
    }
}
