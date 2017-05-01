<?php

namespace App\Http\Controllers;

use App\Reservation;
use Illuminate\Http\Request;
use App\Filters\ReservationFilters;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReservationFilters $filters)
    {
        $statuses = Reservation::statuses();
        $labels = Reservation::status_labels();

        $reservations = Reservation::latest()->filter($filters)->by(auth()->id())->paginate(5);

        return view('dashboard')
            ->withReservations($reservations)
            ->withStatuses($statuses)
            ->withLabels($labels);
    }
}
