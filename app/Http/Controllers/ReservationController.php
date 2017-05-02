<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
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
        return redirect(route('dashboard'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $start_at = Carbon::now()->startOfDay()->addHours(8);

        $create = [
            'start_at' => $start_at->format('d M Y g:i A'),
            'end_at' => $start_at->copy()->addHours(8)->format('d M Y g:i A'),
            'submit' => 'Mohon'
        ];

        return view('reservations.create')->withCreate($create);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'destination' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('reservations.create'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $reservation = Reservation::create([
            'user_id' => auth()->id(),
            'reason' => request('reason'),
            'start_at' => request('start_at'),
            'end_at' => request('end_at'),
            'destination' => request('destination'),
        ]);

        return redirect($reservation->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        $user = auth()->user();

        if ($user->cant('update', $reservation)) {
            return redirect()->route('dashboard')
                ->withFlashWarning('Maaf, anda tiada kebenaran untuk mengemaskini tempahan orang lain.');
        }

        return view('reservations.show')
            ->withReservation($reservation)
            ->withUser($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        $user = auth()->user();

        if ($user->cant('update', $reservation)) {
            return redirect()->route('dashboard')
                ->withFlashWarning('Maaf, anda tiada kebenaran untuk mengemaskini tempahan orang lain.');
        }

        return view('reservations.edit')->withReservation($reservation);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        $user = auth()->user();

        if ($user->cant('update', $reservation)) {
            return redirect()->route('dashboard')
                ->withFlashWarning('Maaf, anda tiada kebenaran untuk mengemaskini tempahan orang lain.');
        }

        $validator = Validator::make($request->all(), [
            'reason' => 'required',
            'start_at' => 'required',
            'end_at' => 'required',
            'destination' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect(route('reservations.edit'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $reservation->update($request->except(['_token', '_method']));

        return redirect($reservation->path())->withFlashSuccess('Tempahan telah dikemaskini!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $user = auth()->user();

        if ($user->cant('delete', $reservation)) {
            return redirect()->route('dashboard')
                ->withFlashWarning('Maaf, anda tiada kebenaran untuk menghapus tempahan orang lain.');
        }

        $reservation->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('reservations.index'));
    }
}
