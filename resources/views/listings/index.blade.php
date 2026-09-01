@extends('layouts.app')

@section('content')
    <div class="listing-headers">
        <h1>Available Accommodations</h1>
    </div>

    <div id="map"></div>

    @if($listings->isNotEmpty())
        <div class="listings-grid">
            @foreach($listings as $listing)
                <div class="listing-card">
                    @if($listing->cover_image)
                        <div class="listing-cover-image">
                            <img src="{{ asset('storage/' . $listing->cover_image) }}" alt="{{ $listing->title }}" class="listing-image">
                        </div>
                    @endif
                    <div class="listing-info">
                        <h3>{{ $listing->title }}</h3>
                        <p class="country">{{ $listing->country }}</p>
                        <p class="city">{{ $listing->city }}</p>
                        <p class="price-per-night">
                            <strong>{{ $listing->price_per_night }}€</strong>
                            /night
                        </p>
                        <a href="{{ route('listings.show', $listing) }}" class="btn-details">View</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination-container">
            {{ $listings->links() }}
        </div>
    @else
        <div class="alert alert-warning">
            @if(request()->filled('search'))
                <p>No listing with this name!</p>
            @else
                <p>There are no available accommodations yet.</p>
            @endif
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const map = L.map('map').setView([39.0742, 21.8243], 6); // Κέντρο Ελλάδας

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap'
            }).addTo(map);

            const listings = @json($listings->items());

            const markers = [];

            listings.forEach(listing => {
                if (listing.latitude && listing.longitude) {
                    const marker = L.marker([listing.latitude, listing.longitude]).addTo(map);

                    marker.bindPopup(`
                        <div style="font-size: 14px;">
                            <b>${listing.title}</b><br>
                            ${listing.city}, ${listing.country}<br>
                            <strong>${listing.price_per_night}€</strong> / βράδυ<br>
                            <a href="/listings/${listing.id}" style="color: blue; text-decoration: underline;">View Listing</a>
                        </div>
                    `);

                    markers.push(marker);
                }
            });

            if (markers.length > 0) {
                const group = L.featureGroup(markers);
                map.fitBounds(group.getBounds().pad(0.1));
            }
        });
    </script>
@endsection
