<?php

namespace App\Http\Controllers;

use App\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
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
    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('drivers.index')->withDrivers($drivers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->cant('create', Driver::class)) {
            return redirect()->route('drivers.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan pemandu.');
        }

        return view('drivers.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (auth()->user()->cant('create', Driver::class)) {
            return redirect()->route('drivers.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan pemandu.');
        }

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $driver = Driver::create([
            'name' => request('name'),
            'phone' => request('phone'),
            'email' => request('email'),
            'image' => request('image'),
        ]);

        return redirect($driver->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function show(Driver $driver)
    {
        return view('drivers.show')->withDriver($driver);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function edit(Driver $driver)
    {
        if (auth()->user()->cant('create', Driver::class)) {
            return redirect()->route('drivers.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan pemandu.');
        }

        return view('drivers.edit')->withDriver($driver);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Driver $driver)
    {
        if (auth()->user()->cant('create', Driver::class)) {
            return redirect()->route('drivers.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pelulus atau Pentadbir sahaja dibenarkan untuk mewujudkan pemandu.');
        }

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        $driver->update([
            'name' => request('name'),
            'phone' => request('phone'),
            'email' => request('email'),
            'image' => request('image'),
        ]);

        return redirect($driver->path())->withFlashSuccess('Pemandu telah dikemaskini!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Driver  $driver
     * @return \Illuminate\Http\Response
     */
    public function destroy(Driver $driver)
    {
        if (auth()->user()->cant('delete', Driver::class)) {
            return redirect()->route('drivers.index')->withFlashWarning('Maaf, anda tiada kebenaran. Hanya Pentadbir sahaja dibenarkan untuk menghapus pemandu.');
        }

        $driver->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('drivers.index'))->withFlashSuccess('Pemandu telah dihapus!');
    }
}
