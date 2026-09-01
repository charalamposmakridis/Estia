@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Reservations for My Listings</h2>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($bookings->count() > 0)
            <div class="bookings-list">
                @foreach($bookings as $booking)
                    <div class="booking-card">
                        @if($booking->listing->cover_image)
                            <img src="{{ asset('storage/' . $booking->listing->cover_image) }}" alt="{{ $booking->listing->title }}">
                        @else
                            <div class="listing-card-placeholder">No image yet.</div>
                        @endif

                        <div class="booking-card-body">
                            <h3>{{ $booking->listing->title }}</h3>
                            <p class="guest-info">
                                <strong>Guest:</strong> {{ $booking->user->name ?? 'Guest' }}
                            </p>
                            <p class="booking-dates">
                                <strong>Check-in:</strong> {{ $booking->check_in }} |
                                <strong>Check-out:</strong> {{ $booking->check_out }}
                            </p>
                            <p class="booking-price">€ {{ number_format($booking->total_price, 2) }}</p>

                            <div class="booking-actions">
                                <a href="{{ route('listings.show', $booking->listing) }}" class="btn btn-secondary">View Listing</a>

                                <form action="{{ route('listings.bookings.destroy', [$booking->listing, $booking]) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this reservation?');" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Cancel Reservation</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-container">
                {{ $bookings->links() }}
            </div>
        @else
            <p class="empty-listings-text">
                There are no reservations for your listings yet.
            </p>
        @endif
    </div>
@endsection
