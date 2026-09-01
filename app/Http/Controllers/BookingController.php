<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Models\Booking;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Booking::class);
        $bookings=$request->user()->bookings()->with('listing')->paginate(10);

        return view('bookings.index',compact('bookings'));
    }

    public function ownerIndex(Request $request)
    {
        $bookings = Booking::whereHas('listing', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->with('listing', 'user')->paginate(10);

        return view('bookings.owner-index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Listing $listing)
    {
        $this->authorize('create',[Booking::class,$listing]);

        return view('bookings.create',compact('listing'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request, Listing $listing)
    {
        $this->authorize('create',[Booking::class,$listing]);

        $validated=$request->validated();

        $check_in=Carbon::parse($validated['check_in']);
        $check_out=Carbon::parse($validated['check_out']);
        $nights=$check_in->diffInDays($check_out);
        $total_price=$nights * $listing->price_per_night;

        $request->user()->bookings()->create(array_merge(
            $validated, [
                'listing_id'=>$listing->id,
                'total_price'=>$total_price,
                'status'=>'pending'
            ]
        ));

        return redirect()->route('bookings.index')->with('success','Booking created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $this->authorize('view',$booking);
        return view('bookings.show',compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $this->authorize('update', $booking);
        return view('bookings.edit',compact('booking'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $this->authorize('update', $booking);
        $booking->update($request->validated());

        return redirect()->route('bookings.show',$booking)->with('success','Booking updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing,Booking $booking)
    {
        $this->authorize('delete', $booking);
        $booking->delete();

        return redirect()->route('bookings.index')->with('success','Booking deleted successfully');
    }

    public function accept(Booking $booking)
    {
        if (auth()->id() !== $booking->listing->user_id) {
            abort(403);
        }

        $booking->update(['status' => 'confirmed']);

            return back()->with('success', 'Booking accepted.');
    }

    public function reject(Booking $booking)
    {
        if (auth()->id() !== $booking->listing->user_id) {
            abort(403);
        }

        $booking->update(['status' => 'rejected']);

        return back()->with('success', 'Booking rejected.');
    }
}
