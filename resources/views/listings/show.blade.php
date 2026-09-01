@extends('layouts.app')

@section('content')
    <div class="listing-detail-container">
        <div class="listing-header-section">
            <h1>{{ $listing->title }}</h1>

            @auth
                @if($listing->user_id === auth()->id())
                    <div class="owner-actions my-2">
                        <a href="{{ route('listings.edit', $listing) }}" class="btn btn-secondary">Edit Listing</a>
                    </div>
                @endif

                <form action="{{ route('favourites.toggle', $listing) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        {{ auth()->user()->favourites->contains($listing) ? 'Remove from Favourites': 'Add to Favourites' }}
                    </button>
                </form>
            @endauth

            <p class="location">{{ $listing->city }}, {{ $listing->country }}</p>
        </div>

        <!-- Image Slider / Gallery -->
        @if($listing->photos->count() > 0)
            <div class="slider-container">
                <div class="slider-wrapper">
                    @foreach($listing->photos as $index => $photo)
                        <div class="slide {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="{{ $listing->title }}">
                        </div>
                    @endforeach
                </div>

                @if($listing->photos->count() > 1)
                    <button type="button" class="slider-btn prev-btn" onclick="moveSlide(-1)">Previous</button>
                    <button type="button" class="slider-btn next-btn" onclick="moveSlide(1)">Next</button>
                @endif
            </div>
        @elseif($listing->cover_image)
            <div class="listing-main-image">
                <img src="{{ asset('storage/' . $listing->cover_image) }}" alt="{{ $listing->title }}">
            </div>
        @endif

        <div class="listing-content-grid">
            <!-- Main Info & Map -->
            <div class="listing-main-info">
                <section class="description-section">
                    <h2>About</h2>
                    <p>{{ $listing->description }}</p>
                </section>

                @if($listing->latitude && $listing->longitude)
                    <section class="map-section">
                        <h2>Location</h2>
                        <div id="single-map"></div>
                    </section>
                @endif
            </div>

            <div class="reviews-section">
                <h3>Reviews</h3>
                @forelse($listing->reviews as $review)
                    <div class="review-card">
                        <strong>{{ $review->user->name ?? 'User' }}</strong>
                        <p>Rating: {{ $review->rating }} / 5</p>
                        <p>{{ $review->comment }}</p>
                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <p>No reviews for this accommodation.</p>
                @endforelse
            </div>

            @can('create', $listing)
                <div class="add-review-form">
                    <h2>Leave your Review.</h2>
                    <form action="{{ route('listings.reviews.store', $listing) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="rating">Rating (1-5):</label>
                            <select name="rating" id="rating" class="form-control" required>
                                <option value="5">5 - Perfect</option>
                                <option value="4">4 - Very Good</option>
                                <option value="3">3 - Good</option>
                                <option value="2">2 - Fair</option>
                                <option value="1">1 - Poor</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="comment">Comment: </label>
                            <textarea name="comment" rows="3" class="form-control" required></textarea>
                        </div>
                        <button class="btn-primary" type="submit">Submit Review</button>
                    </form>
                </div>
            @endcan

            <!-- Booking Sidebar -->
            <div class="listing-sidebar">
                <div class="booking-card">
                    <p class="price-tag"><strong>{{ $listing->price_per_night }} €</strong> / night</p>

                    @auth
                        <form action="{{ route('listings.bookings.store', $listing) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="check_in">Check-in:</label>
                                <input type="date" id="check_in" name="check_in" required>
                            </div>
                            <div class="form-group">
                                <label for="check_out">Check-out:</label>
                                <input type="date" id="check_out" name="check_out" required>
                            </div>
                            <button type="submit" class="btn-book">Book now</button>
                        </form>
                    @else
                        <p><a href="{{ route('login') }}">Log In</a> to make a reservation.</p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Slider Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentIndex = 0;
            const slides = document.querySelectorAll('.slide');

            window.moveSlide = function(direction) {
                if (slides.length === 0) return;

                slides[currentIndex].classList.remove('active');

                currentIndex += direction;

                if (currentIndex >= slides.length) {
                    currentIndex = 0;
                } else if (currentIndex < 0) {
                    currentIndex = slides.length - 1;
                }

                slides[currentIndex].classList.add('active');
            };
        });
    </script>

    <!-- Leaflet Single Map Script -->
    @if($listing->latitude && $listing->longitude)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const lat = {{ $listing->latitude }};
                const lng = {{ $listing->longitude }};

                const singleMap = L.map('single-map').setView([lat, lng], 14);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(singleMap);

                L.marker([lat, lng]).addTo(singleMap)
                    .bindPopup("<b>{{ $listing->title }}</b>")
                    .openPopup();
            });
        </script>
    @endif
@endsection
