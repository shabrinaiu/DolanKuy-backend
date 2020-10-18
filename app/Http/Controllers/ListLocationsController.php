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
        $location = ListLocations::all();
        return response()->json($location);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $location = ListLocations::create($request->all());
        return response()->json($location, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $location = ListLocations::find($id);
        return response()->json($location);
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
            'contact' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $list_location = ListLocation::find($id);
        $list_location->name = $request->name;
        $list_location->address = $request->address;
        $list_location->description = $request->description;
        $list_location->tag = $request->tag;
        $list_location->contact = $request->contact;
        $list_location->latitude = $request->latitude;
        $list_location->longitude = $request->longitude;
        $list_location->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $location = ListLocations::find($id);
        $location->delete();
    }
}
