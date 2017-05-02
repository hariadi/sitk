<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Filters\VehicleFilters;
use Illuminate\Support\Facades\Validator;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(VehicleFilters $filters)
    {
        $vehicles = Vehicle::latest()->filter($filters)->get();
        return view('vehicles.index')->withVehicles($vehicles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->cant('create', Vehicle::class)) {
            return redirect()->route('vehicles.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan kenderaan.');
        }

        $types = [
            'Car' => 'Kereta',
            'Bus' => 'Bas',
            'Van' => 'Van',
            'Coaster' => 'Coaster',
        ];

        return view('vehicles.create')->withTypes($types);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->cant('create', Vehicle::class)) {
            return redirect()->route('vehicles.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan kenderaan.');
        }

        $validator = Validator::make($request->all(), [
            'registration_no' => 'required',
            'types' => 'required',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('vehicles.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $vehicle = Vehicle::create([
            'registration_no' => request('registration_no'),
            'model' => request('model'),
            'types' => request('types'),
            'capacity' => request('capacity'),
            'image' => request('image'),
        ]);

        return redirect($vehicle->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show')->withVehicle($vehicle);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        $types = [
            'Car' => 'Kereta',
            'Bus' => 'Bas',
            'Van' => 'Van',
            'Coaster' => 'Coaster',
        ];

        return view('vehicles.edit')->withVehicle($vehicle)->withTypes($types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $validator = Validator::make($request->all(), [
            'registration_no' => 'required',
            'types' => 'required',
            'capacity' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('vehicles.edit', $vehicle))
                        ->withErrors($validator)
                        ->withInput();
        }

        $vehicle->update($request->except(['_token', '_method']));

        return redirect($vehicle->path())->withFlashSuccess('Kenderaan telah dikemaskini!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        if (auth()->user()->cant('delete', Vehicle::class)) {
            return redirect()->route('vehicles.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pentadbir sahaja dibenarkan untuk menghapus kenderaan.');
        }

        $vehicle->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('vehicles.index'))->withFlashSuccess('Kenderaan telah dihapus!');
    }
}
