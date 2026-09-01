<?php

namespace App\Policies;

use App\Models\Listing;
use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReviewPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Review $review): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Listing $listing): bool
    {
        return $listing->bookings()
            ->where('user_id', $user->id)
            ->where('status', 'confirmed')
            ->where('check_out', '<', now())
            ->exists();
    }
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Review $review): bool
    {
        return $review->user_id===$user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Review $review): bool
    {
        return $review->user_id===$user->id;
    }
}
