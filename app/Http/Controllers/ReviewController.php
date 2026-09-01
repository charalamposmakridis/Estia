<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Models\Listing;
use App\Models\Review;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request, Listing $listing)
    {
        $this->authorize('create', $listing);

        $request->user()->reviews()->create(
          array_merge($request->validated(),[
              'listing_id'=>$listing->id,
          ])
        );

        return redirect()->route('listings.show',$listing)->with('success','Review created successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewRequest $request, Review $review)
    {
        $this->authorize('update', $review);
        $review->update($request->validated());

        return back()->with('success','Review updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);
        $listing=$review->listing;

        $review->delete();

        return redirect()->route('listings.show',$listing)->with('success','Review deleted');
    }
}
