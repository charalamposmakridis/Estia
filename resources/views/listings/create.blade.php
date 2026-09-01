@extends('layouts.app')

@section('content')
    <div class="listing-form-container">
        <h2>Create new listing.</h2>

        <form action="{{route('listings.store')}}" method="POST" enctype="multipart/form-data" class="listing-form">
            @csrf

            <div class="form-group">
                <label for="title">Title: </label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{old('title')}}" required>
                @error('title')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Description: </label>
                <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror" required>{{old('description')}}</textarea>
                @error('description')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="city">City: </label>
                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror" value="{{old('city')}}">
                    @error('city')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="country">Country: </label>
                    <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{old('country')}}" required>
                    @error('country')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="max_guests">Max Guests: </label>
                <input type="number" name="max_guests" id="max_guests" class="form-control @error('max_guests') is-invalid @enderror" value="{{ old('max_guests', 1) }}" required>
                @error('max_guests')
                <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price_per_night">Price per Night (€)</label>
                    <input type="number" step="0.01" id="price_per_night" name="price_per_night" class="form-control @error('price_per_night') is-invalid @enderror" value="{{old('price_per_night')}}" required>
                    @error('price_per_night')
                    <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="cover_image">Cover Image: </label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control-file @error('cover_image') is-invalid @enderror">
                    @error('cover_image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="photos">Upload Photos (Multiple):</label>
                    <input type="file" name="photos[]" id="photos" class="form-control-file @error('photos') is-invalid @enderror" multiple>
                    @error('photos')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                    @error('photos.*')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!--Hidden inputs for coordinates-->
            <input type="hidden" name="latitude" id="latitude" value="{{old('latitude')}}">
            <input type="hidden" name="longitude" id="longitude" value="{{old('longitude')}}">

            <div class="form-group">
                <label>Pin a Location:</label>
                <div id="create-map"></div>
                @error('latitude')
                    <span class="error-message">Select a latitude</span>
                @enderror

                @error('longitude')
                    <span class="error-message">Select a longitude</span>
                @enderror
            </div>
            <button type="submit" class="btn-submit">Create Listing</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const defaultLat = 37.9838;
            const defaultLng = 23.7275;

            const map = L.map('create-map').setView([defaultLat, defaultLng], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            let marker;

            const oldLat = document.getElementById('latitude').value;
            const oldLng = document.getElementById('longitude').value;
            if (oldLat && oldLng) {
                marker = L.marker([oldLat, oldLng]).addTo(map);
                map.setView([oldLat, oldLng], 14);
            }

            map.on('click', function (e) {
                const lat = e.latlng.lat;
                const lng = e.latlng.lng;

                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;

                if (marker) {
                    marker.setLatLng([lat, lng]);
                } else {
                    marker = L.marker([lat, lng]).addTo(map);
                }
            });
        });
    </script>
@endsection
