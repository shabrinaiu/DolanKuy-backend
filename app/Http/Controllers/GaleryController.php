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
        return response()->json(compact('galery'));
    }
   
    public function store(Request $request)
    {
        $request->validate([
            'list_location_id' => 'required'
        ]);
        
        if($request->hasFile('filename')) {
            $request->validate([
                'filename' => 'required|image|mimes:png,jpeg,jpg'
            ]);
            $file = $request->file('filename');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/dolankuy/', $filename);
        }else{
            $filename= $request->filename;
        }

        $galery = Galery::create([
            'list_location_id' => $request->list_location_id,
            'filename' => $filename,
        ]);
        
        return response()->json($galery);
    }

    public function show($id)
    {
        $currentGalery = Galery::find($id);
        if(empty($currentGalery)){

        } else {
            return response()->json(compact('currentGalery'));
        }
        
    }

    
    public function update(Request $request, $id)
    {
        $galery = Galery::find($id);

        if(empty($galery)){

        } else {
        
            $request->validate([
                'list_location_id' => 'required'
            ]);


            if($request->hasFile('filename')) {

                $request->validate([
                    'filename' => 'required|image|mimes:png,jpeg,jpg'
                ]);
                
                $file = $request->file('filename');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/dolankuy/', $filename);  
                Storage::delete('/public/dolankuy/' . $galery->filename);
            }else{
                $filename=$request->filename;
            }

            $galery->update([
                'list_location_id' => $request->list_location_id,
                'filename' => $filename,
            ]);

            return response()->json($galery);
        }

    }

    
    public function destroy(Request $request, $id)
    {
        $galery = Galery::find($id);
        if(empty($galery)){

        }else {
            Storage::delete('/public/dolankuy/' . $galery->filename);
            $galery->delete();
            return response()->json($galery);
        }
        
    }
}
