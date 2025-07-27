<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use Illuminate\Http\Request;
use Validator;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.zone.zone');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'zone' => 'required',
                'coordinate' => 'required',
            ],
            [
                'name.required' => 'Zone name is required',
                'coordinate.required' => 'Coordinate name is required',
            ]
        );
        if ($validate->fails()) {
            return redirect()->back()->with(['error' => $validate->errors()]);
        }

        $zone = new Zone();
        $zone->name = $request->zone;
        $zone->coordinate = $request->coordinate;
        $zone->save();
        return redirect()->back()->with(['success' => 'Zone added successfully!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Zone $zone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Zone $zone)
    {
        $zone->delete();
        return redirect()->back()->with(['success' => 'Zone deleted successfully!']);
    }
}
