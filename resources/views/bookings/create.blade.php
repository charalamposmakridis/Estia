@extends('layouts.app')

@section('content')
    <div class="booking-container">
        <h2>Booking for: {{ $listing->title }}</h2>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('listings.bookings.store', $listing) }}" method="POST" class="booking-form">
            @csrf

            <div class="form-group">
                <label for="check_in" class="form-label">Check-in</label>
                <input type="date" name="check_in" id="check_in" class="form-input" required>
            </div>

            <div class="form-group">
                <label for="check_out" class="form-label">Check-out</label>
                <input type="date" name="check_out" id="check_out" class="form-input" required>
            </div>

            <button type="submit" class="submit-btn">Submit Booking.</button>
        </form>
    </div>
@endsection
