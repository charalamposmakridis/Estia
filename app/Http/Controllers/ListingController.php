<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Listing::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%")
                ->orWhere('city', 'like', "%{$search}%");
        }

        $listings = $query->paginate(10);

        return view('listings.index', compact('listings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Listing::class);
        return view('listings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request)
    {
        $this->authorize('create', Listing::class);

        $data = $request->validated();

        // Διαχείριση του cover_image
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('listings', 'public');
        }

        // Δημιουργία του listing συνδεδεμένου με τον χρήστη
        $listing = $request->user()->listings()->create($data);

        return redirect()->route('listings.show', $listing)->with('success', 'Listing created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $this->authorize('view', $listing);
        $listing->load(['reviews.user','user']);
        return view('listings.show',compact('listing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        $this->authorize('update',$listing);
        return view('listings.edit',compact('listing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        $this->authorize('update', $listing);

        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($listing->cover_image && \Storage::disk('public')->exists($listing->cover_image)) {
                \Storage::disk('public')->delete($listing->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('listings', 'public');
        }

        $listing->update($data);

        return redirect()->route('listings.show', $listing)->with('success', 'Listing updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        $this->authorize('delete',$listing);
        $listing->delete();

        return redirect()->route('listings.index');
    }

    public function myListings(){
        $listings=auth()->user()->listings()->latest()->paginate(20);

        return view('listings.user',compact('listings'));

    }
}
